<?php

namespace App\Http\Controllers;

use App\Http\Requests\Items\StoreItemRequest;
use App\Http\Requests\Items\UpdateItemRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\Item\ItemService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * The service instance
     * @var ItemService
     */
    private ItemService $itemService;

    /**
     * Constructor
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('list', Item::class);

        return $this->itemService->index($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Item::class);

        return $this->responseDataSuccess(['properties' => $this->properties()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreItemRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreItemRequest $request)
    {
        $this->authorize('create', Item::class);

        $input = $request->validated();
        $record = $this->itemService->create($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param  Item  $item
     *
     * @return ItemResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Item $item)
    {
        $this->authorize('view', Item::class);

        $model = $this->itemService->get($item);
        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Item  $item
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Item $item)
    {
        $this->authorize('edit', Item::class);

        return $this->show($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateItemRequest  $request
     * @param  Item  $item
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->authorize('edit', Item::class);

        $data = $request->validated();
        if ($this->itemService->update($item, $data)) {
            return $this->responseUpdateSuccess(['record' => $item->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Update avatar in for specified item
     * @param  UpdateAvatarRequest  $request
     * @param  Item  $item
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
    public function destroy( Item $item)
    {
        $this->authorize('delete', Item::class);

        if ($this->itemService->delete($item)) {
            return $this->responseDeleteSuccess(['record' => $item]);
        }

        return $this->responseDeleteFail();

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
