<?php

namespace App\Http\Requests\Items;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreItemRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required',Rule::unique('items','name')->where(fn ($query) => $query->where('menu_id', Auth::user()->menu->id))],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('child_type', "item")
            ],
            'discount'=>'nullable|integer|between:0,100',
            'price'=>'required|numeric'
        ];
    }
}
