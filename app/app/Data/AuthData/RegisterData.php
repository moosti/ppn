<?php

namespace App\Data\AuthData;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        #[Email]
        #[Unique('users', 'email')]
        public string $email,
        public string $password,
        public string $name,
    ) {}
}
