<?php

namespace App\Rules;

use Illuminate\Validation\Rules\Password;

class StrongPasswordRule extends Password
{
    public function __construct()
    {
        parent::__construct(6);

        $this->letters()
            ->symbols()
            ->mixedCase()
            ->numbers()
            ->max(15);
    }
}
