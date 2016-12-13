<?php
namespace Pmp\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use atoum;
use Pmp\Deploy\FileSystem\File;

class LocalFlySystemAdapter extends atoum
{
    public function test__construct()
    {
    }

    public function testGetFiles()
    {
        $this->mockGenerator->orphanize('__construct');
        $fileSystem = new \mock\League\Flysystem\Filesystem();
        $this->calling($fileSystem)->listFiles = [
            [   'path' => 'path',
                'timestamp' => 123,
                'size' => 456,
                'type' => 'text/plain'
            ]
        ];
        $this->newTestedInstance($fileSystem);
        $infos = [
            'modified' => 123,
            'size' => 456,
            'type' => 'text/plain'
        ];
        $file = new File($this->testedInstance, 'path', $infos);
        $this->array($this->testedInstance->getFiles())->hasSize(1)->contains($file);;
    }

}