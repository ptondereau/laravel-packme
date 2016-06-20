<?php

namespace Ptondereau\Tests\PackMe;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\Validator;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends AbstractTestCase
{
    public function testVerifyIsOk()
    {
        $package = new Package('vendor/package', 'John Smith <john@smith.com>', 'test');
        $validator = new Validator();
        $this->assertTrue($validator->verify($package));
    }

    /**
     * @expectedException \Ptondereau\PackMe\Validators\ValidatorException
     * @expectedExceptionMessage Author is not defined!
     */
    public function testAuthorIsNull()
    {
        $package = new Package();
        $package->setDestination('dummy');
        $package->setName('vendor/name');
        (new Validator())->verify($package);
    }

    /**
     * @expectedException \Ptondereau\PackMe\Validators\ValidatorException
     * @expectedExceptionMessage Package name is not defined!
     */
    public function testPackageNameIsNull()
    {
        $package = new Package(null, null, 'testTest');
        (new Validator())->verify($package);
    }

    /**
     * @expectedException \Ptondereau\PackMe\Validators\ValidatorException
     * @expectedExceptionMessage Package already exists!
     */
    public function testApplicationExists()
    {
        $package = new Package('vendor/name', 'John Smith <john@smith.com>', 'tests');
        (new Validator())->verify($package);
    }
}