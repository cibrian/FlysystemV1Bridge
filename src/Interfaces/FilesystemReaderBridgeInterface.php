<?php

namespace Cibrian\FlysystemV1Bridge\Interfaces;

use League\Flysystem\DirectoryListing;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToListContents;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;

interface FilesystemReaderBridgeInterface
{
    public const LIST_SHALLOW = false;
    public const LIST_DEEP = true;

    /**
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     */
    public function fileExists(string $location): bool;

    /**
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     */
    public function directoryExists(string $location): bool;

    /**
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     */
    public function has(string $location): bool;

    /**
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function read(string $location): string|false;

    /**
     * @return resource
     *
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function readStream(string $location);

    /**
     * @param string $location
     * @param bool $deep
     * @return array
     *
     * @throws FilesystemException
     * @throws UnableToListContents
     */
    public function listContents(string $location, bool $deep = self::LIST_SHALLOW): array;

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function lastModified(string $path): int;

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function fileSize(string $path): int;

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function mimeType(string $path): string;

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function visibility(string $path): string;
}