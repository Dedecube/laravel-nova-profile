<?php

namespace Dedecube\Profile\Http\Controllers;

class InertiaController extends \Illuminate\Routing\Controller
{
    public function __invoke()
    {
        return inertia('Profile');
    }
}
