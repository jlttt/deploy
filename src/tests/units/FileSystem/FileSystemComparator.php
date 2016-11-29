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
    /**
     * @dataProvider dataGetCreatedFiles
     */
    public function testGetCreatedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->assert($assertName);
        $source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->newTestedInstance($source, $destination);
        $this->calling($source)->getFiles = $sourceFiles;
        $this->calling($destination)->getFiles = $destinationFiles;
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
        $this->assert($assertName);
        $source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->newTestedInstance($source, $destination);
        $this->calling($source)->getFiles = $sourceFiles;
        $this->calling($destination)->getFiles = $destinationFiles;
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
        $this->assert($assertName);
        $source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->newTestedInstance($source, $destination);
        $this->calling($source)->getFiles = $sourceFiles;
        $this->calling($destination)->getFiles = $destinationFiles;
        $this->array($this->testedInstance->getUpdatedFiles())->isEqualTo($expectedResult);
    }

    protected function dataGetUpdatedFiles()
    {
        $aFile = ['path' => 'path_1', 'timestamp' => 3];
        $aUpdatedFile = ['path' => 'path_1', 'timestamp' => 4];
        $anotherFile = ['path' => 'path_2', 'timestamp' => 5];
        return [
            [
                'assertName' => "pas de fichiers",
                'sourceFiles' => [],
                'destinationFiles' => [],
                'expectedResult' => [],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ $aUpdatedFile ]
            ],
        ];
    }

    /**
     * @dataProvider dataGetUnchangedFiles
     */
    public function testGetUnchangedFiles($assertName, $sourceFiles, $destinationFiles, $expectedResult)
    {
        $this->assert($assertName);
        $source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->newTestedInstance($source, $destination);
        $this->calling($source)->getFiles = $sourceFiles;
        $this->calling($destination)->getFiles = $destinationFiles;
        $this->array($this->testedInstance->getUnchangedFiles())->isEqualTo($expectedResult);
    }

    protected function dataGetUnchangedFiles()
    {
        $aFile = ['path' => 'path_1', 'timestamp' => 3];
        $aUpdatedFile = ['path' => 'path_1', 'timestamp' => 4];
        $anotherFile = ['path' => 'path_2', 'timestamp' => 5];
        return [
            [
                'assertName' => "pas de fichiers",
                'sourceFiles' => [],
                'destinationFiles' => [],
                'expectedResult' => [],
            ], [
                'assertName' => "pas de fichiers communs",
                'sourceFiles' => [ $anotherFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [],
            ], [
                'assertName' => "fichiers identiques",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => [ $aFile ],
            ], [
                'assertName' => "fichiers communs sans mise a jour",
                'sourceFiles' => [ $aFile ],
                'destinationFiles' => [ $aUpdatedFile ],
                'expectedResult' => [ $aFile ],
            ], [
                'assertName' => "fichiers communs avec mise a jour",
                'sourceFiles' => [ $aUpdatedFile ],
                'destinationFiles' => [ $aFile ],
                'expectedResult' => []
            ],
        ];
    }

}