<?php

namespace App\Swagger;

class MaterialControllerDoc
{
    /**
     * @OA\Get(
     *    path="/api/materials",
     *    tags={"Materials"},
     *    summary="Get all materials for the authenticated user",
     *    @OA\Response(
     *        response=200,
     *        description="List of materials",
     *        @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/Material")
     *        )
     *    )
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *    path="/api/materials/{id}",
     *    tags={"Materials"},
     *    summary="Get a specific material by ID",
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID of the material to retrieve",
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Material details",
     *        @OA\JsonContent(ref="#/components/schemas/Material")
     *    )
     * )
     */
}
