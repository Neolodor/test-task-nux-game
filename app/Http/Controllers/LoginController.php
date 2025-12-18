<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\IntendedLinkService;
use App\Services\RouletteLinkService;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class LoginController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly IntendedLinkService $intendedLinkService
    ) {
    }

    public function getLoginForm(): Renderable
    {
        return view('login.form');
    }

    public function login(LoginRequest $request): Response
    {
        try {
            $userDTO = $request->getUserDTO();

            $user = $this->userService->firstOrCreate($userDTO);

            Auth::login($user);
            $request->session()->regenerate();

            $intendedUrl = $this->intendedLinkService->get($user);

            return redirect()->to($intendedUrl);
        } catch (\Throwable) {
            throw new HttpException(500, 'Something went wrong');
        }
    }

    public function logout(Request $request): Response
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login.form');
        } catch (\Throwable) {
            throw new HttpException(500, 'Something went wrong');
        }
    }
}
