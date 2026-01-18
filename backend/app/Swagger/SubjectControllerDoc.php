<?php

namespace App\Swagger;


/**
 * @OA\Tag(
 *     name="Subjects",
 *     description="API endpoints for managing subjects"
 * )
 */
class SubjectControllerDoc
{
    /**
     * @OA\Get(
     *     path="/api/admin/subject",
     *     summary="Get all subjects",
     *     tags={"Subjects"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Subject")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/admin/subject/{id}",
     *     summary="Get a subject by ID",
     *     tags={"Subjects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the subject to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/SubjectWithMaterials"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subject not found"
     *     )
     * )
     */
    public function show($id) {}

    /**
     * @OA\Post(
     *     path="/api/admin/subject",
     *     summary="Create a new subject",
     *     tags={"Subjects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subject")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subject created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Subject")
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/api/admin/subject/{id}",
     *     summary="Update a subject by ID",
     *     tags={"Subjects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the subject to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subject")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subject updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Subject")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subject not found"
     *     )
     * )
     */
    public function update($id) {}

    /**
     * @OA\Delete(
     *     path="/api/admin/subject/{id}",
     *     summary="Delete a subject by ID",
     *     tags={"Subjects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the subject to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Subject deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subject not found"
     *     )
     * )
     */
    public function destroy($id) {}
}
