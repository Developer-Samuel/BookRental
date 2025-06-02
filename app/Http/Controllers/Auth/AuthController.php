<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Http\Responders\JsonResponder;
use App\Http\Requests\Auth\StoreAuthRequest;

use App\Core\Traits\HandlesSafeExecution;

use App\Services\Common\ErrorLogger;
use App\Contracts\Services\Auth\AuthServiceContract;
use App\Trackers\AuthTracker;

final class AuthController
{
    use HandlesSafeExecution;

    /**
     * @param AuthServiceContract $authService
     * @param AuthTracker $authTracker
     * @param ErrorLogger $errorLogger
    */
    public function __construct(
        private readonly AuthServiceContract $authService,
        private readonly AuthTracker $authTracker,
        private readonly ErrorLogger $errorLogger
    ) {}

    /**
     * @return InertiaResponse
    */
    public function show(): InertiaResponse
    {
        return Inertia::render('Pages/Auth/Login');
    }

    /**
     * @param StoreAuthRequest $request
     * @return JsonResponse
     * @throws \Throwable
    */
    public function store(StoreAuthRequest $request): JsonResponse
    {
        return $this->safeExecute(function () use ($request) {
            if ($this->authTracker->tooManyAttempts()) {
                return JsonResponder::response(
                    429,
                    'Too many login attempts. Please wait ' . $this->authTracker->lockoutTimeLeft() . ' seconds.',
                    null,
                    null
                );
            }

            try {
                $this->authService->login(
                    $request->input('email'),
                    $request->input('password')
                );

                $this->authTracker->clearAttempts();

                return JsonResponder::response(
                    200,
                    'Successfully logged in.',
                    null,
                    null
                );
            } catch (\Throwable $e) {
                $this->authTracker->incrementAttempts();

                return JsonResponder::response(
                    401,
                    'Invalid login details.',
                    null,
                    null
                );
            }
        });
    }

    /**
     * @return JsonResponse
    */
    public function destroy(): JsonResponse
    {
        return $this->safeExecute(function () {
            $this->authService->logout();

            return redirect('/login');
        });
    }
}
