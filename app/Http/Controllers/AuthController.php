<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use App\DTO\UserDTO;

class AuthController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Register a new user
     *
     * This endpoint allows a new user to create an account.
     * A valid name, email, and password must be provided.
     *
     * @group Authentication
     * 
     * @bodyParam name string required The user's full name. Example: Rahul Patel
     * @bodyParam email string required The user's email address. Must be unique. Example: rahul@example.com
     * @bodyParam password string required Minimum 6 characters. Example: secret123
     *
     * @response 201 scenario="Success" {
     *   "user": {
     *       "id": 1,
     *       "name": "Rahul Patel",
     *       "email": "rahul@example.com",
     *       "phone": "+91 9876543210",
     *       "gender": "male",
     *       "created_at": "2025-01-01T10:00:00Z"
     *   }
     * }
     *
     * @response 422 scenario="Validation Error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *       "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function register(RegisterRequest $request)
    {
        $data = new UserDTO(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        );

        $user = $this->userService->register($data);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }

    /**
     * Login user
     *
     * This endpoint allows a new user log into their account.
     * A valid email, and password must be provided.
     *
     * @group Authentication
     * 
     * @bodyParam email string required The user's email address. Must be unique. Example: test@example.com
     * @bodyParam password string required Minimum 6 characters. Example: password
     *
     * @response 200 scenario="Success" {
     *   "user": {
     *       "id": 1,
     *       "name": "Rahul Patel",
     *       "email": "rahul@example.com",
     *       "phone": "+91 9876543210",
     *       "gender": "male",
     *       "created_at": "2025-01-01T10:00:00Z"
     *   }
     * }
     *
     * @response 422 scenario="Validation Error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *       "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        return $this->userService->login($data["email"], $data["password"]);
    }
}

