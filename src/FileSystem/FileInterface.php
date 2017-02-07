<?php

<<<<<<< HEAD

namespace Jlttt\Deploy\FileSystem;


=======
namespace Jlttt\Deploy\FileSystem;

>>>>>>> 8a7a6eb0a9d46bdd0c94c409f66e20333c70a1bf
interface FileInterface
{
    public function delete();
    public function copyTo(FileSystemInterface $fileSystem);

    public function getPath();
    public function getModified();

    public function match($patterns);
<<<<<<< HEAD
}
=======
}
>>>>>>> 8a7a6eb0a9d46bdd0c94c409f66e20333c70a1bf
