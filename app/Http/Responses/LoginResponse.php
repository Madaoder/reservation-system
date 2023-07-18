<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $home = auth()->user()->is_teacher ? config('fortify.home.teacher') : config('fortify.home.student');

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect($home);
    }
}
