<?php

namespace App\Swagger;

class AuthControllerDoc
{
    /**
     * @OA\Post(
     *    path="/api/auth/register",
     *    tags={"User register"},
     *    summary="Register a new user",
     *    description="Register a new user in the system and return an sanctum token",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="name", type="string", example="John Doe"),
     *            @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *            @OA\Property(property="password", type="string", format="password", example="password123"),
     *            @OA\Property(property="role", type="integer", example="1"),
     *        ),
     *    ),
     *   @OA\Response(
     *    response=201,
     *    description="User registered successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", example="Bearer <token>"),
     *       @OA\Property(property="token_type", type="string", example="Bearer"),
     *    )
     *   )
     * )
     */
    public function register() {}



    /**
     * @OA\Post(
     *    path="/api/auth/login",
     *    tags={"User login"},
     *    summary="Login a user",
     *    description="Login a user and return an sanctum token",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *            @OA\Property(property="password", type="string", format="password", example="password123"),
     *        ),
     *    ),
     *   @OA\Response(
     *    response=200,
     *    description="User logged in successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", example="Bearer <token>"),
     *       @OA\Property(property="token_type", type="string", example="Bearer"),
     *    )
     *   )
     * )
     */
    public function login() {}


    /**
     * @OA\Post(
     *    path="/api/auth/logout",
     *    tags={"User logout"},
     *    summary="Logout a user",
     *    description="Logout a user and delete the sanctum token",
     *    security={{"sanctum": {}}},
     *    @OA\Header(
     *        header="Authorization",
     *        description="Bearer token",
     *        required=true,
     *        @OA\Schema(
     *            type="string",
     *            example="Bearer <token>"
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="User logged out successfully",
     *        @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Logged out successfully"),
     *        )
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Unauthorized"),
     *        )
     *    )
     * )
     */
    public function logout() {}
}
