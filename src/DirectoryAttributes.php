<?php

namespace Cibrian\FlysystemV1Bridge;

class DirectoryAttributes extends \League\Flysystem\DirectoryAttributes
{
    public string $type;
    public string $basename;
    public string $path;
    public string $dirname;
    public string $filename;
    public ?int $timestamp;
    public string $filesystem;

    /**
    * @param array<mixed> $extraMetadata
    */
    public function __construct(
        string $path,
        ?string $visibility = null,
        ?int $lastModified = null,
        array $extraMetadata = []
    )
    {
        parent::__construct($path, $visibility, $lastModified, $extraMetadata);
        $this->setBasename($path)
            ->setPath($path)
            ->setFilename($path)
            ->setDirname($path)
            ->setFilesystem($path)
            ->setTimestamp($lastModified)
            ->setType($this->type());
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
        $this->filename = basename($fileName);
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
            'dirname' => $this->dirname,
            'basename' => $this->basename,
            'filename' => $this->filename,
            'filesystem' => $this->filesystem,
        ];
    }

}