<?php

namespace App\Swagger\Schema;

/**
 * @OA\Schema(
 *     schema="SubjectWithMaterials",
 *     type="object",
 *     description="Subject with materials",
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Subject ID"
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Subject name"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Subject description"
 *     ),
 *     @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="Last update timestamp"
 *     ),
 *     @OA\Property(
 *          property="materials",
 *          type="array",
 *          description="List of materials",
 *          @OA\Items(ref="#/components/schemas/Material")
 *     )
 * )
 *
 */
class SubjectWithMaterials{}
