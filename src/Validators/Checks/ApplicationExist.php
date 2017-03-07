<?php

namespace Ptondereau\PackMe\Validators\Checks;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\ValidatorException;

class ApplicationExist implements CheckInterface
{
    /**
     * Make a verification.
     *
     * @param Package $package
     *
     * @throws ValidatorException
     *
     * @return void
     */
    public function verify(Package $package)
    {
        $path = $package->getDestination();

        if (is_dir($path) || is_file($path) || $path === getcwd()) {
            throw new ValidatorException('Package already exists!');
        }
    }
}
