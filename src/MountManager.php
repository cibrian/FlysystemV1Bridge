<?php

namespace Cibrian\FlysystemV1Bridge;

use Cibrian\FlysystemV1Bridge\Abstracts\MountManagerBridgeAbstracts;
use League\Flysystem\MountManager as BaseMountManager;

class MountManager extends MountManagerBridgeAbstracts {

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
