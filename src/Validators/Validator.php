<?php

namespace Ptondereau\PackMe\Validators;

use Ptondereau\PackMe\Package;
use Ptondereau\PackMe\Validators\Checks\ApplicationExist;
use Ptondereau\PackMe\Validators\Checks\CheckInterface;
use Ptondereau\PackMe\Validators\Checks\GoodAuthor;
use Ptondereau\PackMe\Validators\Checks\GoodName;

class Validator
{
    /**
     * List of checks.
     *
     * @var string[]
     */
    protected $checks = [
        ApplicationExist::class,
        GoodName::class,
        GoodAuthor::class,
    ];

    /**
     * Ensure all Package's parameters are good.
     *
     * @param Package $package
     *
     * @return bool
     */
    public function verify(Package $package)
    {
        foreach ($this->checks as $class) {
            (new $class())->verify($package);
        }

        return true;
    }
}
