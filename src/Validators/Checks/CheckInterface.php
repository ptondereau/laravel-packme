<?php

namespace Ptondereau\PackMe\Validators\Checks;

use Ptondereau\PackMe\Package;

/**
 * Interface CheckInterface
 */
interface CheckInterface
{
    /**
     * Make a verification.
     *
     * @param Package $package
     * @return mixed
     */
    public function verify(Package $package);
}