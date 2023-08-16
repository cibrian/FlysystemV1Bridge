<?php

namespace Cibrian\FlysystemV1Bridge;

class FileAttributes extends \League\Flysystem\FileAttributes
{
    public string $type;
    public string $basename;
    public string $path;
    public string $dirname;
    public string $extension;
    public string $filename;
    public ?int $timestamp;
    public mixed $size;
    public mixed $storageClass;
    public string $filesystem;
    public mixed $etag;

    /**
    * @param array<mixed> $extraMetadata
    */
    public function __construct(
        string $path,
        ?int $fileSize = null,
        ?string $visibility = null,
        ?int $lastModified = null,
        ?string $mimeType = null,
        array $extraMetadata = []
    )
    {
        parent::__construct($path, $fileSize, $visibility, $lastModified, $mimeType, $extraMetadata);
        $this->setBasename($path)
            ->setPath($path)
            ->setFilename($path)
            ->setDirname($path)
            ->setExtension($path)
            ->setFilesystem($path)
            ->setSize($fileSize)
            ->setTimestamp($lastModified)
            ->setStorageClass($extraMetadata['StorageClass'] ?? [])
            ->setEtag($extraMetadata['ETag'] ?? [])
            ->setType($this->type())
        ;
    }

    /**
     * @return string
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * @param string $basename
     * @return static
     */
    public function setBasename(string $basename): static
    {
        preg_match('/[^\/]+$/', $basename, $matches);
        list($baseName) = $matches;
        $this->basename = $baseName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return static
     */
    public function setPath(string $path): static
    {
        preg_match('/(?<=\/\/).*/', $path, $matches);
        list($matchedPath) = $matches;
        $this->path = $matchedPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @param string $dirname
     * @return static
     */
    public function setDirname(string $dirname): static
    {
        preg_match('/(?<=\/\/).+(?<=\/)/', $dirname, $matches);
        $this->dirname = (!empty($matches)) ? trim($matches[0], '\/') : "";
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return static
     */
    public function setExtension(string $extension): static
    {
        preg_match('/\w+$/', $extension, $matches);
        list($ext) = $matches;
        $this->extension = $ext;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return static
     */
    public function setFilename(string $filename): static
    {
        preg_match('/[^\/]+$/', $filename, $matched);
        list($fileName) = $matched;
        $ext = $this->setExtension($filename)->getExtension();
        $this->filename = basename($fileName, ".$ext");
        return $this;
    }

    /**
     * @return string
     */
    public function getFilesystem(): string
    {
        return $this->filesystem;
    }

    /**
     * @param string $filesystem
     * @return static
     */
    public function setFilesystem(string $filesystem): static
    {
        preg_match('/^\w+/', $filesystem, $matches);
        list($fs) = $matches;
        $this->filesystem = $fs;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTimestamp(): int|null
    {
        return $this->timestamp;
    }

    /**
     * @param int|null $timestamp
     * @return static
     */
    public function setTimestamp(int|null $timestamp): static
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize(): mixed
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return static
     */
    public function setSize(mixed $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorageClass(): mixed
    {
        return $this->storageClass;
    }

    /**
     * @param mixed $storageClass
     * @return static
     */
    public function setStorageClass(mixed $storageClass): static
    {
        $this->storageClass = $storageClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtag(): mixed
    {
        return $this->etag;
    }

    /**
     * @param mixed $etag
     * @return static
     */
    public function setEtag(mixed $etag): static
    {
        $this->etag = $etag;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'type' => $this->type,
            'path' => $this->path,
            'timestamp' => $this->timestamp,
            'size' => $this->size,
            'dirname' => $this->dirname,
            'basename' => $this->basename,
            'extension' => $this->extension,
            'filename' => $this->filename,
            'filesystem' => $this->filesystem,
        ];
    }

}