<?php

namespace Dedecube\Profile\Contracts;

interface PasswordUpdateRequestInterface
{
    public function rules(): array;
    public function passwordRules(): array;
}
