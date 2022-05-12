<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);
        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = Category::all();
        $parentsCategories = [];
        foreach ($allCategories as $category) {
            if (!isset($category->parent->parent))
                $parentsCategories[] = $category;
        }
        return view('categories.create', [
            'parentsCategories' => $parentsCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        Category::create($request->all());
        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.view', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $allCategories = Category::where('id', '!=', $category->id)->get();
        $parentsCategories = [];
        foreach ($allCategories as $oneCategory) {
            if (!isset($oneCategory->parent->parent))
                $parentsCategories[] = $oneCategory;
        }
        return view('categories.edit', [
            'category' => $category,
            'parentsCategories' => $parentsCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        $category->update($request->all());
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories');
    }

    public function changeStatus(Category $category)
    {
        $category->status = $category->status ? 0 : 1;
        $category->update();
        // foreach ($category->children as $category) {
        //     $category->status = $category->status ? 0 : 1;
        //     $category->update();
        //     foreach ($category->children as $category) {
        //         $category->status = $category->status ? 0 : 1;
        //         $category->update();
        //     }
        // }
        return redirect('/categories');
    }

    public function search(Request $request)
    {
        $categories = Category::where('name_en', 'Like', '%' . $request->search . '%')
            ->orWhere('name_ar', 'Like', '%' . $request->search . '%')
            ->paginate(3);
        return view('categories.index', ['categories' => $categories]);
    }
}
