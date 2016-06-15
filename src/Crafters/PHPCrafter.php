<?php

namespace Ptondereau\PackMe\Crafters;

use ConstantNull\Backstubber\FileGenerator;
use Illuminate\Support\Str;
use Ptondereau\PackMe\Exception\CrafterException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PHPCrafter.
 */
class PHPCrafter implements Crafter
{
    /**
     * Package name.
     *
     * @var string
     */
    protected $name = null;

    /**
     * Author name.
     *
     * @var string
     */
    protected $author = null;

    /**
     * Path destination for all generated files.
     *
     * @var string
     */
    protected $destination = null;

    /**
     * Package's description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Stube file generator.
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
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Craft the application with parameters.
     *
     * @return mixed
     */
    public function craft()
    {
        $this->verifyParameters();
        $this->verifyApplicationDoesntExist(
            $directory = ($this->destination) ? getcwd().'/'.$this->destination : getcwd()
        );

        $stubPath = realpath(__DIR__.'/../stubs');

        $this->filesystem->mirror($stubPath, $directory);

        $packageInfo = explode('/', $this->name);
        $vendor = Str::studly($packageInfo[0]);
        $package = Str::studly($packageInfo[1]);
        $authorInfo = $this->parseAuthorString($this->author);

        // set delimiters
        $this->stubber->withDelimiters('{{', '}}');

        // set keywords
        $this->stubber->setRaw('author', $this->author)
            ->setRaw('name', $this->name)
            ->setRaw('description', $this->description ?: '')
            ->setRaw('vendor', $vendor)
            ->setRaw('package', $package)
            ->setRaw('authorName', $authorInfo['name'])
            ->setRaw('authorEmail', $authorInfo['email'])
            ->setRaw('config', Str::slug($package));

        $stubFiles = array_merge(glob($directory.'/**/*.stub'), glob($directory.'/{,.}*.stub', GLOB_BRACE));

        foreach ($stubFiles as $stub) {
            $new = pathinfo($stub);
            $this->stubber->useStub($stub);
            if ($this->isConfigFile($new['basename'])) {
                $this->stubber->generate($new['dirname'].'/'.Str::slug($package).'.php');
            } elseif ($this->isServiceProviderFile($new['basename'])) {
                $this->stubber->generate($new['dirname'].'/'.$package.'ServiceProvider.php');
            } else {
                $this->stubber->generate($new['dirname'].'/'.$new['filename']);
            }
            $this->filesystem->remove($stub);
        }
    }

    /**
     * Verify all parameters presence (name, author, destination).
     */
    protected function verifyParameters()
    {
        if (null === $this->name) {
            throw new CrafterException('Package name is not defined!');
        }

        if (null === $this->author) {
            throw new CrafterException('Author is not defined!');
        }

        if (null === $this->destination) {
            throw new CrafterException('Destination folder is not defined!');
        }
    }

    /**
     * Verify that the application does not already exist.
     *
     * @param string $directory
     *
     * @throws CrafterException
     */
    protected function verifyApplicationDoesntExist($directory)
    {
        if ((is_dir($directory) || is_file($directory)) && $directory != getcwd()) {
            throw new CrafterException('Package already exists!');
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

    /**
     * Parse the author string.
     *
     * @private
     *
     * @param string $author
     *
     * @return array
     */
    private function parseAuthorString($author)
    {
        if (preg_match('/^(?P<name>[- \.,\p{L}\p{N}\'’]+) <(?P<email>.+?)>$/u', $author, $match)) {
            return [
                'name'  => trim($match['name']),
                'email' => $match['email'],
            ];
        }
        throw new \InvalidArgumentException(
            'Invalid author string.  Must be in the format: '.
            'John Smith <john@example.com>'
        );
    }
}
