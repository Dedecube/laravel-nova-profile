<?php

namespace Dedecube\Profile\Services;

use Dedecube\Profile\Contracts\PasswordUpdaterInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PasswordUpdater implements PasswordUpdaterInterface
{
    protected Model $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function update(string $password): bool
    {
        return $this->user->update([
            'password' => Hash::make($password),
        ]);
    }
}
