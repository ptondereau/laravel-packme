<?php

namespace Ptondereau\Tests\PackMe;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\Validator;

/**
 * Class PackageTest.
 */
class PackageTest extends AbstractTestCase
{
    public function testSetter()
    {
        $package = new Package();
        $package->setDescription('test');
        $package->setAuthorName('John Smith');
        $package->setEmail('john@smith.com');
        $package->setDestination('test');
        $package->setAuthor('John Smith <john@smith.com>');
        $package->setName('vendor/package');
        $package->setPackage('Package');
        $package->setVendor('Vendor');

        $this->assertSame('test', $package->getDescription());
        $this->assertAttributeSame('test', 'description', $package);
        $this->assertAttributeSame('test', 'destination', $package);
        $this->assertSame(getcwd().'/test', $package->getDestination());
        $this->assertAttributeSame('John Smith <john@smith.com>', 'author', $package);
        $this->assertAttributeSame('John Smith', 'authorName', $package);
        $this->assertAttributeSame('john@smith.com', 'email', $package);
        $this->assertAttributeSame('Package', 'package', $package);
        $this->assertAttributeSame('Vendor', 'vendor', $package);
        $this->assertSame('Vendor', $package->getVendor());
        $this->assertSame('John Smith', $package->getAuthorName());
        $this->assertSame('john@smith.com', $package->getEmail());

        $package->setAuthorName(null);
        $this->assertSame('John Smith', $package->getAuthorName());

        $package->setEmail(null);
        $this->assertSame('john@smith.com', $package->getEmail());
    }

    public function testToArray()
    {
        $validator = $this->getMockBuilder(Validator::class)->disableOriginalConstructor()->getMock();
        $validator->expects($this->once())->method('verify')->willReturn(true);

        $package = new Package('vendor/package', 'John Smith <john@smith.com>', 'test', $validator);

        $result = $package->toArray();
        $expected = [
            'name'        => 'vendor/package',
            'description' => '',
            'vendor'      => 'Vendor',
            'package'     => 'Package',
            'authorName'  => 'John Smith',
            'authorEmail' => 'john@smith.com',
            'config'      => 'package',
        ];

        $this->assertSame($expected, $result);
        $this->assertAttributeSame('Vendor', 'vendor', $package);
        $this->assertAttributeSame('Package', 'package', $package);
        $this->assertAttributeSame('john@smith.com', 'email', $package);
        $this->assertAttributeSame('John Smith', 'authorName', $package);
    }
}
