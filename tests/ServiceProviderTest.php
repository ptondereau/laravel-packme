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

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use YourVendor\YourPackage\DummyClass;

/**
 * This is the service provider test class.
 *
 * @author Firstname Lastname <email@email.com>
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTrait;

    public function testDummyClassIsInjectable()
    {
        $this->assertIsInjectable(DummyClass::class);
    }
}
