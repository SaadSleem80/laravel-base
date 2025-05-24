<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\MainController;
use App\Http\Requests\Category\CategoryRequest;
use App\Interfaces\Category\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends MainController
{
    private $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $response = $this->categoryRepository->fetchAll();
        if($response instanceof \Illuminate\Pagination\LengthAwarePaginator) 
            return $this->paginatedResponse(__('response.success') , $response , Response::HTTP_OK);
        return $this->response(__('response.success'), $response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $request = $request->validated();
        $saad = "saad";
        $response = $this->categoryRepository->create($request);
        return $this->response(__('response.success'), $response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $response = $this->categoryRepository->find($id);
        return $this->response(__('response.success'), $response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, int $id): JsonResponse
    {
        $request = $request->validated();
        $response = $this->categoryRepository->update($request, $id);
        return $this->response(__('response.success'), $response, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->categoryRepository->delete($id);
        return $this->response(__('response.success'), null, Response::HTTP_NO_CONTENT);
    }
}
