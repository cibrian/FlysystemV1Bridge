<?php

namespace Cibrian\FlysystemV1Bridge;

use League\Flysystem\MountManager as BaseMountManager;

class MountManager {

    private $mountManager;

    public function __construct(BaseMountManager $mountManager) {
        $this->mountManager = $mountManager;
    }

    public function listContents(string $location, bool $deep = false) : array {
        $files = $this->mountManager->listContents($location, $deep);
        $contents = [];

        foreach ($files as $file) {
            if ($file instanceof \League\Flysystem\FileAttributes) {
                $file = new FileAttributes(
                    $file->path(),
                    $file->fileSize(),
                    $file->visibility(),
                    $file->lastModified(),
                    $file->mimeType(),
                    $file->extraMetadata()
                );
            } else{
                $file = new DirectoryAttributes(
                    $file->path(),
                    $file->visibility(),
                    $file->lastModified(),
                    $file->extraMetadata()
                );
            }
            $contents[] = $file->toArray();
        }
        return $contents;
    }

    public function has(string $location): bool {
        return $this->mountManager->has($location);
    }

    public function copy(string $from, string $to, array $config = []) : bool {
        try {
            $this->mountManager->copy($from, $to, $config);
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
        return true;
    }

    public function read(string $path) : string|false {
        try {
            return $this->mountManager->read($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getSize(string $path) : int|false {
        try {
            return $this->mountManager->fileSize($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function move(string $from, string $to, array $config = []) : bool {   
        try {
            $this->mountManager->move($from, $to, $config);
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
        return true;
    }

    public function delete(string $path) : bool {
        try {
            $this->mountManager->delete($path);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function write(string $path, string $contents, array $config = []) : bool {
        try {
            $this->mountManager->write($path, $contents, $config);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function createDir(string $dirname, array $config = []) : bool {
        try {
            $this->mountManager->createDirectory($dirname, $config);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function put(string $path, string $contents, array $config = []) : bool {
        return $this->write($path, $contents, $config);
    }

    public function readAndDelete(string $path) : string|false {
        if (!$content = $this->read($path)){
            return false;
        }

        if ($this->delete($path)) {
            return $content;
        }

        return false;
    }

    public function getMimetype(string $path) : string|false {
        try {
            return $this->mountManager->mimeType($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rename(string $path, string $newpath) : bool {
        return $this->move($path, $newpath);
    }

    public function getTimestamp(string $path) : int|false {
        try {
            return $this->mountManager->lastModified($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteDir(string $dirname) : bool {
        try {
            $this->mountManager->deleteDirectory($dirname);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

}
