<?php

namespace Dedecube\Profile\Http\Controllers;

use Dedecube\Profile\Contracts\PasswordUpdateRequestInterface;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateController extends Controller
{
    public function __invoke(PasswordUpdateRequestInterface $request)
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->new),
        ]);

        return 1;
    }
}
