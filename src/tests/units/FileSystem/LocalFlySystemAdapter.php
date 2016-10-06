<?php
namespace Pmp\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use atoum;

class LocalFlySystemAdapter extends atoum
{
    public function testConstructor()
    {
        $this
            ->when(
                function () {
                    new \Pmp\Deploy\FileSystem\LocalFlySystemAdapter();
                }
            )
            ->error()
            ->exists();
    }
}