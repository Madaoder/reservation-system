<?php

namespace App\Http\Responses;

use App\Http\Controllers\TeacherController;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $home = auth()->user()->is_teacher ? config('fortify.home.teacher') : config('fortify.home.student');

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect($home);
    }
}
