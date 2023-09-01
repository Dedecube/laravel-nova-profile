<?php

namespace Dedecube\Profile\Http\Controllers;

use Dedecube\Profile\Http\Requests\UserDetailRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserDetailController
{
    public function __invoke(UserDetailRequest $request)
    {
        app()->bind(NovaRequest::class, fn () => $request);

        /** @var \Illuminate\Database\Eloquent\Model */
        $user = auth()->user();

        /** @var \Laravel\Nova\Resource */
        $userResource = 'App\Nova\User';

        return [
            'fields' => $userResource::make($user)->detailFields($request),
        ];
    }
}
