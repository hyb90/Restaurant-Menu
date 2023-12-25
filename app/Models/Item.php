<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Searchable,Filterable,HasFactory;

    protected $fillable=["name","code","discount","category_id","price","menu_id"];

    protected $appends = ['discount_price'];

    protected $hidden = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function getCategoriesAttribute()
    {
        $categories = collect([]);

        $category = $this->category;

        while(!is_null($category)) {
            $categories->push($category);
            $category = $category->parent;
        }

        return $categories;
    }
    public function getDiscountPriceAttribute()
    {
        $discount=1.0;
        $discount=(1-$this->menu->discount/100)*$discount;
        foreach ($this->getCategoriesAttribute() as $category){
            $discount=(1-$category->discount/100)*$discount;
        }
        $discount=(1-$this->discount/100)*$discount;
        return number_format(($discount)*$this->price, 2, '.', '');
    }
}
