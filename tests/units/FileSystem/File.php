<?php

namespace Jlttt\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../vendor/autoload.php');

use atoum;

class File extends atoum
{
    public function testGetModified()
    {
        $this->newTestedInstance(
            new \mock\Jlttt\Deploy\FileSystem\FileSystemInterface,
            'path', [
            'modified' => 12345]
        );
        $this->variable($this->testedInstance->getModified())->isEqualTo(12345);
    }

    public function testMatch()
    {
        $this->newTestedInstance(new \mock\Jlttt\Deploy\FileSystem\FileSystemInterface, 'path');
        $patterns = ['\d', 'dir/sub-dir', '/$[)_-^'];
        $this->boolean($this->testedInstance->match($patterns))->isEqualTo(false);
        $patterns = ['pa'];
        $this->boolean($this->testedInstance->match($patterns))->isEqualTo(true);
    }
}