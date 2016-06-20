<?php

namespace Ptondereau\PackMe\Validators\Checks;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\ValidatorException;

/**
 * Class GoodAuthor.
 */
class GoodAuthor implements CheckInterface
{
    /**
     * Make a verification.
     *
     * @param Package $package
     *
     * @throws ValidatorException
     *
     * @return mixed|void
     */
    public function verify(Package $package)
    {
        if (null === $package->getAuthor() || empty($package->getAuthor())) {
            throw new ValidatorException('Author is not defined!');
        }
    }
}
