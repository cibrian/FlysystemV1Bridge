<?php

namespace Cibrian\FlysystemV1Bridge;

use Cibrian\FlysystemV1Bridge\Abstracts\MountManagerBridgeAbstracts;

class MountManager extends MountManagerBridgeAbstracts {

    public function getSize(string $path) : int|false {
        try {
            return $this->fileSize($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createDir(string $dirname, array $config = []) : bool {
        try {
            $this->createDirectory($dirname, $config);
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
            return $this->mimeType($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rename(string $path, string $newpath) : bool {
        return $this->move($path, $newpath);
    }

    public function getTimestamp(string $path) : int|false {
        try {
            return $this->lastModified($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteDir(string $dirname) : bool {
        try {
            $this->deleteDirectory($dirname);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

}
