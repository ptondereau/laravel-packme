<?php

namespace Ptondereau\Tests\PackMe\Crafters;

use ConstantNull\Backstubber\FileGenerator;
use Ptondereau\PackMe\Crafters\CrafterInterface;
use Ptondereau\PackMe\Crafters\PHPCrafter;
use Ptondereau\PackMe\Package;
use Ptondereau\Tests\PackMe\AbstractTestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PHPCrafterTest.
 */
class PHPCrafterTest extends AbstractTestCase
{
    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @var FileGenerator
     */
    protected $stubber;

    /**
     * @before
     */
    public function setUpDependencies()
    {
        $this->fs = new Filesystem();
        $this->stubber = new FileGenerator();
    }

    public function testConstruct()
    {
        $crafter = new PHPCrafter($this->stubber, $this->fs);
        $this->assertInstanceOf(CrafterInterface::class, $crafter);
    }

    public function testCrafting()
    {
        if (is_dir(__DIR__.'/../output/test')) {
            $this->removeOutput();
        }

        $package = new Package('vendor/package', 'John Smith <john@smith.com>', 'tests/output/test');
        
        $crafter = new PHPCrafter($this->stubber, $this->fs);
        $crafter->craft($package);

        $outputpath = realpath(__DIR__.'/../output/test');

        $this->assertFileExists($outputpath.'/config/package.php');
        $this->assertFileExists($outputpath.'/src/PackageServiceProvider.php');
        $this->assertFileExists($outputpath.'/src/DummyClass.php');
        $this->assertFileExists($outputpath.'/src/Facades/DummyClass.php');
        $this->assertFileExists($outputpath.'/tests/TestCase.php');
        $this->assertFileExists($outputpath.'/tests/ServiceProviderTest.php');
        $this->assertFileExists($outputpath.'/tests/DummyClassTest.php');
        $this->assertFileExists($outputpath.'/tests/Facades/DummyClassTest.php');
        $this->assertFileExists($outputpath.'/.gitattributes');
        $this->assertFileExists($outputpath.'/.gitignore');
        $this->assertFileExists($outputpath.'/.travis.yml');
        $this->assertFileExists($outputpath.'/CHANGELOG.md');
        $this->assertFileExists($outputpath.'/CONTRIBUTING.md');
        $this->assertFileExists($outputpath.'/LICENSE');
        $this->assertFileExists($outputpath.'/README.md');
        $this->assertFileExists($outputpath.'/composer.json');
        $this->assertFileExists($outputpath.'/phpunit.xml.dist');

        $this->removeOutput();
    }

    /**
     * Remove the output craft folder.
     *
     * @return void
     */
    protected function removeOutput()
    {
        $it = new \RecursiveDirectoryIterator(
            __DIR__.'/../output/test',
            \RecursiveDirectoryIterator::SKIP_DOTS
        );
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir(__DIR__.'/../output/test');
    }
}
