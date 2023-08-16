<?php

namespace Cibrian\FlysystemV1Bridge\Interfaces;

use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\UnableToWriteFile;

interface FilesystemWriterBridgeInterface
{
    /**
     * @throws UnableToWriteFile
     * @throws FilesystemException
     */
    public function write(string $location, string $contents, array $config = []): bool;

    /**
     * @param mixed $contents
     *
     * @throws UnableToWriteFile
     * @throws FilesystemException
     */
    public function writeStream(string $location, $contents, array $config = []): void;

    /**
     * @throws UnableToSetVisibility
     * @throws FilesystemException
     */
    public function setVisibility(string $path, string $visibility): void;

    /**
     * @throws UnableToDeleteFile
     * @throws FilesystemException
     */
    public function delete(string $location): bool;

    /**
     * @throws UnableToDeleteDirectory
     * @throws FilesystemException
     */
    public function deleteDirectory(string $location): void;

    /**
     * @throws UnableToCreateDirectory
     * @throws FilesystemException
     */
    public function createDirectory(string $location, array $config = []): void;

    /**
     * @throws UnableToMoveFile
     * @throws FilesystemException
     */
    public function move(string $source, string $destination, array $config = []): bool;

    /**
     * @throws UnableToCopyFile
     * @throws FilesystemException
     */
    public function copy(string $source, string $destination, array $config = []): bool;
}