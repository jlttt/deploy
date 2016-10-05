<?php
namespace Pmp\Deploy\tests\units;

use atoum;

class Deployer extends atoum
{
    public function testGetCreatedFiles()
    {
        $mockDeployer = new \mock\Deployer();
        $mockDeployer->getMockController()->getSourceFiles = function() {
            return [];
        };
        $mockDeployer->getMockController()->getDestinationFiles = function() {
            return [];
        }; 

    }

    public function testGetUpdatedFiles()
    {

    }

    public function testGetDeletedFiles()
    {

    }
}