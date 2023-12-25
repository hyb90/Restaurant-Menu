<?php

namespace App\Models;

use \App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\Searchable;

class Category extends Model
{
    use Searchable,Filterable,HasFactory;

    protected $fillable=["name","code","discount","parent_id","menu_id","depth","child_type"];

    /**
     * Get the comments for the blog post.
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class,'parent_id', 'id')->with('subCategories')->with('items');
    }

    public function items()
    {
        return $this->hasMany(Item::class,'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

}
