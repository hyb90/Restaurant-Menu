<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function updateMenu(Request $request,$id)
    {

        $validated = $request->validate([
            'id'=>'required|exists:menus',
            'name' => 'required|string|max:255|unique:menus,name,' . $id,
            'discount' => 'required|numeric|between:0,100',
        ]);
        $menu= Menu::find($id);
        if($menu){
            $menu->update($validated);
        }
        return $menu;

    }
}
