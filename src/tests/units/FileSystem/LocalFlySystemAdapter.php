<?php
namespace Pmp\Deploy\tests\units\FileSystem;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use atoum;

class LocalFlySystemAdapter extends atoum
{
    public function test__construct()
    {
        $this
            ->assert('The argument is not a string')
                ->if($this->function->is_string = false)
                ->exception(
                    function () {
                        $this->newTestedInstance('notString');
                    }
                )
            ->assert('The argument is not a valid path')
                ->if($this->function->is_string = true)
                ->if($this->function->file_exists = false)
                ->exception(
                    function () {
                        $this->newTestedInstance('notValidPath');
                    }
                );
    }

//    public function testConstructorFailsWithNotString()
//    {
//        $this
//            ->exception(
//                function () {
//                    $this->newTestedInstance(2);
//                }
//            );
//    }
}