<?php
/**
 * Created by PhpStorm.
 * User: famille
 * Date: 29/11/2016
 * Time: 09:37
 */

namespace Pmp\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use atoum;

class FileSystemComparator extends atoum
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
        return new \Pmp\Deploy\FileSystem\File($fileSystem, $path, $item);
    }

    public function beforeTestMethod($method) {
        $this->source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
    }

    public function init($assertName, $sourceFiles, $destinationFiles, &$expectedResult)
    {
        $this->assert($assertName);
        $this->newTestedInstance($this->source, $this->destination);
        $this->calling($this->source)->getFiles = array_map([$this, 'sourceFile'], $sourceFiles);
        $this->calling($this->destination)->getFiles = array_map([$this, 'destinationFile'], $destinationFiles);
        $expectedResult = array_map([ $this, $expectedResult['type'] ], $expectedResult['files'] );
    }

    /**
     * @dataProvider dataGetCreatedFiles
     */
    public function testGetCreatedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
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
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => $zeroFile ],
            ], [
                'assertName' => "source non vide, destination vide",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $zeroFile,
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => $oneFile ],
            ], [
                'assertName' => "source et destination non vides et identiques",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => $zeroFile ],
            ], [
                'assertName' => "source et destination non vides avec nouveau fichier",
                'sourceFiles' => $severalFiles,
                'destinationFiles' => $oneFile,
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => $otherFile ]
            ],
        ];
    }

    /**
     * @dataProvider dataGetDeletedFiles
     */
    public function testGetDeletedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
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
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => $zeroFile ],
            ], [
                'assertName' => "source vide, destination non vide",
                'sourceFiles' => $zeroFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => $oneFile ],
            ], [
                'assertName' => "source et destination non vides et identiques",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $oneFile,
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => $zeroFile ],
            ], [
                'assertName' => "source et destination non vides avec fichier à supprimer",
                'sourceFiles' => $oneFile,
                'destinationFiles' => $severalFiles,
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => $otherFile ]
            ],
        ];
    }

    /**
     * @dataProvider dataGetUpdatedFiles
     */
    public function testGetUpdatedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this->array($this->testedInstance->getUpdatedFiles())->isEqualTo($expectedResult);
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
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => [] ],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => [] ],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => [] ],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [ 'type' => 'destinationFile', 'files' => [] ],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [ $aUpdatedFile ] ]
            ],
        ];
    }

    /**
     * @dataProvider dataGetUnchangedFiles
     */
    public function testGetUnchangedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->init($assertName, $sourceFiles, $destinationFiles, $expectedResult);
        $this->array($this->testedInstance->getUnchangedFiles())->isEqualTo($expectedResult);
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
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [] ],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [] ],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [ $aFile ] ],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [ $aFile ] ],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ 'type' => 'sourceFile', 'files' => [] ]
            ],
        ];
    }
}