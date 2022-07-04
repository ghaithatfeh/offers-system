<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->paginate(10);
        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $allCategories = Category::where('status', 1)->get();
        $parentsCategories = [];
        foreach ($allCategories as $category) {
            if (!isset($category->parent->parent))
                $parentsCategories[] = $category;
        }
        return view('categories.create', [
            'parentsCategories' => $parentsCategories
        ]);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect('/categories');
    }

    public function show(Category $category)
    {
        return view('categories.view', ['category' => $category]);
    }

    public function edit(Category $category)
    {
        $allCategories = Category::where('id', '!=', $category->id)->get();
        $parentsCategories = [];
        foreach ($allCategories as $oneCategory) {
            if (!isset($oneCategory->parent->parent) && !in_array($oneCategory->id, $category->children->modelKeys()))
                $parentsCategories[] = $oneCategory;
        }
        return view('categories.edit', [
            'category' => $category,
            'parentsCategories' => $parentsCategories
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect('/categories');
    }

    public function destroy(Category $category)
    {
        if (!json_decode($category->children) && !json_decode($category->offers))
            $category->delete();
        return redirect('/categories');
    }

    public function changeStatus(Category $category)
    {
        $category->update(['status' => !$category->status]);
        return back();
    }

    public function search(Request $request)
    {
        $categories = Category::where('name_en', 'Like', '%' . $request->search . '%')
            ->orWhere('name_ar', 'Like', '%' . $request->search . '%')
            ->paginate(10);
        return view('categories.index', ['categories' => $categories]);
    }
}