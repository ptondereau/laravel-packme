<?php

namespace Ptondereau\PackMe\Validators\Checks;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\ValidatorException;

/**
 * Class GoodName
 */
class GoodName implements CheckInterface
{
    /**
     * Make a verification.
     *
     * @param Package $package
     * @return void
     * @throws ValidatorException
     */
    public function verify(Package $package)
    {
        if (null === $package->getName() || empty($package->getName())) {
            throw new ValidatorException('Package name is not defined!');
        }
    }
}