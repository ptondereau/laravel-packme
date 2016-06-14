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


use GrahamCampbell\TestBench\AbstractPackageTestCase;
use YourVendor\YourPackage\YourPackageServiceProvider;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return YourPackageServiceProvider::class;
    }
}