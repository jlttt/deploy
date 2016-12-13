<?php
namespace Jlttt\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../vendor/autoload.php');

use atoum;

class FlySystemAdapter extends atoum
{
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
        $file = new \Jlttt\Deploy\FileSystem\File($this->testedInstance, 'path', $infos);
        $this->array($this->testedInstance->getFiles())->hasSize(1)->contains($file);;
    }

}