<?php

namespace Dedecube\Profile\Http\Requests;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;

class UserDetailRequest extends ResourceDetailRequest
{
    public function __construct()
    {
        $this->setRouteResolver(function () {
            return Route::getRoutes()->match(Request::create('/nova-api/users/1', 'GET'));
        });

        $this->merge([
            'resourceId' => auth()->user()->id,
            'editing' => 'false',
            'editMode' => 'create',
            'display' => 'detail'
        ]);
    }

    /**
     * Determine if the request is sending JSON.
     *
     * @return bool
     */
    public function isJson()
    {
        return true;
    }

    /**
     * Get the class name of the resource being requested.
     *
     * @return class-string<\Laravel\Nova\Resource>
     *
     */
    public function resource()
    {
        return config('nova-profile.user_nova_resource');
    }
}
