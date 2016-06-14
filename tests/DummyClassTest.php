<?php
/*
 * This file is part of YourPackage.
 *
 * (c) Firstname Lastname <email@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YourVendor\Tests\YourPackage;
use YourVendor\YourPackage\DummyClass;

/**
 * This is the dummy test class.
 *
 * @author Firstname Lastname <email@email.com>
 */
class DummyClassTest extends TestCase
{
    public function testConstruct()
    {
        $dummy = new DummyClass($this->app['config']);
        $this->assertInstanceOf(DummyClass::class, $dummy);
    }

    public function testGetFoo()
    {
        $dummy = new DummyClass($this->app['config']);
        $this->assertSame('bar', $dummy->getFoo());
    }
}