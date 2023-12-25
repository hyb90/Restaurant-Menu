<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Requests\DestroyCategoryRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Resources\CategoryBasicResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * The service instance
     * @var CategoryService
     */
    private CategoryService $categoryService;

    /**
     * Constructor
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('list', Category::class);

        return $this->categoryService->index($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        return $this->responseDataSuccess(['properties' => $this->properties()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $input = $request->validated();
        $record = $this->categoryService->create($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param  Category  $category
     *
     * @return CategoryResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Category $category)
    {
        $this->authorize('view', Category::class);

        $model = $this->categoryService->get($category);
        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category  $category
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Category $category)
    {
        $this->authorize('edit', Category::class);

        return $this->show($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @param  Category  $category
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('edit', Category::class);

        $data = $request->validated();
        if ($this->categoryService->update($category, $data)) {
            return $this->responseUpdateSuccess(['record' => $category->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Update avatar in for specified category
     * @param  UpdateAvatarRequest  $request
     * @param  Category  $category
     * @return JsonResponse
     * @throws AuthorizationException
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy( Category $category)
    {
        $this->authorize('delete', Category::class);

        if ($this->categoryService->delete($category)) {
            return $this->responseDeleteSuccess(['record' => $category]);
        }

        return $this->responseDeleteFail();

    }


    // to use in create new category parent drop list
    public function parents()
    {
        return $this->categoryService->getForCategories();
    }

    // to use in create new Item parent drop list
    public function categories()
    {
        return $this->categoryService->getForItems();
    }

    /**
     * Render properties
     * @return array
     */
    public function properties()
    {
        return [];
    }
}
