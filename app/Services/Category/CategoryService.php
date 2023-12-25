<?php

namespace App\Services\Category;

use App\Http\Resources\CategoryBasicResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Media\MediaService;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CategoryService
{

    /**
     * The service instance
     * @var MediaService
     */
    protected $mediaService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Get a single resource from the database
     *
     * @param  Category  $category
     *
     * @return CategoryResource
     */
    public function get(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Get resource index from the database
     *
     * @param $query
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($data)
    {
        $query = Category::query();
        if (!empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (!empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (!empty($data['sort_by']) && !empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return CategoryResource::collection($query->paginate(10));
    }

    /**
     * Get resource index from the database
     *
     * @param $query
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getForCategories()
    {
        $categories=Category::where("menu_id",Auth::user()->menu->id)->whereNot("depth",4)->whereNot("child_type","item")->get();
        return CategoryBasicResource::collection($categories);
    }

    public function getForItems()
    {
        $categories=Category::where("menu_id",Auth::user()->menu->id)->where("child_type","item")->get();
        return CategoryBasicResource::collection($categories);
    }

    /**
     * Creates resource in the database
     *
     * @param  array  $data
     *
     * @return Builder|Model|null
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function create(array $data)
    {
        $depth=0;
        if(isset($data["parent_id"])){
            $parent = Category::find($data["parent_id"]);
            if ($parent != null) {
                $depth = $parent->depth + 1;
            }
        }
        $result=array_merge($data,[
            "depth"=>$depth,
            "discount"=>isset($data["discount"])?$data["discount"]:0,
            "code"=>\Str::Slug($data["name"]),
            "menu_id"=>Auth::user()->menu->id
        ]);
        return Category::create(
            $result
        );
    }

    /**
     * Updates resource in the database
     *
     * @param  Category  $category
     * @param  array  $data
     *
     * @return bool
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Category $category, array $data)
    {
        return $category->update($data);
    }

    /**
     * Update avatar for the specified resource
     *
     * @param  Category  $category
     * @param  array  $data
     *
     * @return bool
     */
    public function updateAvatar(Category $category, array $data)
    {
        if (isset($data['avatar']) && $data['avatar']) {
            $this->mediaService->replace($data['avatar'], $category, 'avatars');
        }
        if (!empty($data)) {
            return $category->update($data);
        } else {
            return false;
        }
    }

    /**
     * Deletes resource in the database
     *
     * @param  Category|Model  $category
     *
     * @return bool
     */
    public function delete(Category $category)
    {
        return $category->delete();
    }

    /**
     * Clean the data
     *
     * @param  array  $data
     *
     * @return array
     */
    private function clean(array $data)
    {
        foreach ($data as $i => $row) {
            if ('null' === $row) {
                $data[$i] = null;
            }
        }

        return $data;
    }

    /**
     * Filter resources
     * @return void
     */
    private function filter(Builder &$query, $filters)
    {
        $query->filter(Arr::except($filters, ['role']));

        if (!empty($filters['role'])) {
            $roleFilter = Filterable::parseFilter($filters['role']);
            if (!empty($roleFilter)) {
                if (is_array($roleFilter[2])) {
                    $query->whereIs(...$roleFilter[2]);
                } else {
                    $query->whereIs($roleFilter[2]);
                }
            }
        }

    }
}
