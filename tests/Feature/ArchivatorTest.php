<?php

namespace Tests\Feature;

use App\Http\Services\Archivator\Archivator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Caster\ReflectionCaster;
use Tests\TestCase;

class ArchivatorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_init()
    {
        $mockFile = UploadedFile::fake()->create('example.jpg');
        $archivator = new Archivator($mockFile, 'zip');
//        $this->assertInstanceOf(Archivator::class, $archivator->createArchive());
        $archivatorProperties = init($archivator, Archivator::class, ['filePath', 'fileName', 'fileUniqueName', 'archiveType']);
        foreach ($archivatorProperties as $archivatorProperty) {
            $this->assertNotNull($archivatorProperty);
        }
    }

    public function test_archivate()
    {
        $mockFile = UploadedFile::fake()->create('example.jpg');
        $archivator = new Archivator($mockFile, 'zip');
        $archivator->createArchive();
        $archivatorProperties = init($archivator, Archivator::class, ['archivePath']);
        foreach ($archivatorProperties as $archivatorProperty) {
            $this->assertNotNull($archivatorProperty);
            $this->assertFileExists($archivatorProperty);
        }

    }
}
function init(object $object, string $class, array $properties)
{
    $result = [];
    foreach ($properties as $property) {
        $property = new \ReflectionProperty($class, $property);
        $property->setAccessible(true);
        $result[] = $property->getValue($object);
    }
    return $result;
}
