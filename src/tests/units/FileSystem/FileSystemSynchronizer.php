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
use Pmp\Deploy\FileSystem\FileSystemComparator;

class FileSystemSynchronizer extends atoum
{
    public function testSynchronize()
    {
        $source = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $destination = new \mock\Pmp\Deploy\FileSystem\FileSystemInterface();
        $this->newTestedInstance($source, $destination);
        $this->testedInstance->synchronize();
        $comparator = new FileSystemComparator($source, $destination);
        $files = $comparator->getUnchangedFiles();
        $this->array($files)->hasSize(count($source->getFiles()));
    }
}