<?php

namespace Ptondereau\PackMe\Crafters;

use Ptondereau\PackMe\Package;

/**
 * Interface Crafter.
 */
interface CrafterInterface
{
    /**
     * Craft the application with parameters.
     *
     * @param Package $package
     * @return mixed
     */
    public function craft(Package $package);
}
