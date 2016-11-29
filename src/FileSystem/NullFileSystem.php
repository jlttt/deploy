<?php
/**
 * Created by PhpStorm.
 * User: famille
 * Date: 29/11/2016
 * Time: 09:48
 */

namespace Pmp\Deploy\FileSystem;


class NullFileSystem implements FileSystemInterface
{
    public function getFiles()
    {
        return null;
    }
}