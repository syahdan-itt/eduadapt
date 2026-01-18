<?php

namespace App\Swagger\Schema;

/**
 * @OA\Schema(
 *    schema="Subject",
 *    type="object",
 *    @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Subject ID"
 *    ),
 *    @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Name of the subject"
 *    ),
 *    @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Description of the subject"
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
 *    )
 * )
 *
 */
class SubjectSchema{}
