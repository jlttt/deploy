<?php
/**
 * Created by PhpStorm.
 * User: famille
 * Date: 29/11/2016
 * Time: 09:14
 */

namespace Pmp\Deploy\FileSystem;


interface FileSystemComparatorInterface
{
    public function setSource(FileSystemInterface $source);
    public function setDestination(FileSystemInterface $destination);

    public function getCreatedFiles();
    public function getDeletedFiles();
    public function getUpdatedFiles();
    public function getUnchangedFiles();

}