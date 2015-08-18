<?php namespace Wolphy\Auth;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Contract\Auth\Provider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CustomAuthProvider implements Provider
{
    public function authenticate(Request $request, Route $route)
    {

        // Logic to authenticate the request.

        throw new UnauthorizedHttpException('Unable to authenticate with supplied username and password.');
    }
}