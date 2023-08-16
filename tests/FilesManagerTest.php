<?php

use PHPUnit\Framework\TestCase;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use Cibrian\FlysystemV1Bridge\MountManager;

class FilesManagerTest extends TestCase
{
    protected $mountManager;
    public $testFilePath;
    public $testBucketFilePath;
    public $tmpAdapter; 

    protected function setUp(): void
    {
        $this->tmpAdapter = new LocalFilesystemAdapter(__DIR__.'/tmp');
     
        $this->mountManager = new MountManager ([
            'tmp' => new FileSystem($this->tmpAdapter)
        ]);

        $this->testFilePath = __DIR__.'/tmp/testfile.txt';
        $this->testBucketFilePath = 'tmp://testfile.txt';

        $fileContent = "This is the content of the file.\n";

        file_put_contents($this->testFilePath, $fileContent);
    }

    public function testListContents()
    {
        $contents = $this->mountManager->listContents("tmp://");
        $this->assertIsArray($contents);
        $this->assertNotEmpty($contents);
    }

    public function testGetSize()
    {
        $size = $this->mountManager->getSize($this->testBucketFilePath);

        $this->assertIsInt($size);
        $this->assertTrue($size > 0);
    }

    public function testHas()
    {
        $hasFile = $this->mountManager->has($this->testBucketFilePath);

        $this->assertTrue($hasFile);
    }

    public function testMove()
    {
        $source = $this->testBucketFilePath;
        $timestamp = time();
        $destination = "tmp://movedfiles/".$timestamp.".txt";

        $result = $this->mountManager->move($source, $destination);

        $this->assertTrue($result);
        $this->assertFalse($this->mountManager->has($source));
        $this->assertTrue($this->mountManager->has($destination));
    }

    public function testDelete()
    {
        $result = $this->mountManager->delete($this->testBucketFilePath);

        $this->assertTrue($result);
        $this->assertFalse($this->mountManager->has($this->testBucketFilePath));
    }

    public function testWriteAndRead()
    {
        $contents = 'This is test content to be written and read.';
        $timestamp = time();
        $path = "tmp://createdfiles/".$timestamp.".txt";
        $result = $this->mountManager->write($path, $contents);
        $readContents = $this->mountManager->read($path);

        $this->assertTrue($result);
        $this->assertEquals($contents, $readContents);
    }

    public function testCreateDir()
    {
        $timestamp = time();
        $dirPath = 'tmp://dirs/'.$timestamp;
        $result = $this->mountManager->createDir($dirPath);

        $this->assertTrue($result);
        $this->assertTrue($this->mountManager->has($dirPath));
    }

    public function testCopy()
    {
        $source = $this->testBucketFilePath;
        $timestamp = time();
        $destination = "tmp://copiedfiles/".$timestamp.".txt";

        $result = $this->mountManager->copy($source, $destination);

        $this->assertTrue($result);
        $this->assertTrue($this->mountManager->has($destination));
    }

    public function testPut()
    {
        $contents = 'This is test content to be put into a file.';
        $result = $this->mountManager->put($this->testBucketFilePath, $contents);
        $readContents = $this->mountManager->read($this->testBucketFilePath);

        $this->assertTrue($result);
        $this->assertEquals($contents, $readContents);
        $this->assertTrue($this->mountManager->has($this->testBucketFilePath));
    }

    public function testReadAndDelete()
    {
        $contents = $this->mountManager->readAndDelete($this->testBucketFilePath);

        $this->assertEquals("This is the content of the file.\n", $contents);
        $this->assertFalse($this->mountManager->has($this->testBucketFilePath));
    }

    public function testGetMimetype()
    {
        $mimetype = $this->mountManager->getMimetype($this->testBucketFilePath);//.txt file
        $this->assertEquals("text/plain", $mimetype);
    }

    public function testRename()
    {
        $newPath = 'tmp://renamedfile'.time().'.txt'; //Needs to include filesystem mount

        $result = $this->mountManager->rename($this->testBucketFilePath, $newPath);
        $this->assertTrue($result);
        $this->assertFalse($this->mountManager->has($this->testBucketFilePath));
        $this->assertTrue($this->mountManager->has($newPath));
    }

    public function testGetTimestamp()
    {
        $timestamp = $this->mountManager->getTimestamp($this->testBucketFilePath);

        $this->assertIsInt($timestamp);
    }

    public function testDeleteDir()
    {
        $dirPath = 'tmp://pathtodelete';
        $this->mountManager->createDir($dirPath);

        $this->assertTrue($this->mountManager->has($dirPath));

        $result = $this->mountManager->deleteDir($dirPath);

        $this->assertTrue($result);
        $this->assertFalse($this->mountManager->has($dirPath));
    }
}