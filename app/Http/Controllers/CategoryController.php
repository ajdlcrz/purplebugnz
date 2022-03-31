<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function store()
    {
        $attr = request()->validate([
            'title' => 'required|string|max:60|unique:categories,title,NULL,id,deleted_at,NULL'
        ]);

        $category = Category::create($attr);

        return response()->json([
            'success' => 'Category created!',
            'category' => $category
        ], 200);
    }

    public function update(Category $category)
    {
        $attr = request()->validate([
            'title' => ['required', 'string', 'max:60', "unique:categories,title,{$category->id},id,deleted_at,NULL"],
        ]);

        $category->update($attr);

        return response()->json(['success' => 'Category updated!'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['success' => 'Category deleted!'], 200);
    }

    public function categoryLists()
    {
        if (request()->wantsJson()) {
            return response()->json(['categories' => Category::get()], 200);
        }
    }
}
