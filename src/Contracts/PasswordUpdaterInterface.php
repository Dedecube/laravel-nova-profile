<?php

namespace Dedecube\Profile\Contracts;

interface PasswordUpdaterInterface
{
    public function update(string $password): bool;
}
