<?php

namespace Ptondereau\PackMe\Crafters;

use ConstantNull\Backstubber\FileGenerator;
use Illuminate\Support\Str;
use Ptondereau\PackMe\Package;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PHPCrafter.
 */
class PHPCrafter implements CrafterInterface
{
    /**
     * Stub file generator.
     *
     * @var FileGenerator
     */
    protected $stubber;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * PHPCrafter constructor.
     *
     * @param FileGenerator $stubber
     * @param Filesystem    $filesystem
     */
    public function __construct(FileGenerator $stubber, Filesystem $filesystem)
    {
        $this->stubber = $stubber;
        $this->filesystem = $filesystem;
    }

    /**
     * Craft the application with parameters.
     *
     * @param Package $package
     *
     * @return void
     */
    public function craft(Package $package)
    {
        $stubPath = realpath(__DIR__.'/../stubs');

        // set delimiters
        $this->stubber->withDelimiters('{{', '}}');

        // set keywords
        $this->stubber->setRaw($package->toArray());

        $this->filesystem->mirror($stubPath, $package->getDestination());

        // array of all stub files
        $stubFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $package->getDestination(),
                \RecursiveDirectoryIterator::SKIP_DOTS
            )
        );

        // find and replace
        foreach ($stubFiles as $stub) {
            $new = pathinfo($stub);
            $this->stubber->useStub($stub);
            if ($this->isConfigFile($new['basename'])) {
                $this->stubber->generate($new['dirname'].'/'.Str::slug($package->getPackage()).'.php');
            } elseif ($this->isServiceProviderFile($new['basename'])) {
                $this->stubber->generate($new['dirname'].'/'.$package->getPackage().'ServiceProvider.php');
            } else {
                $this->stubber->generate($new['dirname'].'/'.$new['filename']);
            }
            $this->filesystem->remove($stub);
        }
    }

    /**
     * Detect if a file is the config file.
     *
     * @param $file
     *
     * @return bool
     */
    private function isConfigFile($file)
    {
        return $file === 'package.php.stub';
    }

    /**
     * Detect if a file is the service provider file.
     *
     * @param $file
     *
     * @return bool
     */
    private function isServiceProviderFile($file)
    {
        return $file === 'ServiceProvider.php.stub';
    }
}
