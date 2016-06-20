<?php

namespace Ptondereau\PackMe;

use Illuminate\Support\Str;
use Ptondereau\PackMe\Validators\Validator;

/**
 * Class Package.
 */
class Package
{
    /**
     * Full name of package. (e.g: vendor/package).
     *
     * @var string
     */
    protected $name;

    /**
     * Package name (e.g: YourPackage).
     *
     * @var string
     */
    protected $package;

    /**
     * Vendor name (e.g: YourVendor).
     *
     * @var string
     */
    protected $vendor;

    /**
     * Full author string. (e.g: John Smith <john@example.com>).
     *
     * @var string
     */
    protected $author;

    /**
     * Author's email.
     *
     * @var string
     */
    protected $email;

    /**
     * Author's full name.
     *
     * @var string
     */
    protected $authorName;

    /**
     * Package's description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Path destination for all generated files.
     *
     * @var string
     */
    protected $destination;

    /**
     * Validator for the package.
     *
     * @var Validator
     */
    protected $validator;

    /**
     * Package constructor.
     *
     * @param Validator   $validator
     * @param null|string $name
     * @param null|string $author
     * @param null|string $destination
     */
    public function __construct($name = null, $author = null, $destination = null, Validator $validator = null)
    {
        $this->validator = $validator ?: new Validator();
        $this->name = $name;
        $this->author = $author;
        $this->destination = $destination;
    }

    /**
     * Return keywords list.
     *
     * @return array
     */
    public function toArray()
    {
        $this->validator->verify($this);

        $this->parseAuthor($this->author);

        $packageInfo = explode('/', $this->name);

        $this->vendor = Str::studly($packageInfo[0]);
        $this->package = Str::studly($packageInfo[1]);

        return [
            'name'        => $this->name,
            'description' => $this->description ?: '',
            'vendor'      => $this->vendor,
            'package'     => $this->package,
            'authorName'  => $this->authorName,
            'authorEmail' => $this->email,
            'config'      => Str::slug($this->package),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param string $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        if (!$this->email && $this->author) {
            $this->parseAuthor($this->author);
        }

        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        if (!$this->authorName && $this->author) {
            $this->parseAuthor($this->author);
        }

        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return getcwd().'/'.$this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @param $string
     */
    protected function parseAuthor($string)
    {
        if (preg_match('/^(?P<name>[- \.,\p{L}\p{N}\'’]+) <(?P<email>.+?)>$/u', $string, $match)) {
            $this->email = $match['email'];
            $this->authorName = trim($match['name']);
        }
    }
}
