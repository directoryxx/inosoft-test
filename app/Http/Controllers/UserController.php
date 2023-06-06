<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     tags={"Auth"},
     *     description="Register Endpoint",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="name", type="boolean", example="angga"),
     *              @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *              @OA\Property(property="password_confirmation", type="string", example="PassWord12345"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data["password"] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);

        $user["token"] = $user->createToken('auth_token')->plainTextToken;

        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Auth"},
     *     description="Login Endpoint",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        
        $user = $this->userRepository->filter($data)->first();

        if (! $user){
            return ['message' => "Login Failed"];
        }

        if (! Hash::check($data['password'], $user->password)){
            return ['message' => "Login Failed"];            
        }

        $user["token"] = $user->createToken('auth_token')->plainTextToken;

        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/profile",
     *     tags={"Auth"},
     *     description="profile Endpoint",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function profile()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/logout",
     *     tags={"Auth"},
     *     description="logout Endpoint",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ['success' => true];
    }
}
