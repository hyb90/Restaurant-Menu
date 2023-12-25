<?php

namespace App\Services\Item;

use App\Http\Resources\ItemResource;
use App\Models\Item;
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

class ItemService
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
     * @param  Item  $item
     *
     * @return ItemResource
     */
    public function get(Item $item)
    {
        return new ItemResource($item);
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
        $query = Item::query();
        if (!empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (!empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (!empty($data['sort_by']) && !empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return ItemResource::collection($query->paginate(10));
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
        $result=array_merge($data,[
            "discount"=>isset($data["discount"])?$data["discount"]:0,
            "code"=>\Str::Slug($data["name"]),
            "menu_id"=>Auth::user()->menu->id
        ]);
        return Item::create(
            $result
        );
    }

    /**
     * Updates resource in the database
     *
     * @param  Item  $item
     * @param  array  $data
     *
     * @return bool
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Item $item, array $data)
    {
        $data = $this->clean($data);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $roles = Data::take($data, 'roles');

        unset($data['email']);

        if (isset($data['avatar']) && $data['avatar']) {
            $this->mediaService->replace($data['avatar'], $item, 'avatars');
        }

        if (!empty($roles)) {
            Bouncer::sync($item)->roles($roles);
        }

        return $item->update($data);
    }

    /**
     * Update avatar for the specified resource
     *
     * @param  Item  $item
     * @param  array  $data
     *
     * @return bool
     */
    public function updateAvatar(Item $item, array $data)
    {
        if (isset($data['avatar']) && $data['avatar']) {
            $this->mediaService->replace($data['avatar'], $item, 'avatars');
        }
        if (!empty($data)) {
            return $item->update($data);
        } else {
            return false;
        }
    }

    /**
     * Deletes resource in the database
     *
     * @param  Item|Model  $item
     *
     * @return bool
     */
    public function delete(Item $item)
    {
        return $item->delete();
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
