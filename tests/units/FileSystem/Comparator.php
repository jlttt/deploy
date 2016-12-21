<?php
/**
 * Created by PhpStorm.
 * User: famille
 * Date: 29/11/2016
 * Time: 09:37
 */

namespace Jlttt\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../vendor/autoload.php');

use atoum;

class Comparator extends atoum
{
    protected $source;
    protected $destination;

    private function sourceFile($item) {
        return $this->file($this->source, $item);
    }

    private function destinationFile($item) {
        return $this->file($this->destination, $item);
    }

    private function file($fileSystem, $item) {
        $path = $item['path'];
        unset($item['path']);
        return new \Jlttt\Deploy\FileSystem\File($fileSystem, $path, $item);
    }

    public function beforeTestMethod($method) {
        $this->source = new \mock\Jlttt\Deploy\FileSystem\FileSystemInterface();
        $this->destination = new \mock\Jlttt\Deploy\FileSystem\FileSystemInterface();
    }

    public function init($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->assert($assertName);
        $this->newTestedInstance($this->source, $this->destination);
        $this->calling($this->source)->getFiles = array_map([$this, 'sourceFile'], $sourceFiles);
        $this->calling($this->destination)->getFiles = array_map([$this, 'destinationFile'], $destinationFiles);
    }

    /**
     * @dataProvider dataGetCreatedFiles
     */
    public function testGetCreatedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $expectedResult = array_map([ $this, 'sourceFile'], $expectedResult);
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this->array($this->testedInstance->getCreatedFiles())->isEqualTo($expectedResult);
    }

    protected function dataGetCreatedFiles()
    {
        $zeroFile = [];
        $oneFile = [ [ 'path' => 'path_1'] ];
        $otherFile = [ [ 'path' => 'path_2'] ];
        $severalFiles = [ [ 'path' => 'path_1'], [ 'path' => 'path_2' ] ];

        return [
            [
                'assertName' => "source vide",
                'sourceFiles' => $zeroFile,
                'destinationFiles' => $severalFiles,
                'expectedResult' => $zeroFile,
            ], [
                'assertName' => "source non vide, destination vide",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $zeroFile,
                'expectedResult' => $oneFile,
            ], [
                'assertName' => "source et destination non vides et identiques",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => $zeroFile,
            ], [
                'assertName' => "source et destination non vides avec nouveau fichier",
                'sourceFiles' => $severalFiles,
                'destinationFiles' => $oneFile,
                'expectedResult' => $otherFile
            ],
        ];
    }

    /**
     * @dataProvider dataGetDeletedFiles
     */
    public function testGetDeletedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $expectedResult = array_map([ $this, 'DestinationFile'], $expectedResult);
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this->array($this->testedInstance->getDeletedFiles())->isEqualTo($expectedResult);
    }

    protected function dataGetDeletedFiles()
    {
        $zeroFile = [];
        $oneFile = [ [ 'path' => 'path_1'] ];
        $otherFile = [ [ 'path' => 'path_2'] ];
        $severalFiles = [ [ 'path' => 'path_1'], [ 'path' => 'path_2' ] ];

        return [
            [
                'assertName' => "destination vide",
                'sourceFiles' => $severalFiles,
                'destinationFiles' => $zeroFile,
                'expectedResult' => $zeroFile,
            ], [
                'assertName' => "source vide, destination non vide",
                'sourceFiles' => $zeroFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => $oneFile,
            ], [
                'assertName' => "source et destination non vides et identiques",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => $zeroFile,
            ], [
                'assertName' => "source et destination non vides avec fichier à supprimer",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $severalFiles,
                'expectedResult' => $otherFile
            ],
        ];
    }

    /**
     * @dataProvider dataGetUpdatedFiles
     */
    public function testGetUpdatedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this
            ->array($this->testedInstance->getUpdatedFiles())
            ->isEqualTo(array_map([ $this, 'sourceFile'], $expectedResult['sourceFile']));

        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this
            ->array($this->testedInstance->getUpdatedFiles(\Jlttt\Deploy\FileSystem\Comparator::DESTINATION_FILE))
            ->isEqualTo(array_map([ $this, 'destinationFile'], $expectedResult['destinationFile']));
    }

    protected function dataGetUpdatedFiles()
    {
        $aFile = ['path' => 'path_1', 'modified' => 3];
        $aUpdatedFile = ['path' => 'path_1', 'modified' => 4];
        $anotherFile = ['path' => 'path_2', 'modified' => 5];
        return [
            [
                'assertName' => "pas de fichiers",
                'sourceFiles' => [],
                'destinationFiles' => [],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [$aUpdatedFile], 'destinationFile' => [$aFile] ]
            ],
        ];
    }

    /**
     * @dataProvider dataGetUnchangedFiles
     */
    public function testGetUnchangedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this
            ->array($this->testedInstance->getUnchangedFiles())
            ->isEqualTo(array_map([ $this, 'sourceFile'], $expectedResult['sourceFile']));

        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this
            ->array($this->testedInstance->getUnchangedFiles(\Jlttt\Deploy\FileSystem\Comparator::DESTINATION_FILE))
            ->isEqualTo(array_map([ $this, 'destinationFile'], $expectedResult['destinationFile']));
    }

    protected function dataGetUnchangedFiles()
    {
        $aFile = ['path' => 'path_1', 'modified' => 3];
        $aUpdatedFile = ['path' => 'path_1', 'modified' => 4];
        $anotherFile = ['path' => 'path_2', 'modified' => 5];
        return [
            [
                'assertName' => "pas de fichiers",
                'sourceFiles' => [],
                'destinationFiles' => [],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [ $aFile ], 'destinationFile' => [ $aFile ] ],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [ 'sourceFile' => [ $aFile ], 'destinationFile' => [ $aUpdatedFile ] ],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'sourceFile' => [], 'destinationFile' => [] ],
            ],
        ];
    }
}