<?php

namespace App\Swagger\Schema;

/**
 * @OA\Schema(
 *    schema="Material",
 *    type="object",
 *    @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Material ID"
 *    ),
 *    @OA\Property(
 *          property="subject_id",
 *          type="integer",
 *          description="Subject ID"
 *    ),
 *    @OA\Property(
 *          property="title",
 *          type="string",
 *          description="Title of the material"
 *    ),
 *    @OA\Property(
 *          property="content_text",
 *          type="string",
 *          description="Content text of the material"
 *    ),
 *    @OA\Property(
 *          property="difficulty",
 *          type="string",
 *          description="Difficulty level of the material",
 *          enum={"easy", "medium", "hard"}
 *    ),
 *    @OA\Property(
 *          property="created_by",
 *          type="integer",
 *          description="ID of the user who created the material"
 *    ),
 *    @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="Creation timestamp"
 *    ),
 *    @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="Last update timestamp"
 *    ),
 * )
 *
 */
class MaterialSchema {}
