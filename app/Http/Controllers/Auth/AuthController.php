<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends MainController
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(ref="App\Http\Requests\Auth\LoginRequest")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     * )
     */
    public function login(LoginRequest $request) : JsonResponse
    {
        $request = $request->validated();
        $response = $this->service->login($request);
        return $this->response(__('response.success'), $response, Response::HTTP_OK);
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="App\Http\Requests\Auth\RegisterRequest")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     * )
     */
    public function register(RegisterRequest $request) : JsonResponse
    {
        $request = $request->validated();
        $response = $this->service->register($request);
        return $this->response(__('response.success'), new UserResource($response), Response::HTTP_CREATED);
    }

    /**
     * @OA\POST(
     *    path="/api/v1/auth/forget-password",
     *    summary="Forget password",
     *    tags={"Auth"},
     *    @OA\RequestBody(
     *         @OA\JsonContent(ref="App\Http\Requests\Auth\ForgetPasswordRequest")
     *     ),
     *    @OA\Response(response="200", description="Success"),
     * )
     */
    public function forgetPassword(ForgetPasswordRequest $request) : JsonResponse
    {
        $request = $request->validated();
        $this->service->forgetPassword($request);
        return $this->response(__('response.success'), null, Response::HTTP_OK);
    }

    /**
     * @OA\POST(
     *    path="/api/v1/auth/reset-password",
     *    summary="Reset password",
     *    tags={"Auth"},
     *    @OA\RequestBody(
     *          @OA\JsonContent(ref="App\Http\Requests\Auth\ResetPasswordRequest")
     *    ),
     *    @OA\Response(response="200", description="Success"),
     * )
     */
    public function resetPassword(ResetPasswordRequest $request) : JsonResponse
    {
        $request = $request->validated();
        $this->service->resetPassword($request);
        return $this->response(__('response.success'), null, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="Logout a user",
     *     tags={"Auth"},
     *     @OA\Response(response="200", description="Success"),
     * )
     */
    public function logout() :JsonResponse
    {
        $this->service->logout();
        return $this->response(__('response.success'), null, Response::HTTP_OK);
    }
}
