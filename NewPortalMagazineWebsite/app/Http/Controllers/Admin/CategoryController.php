<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryHandleRequest;
use App\Http\Requests\Admin\UpdateCategoryHandleRequest;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $languages = Language::all();
        return view('admin.category.index', compact('categories', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.category.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryHandleRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->lang = $request->lang;
        $category->is_show = $request->is_show;
        $category->status = $request->status;
        $category->save();
        toast(__('Created category successfully'), 'success')->width('400px');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $category = Category::find($id);
        return view('admin.category.edit', compact('languages', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryHandleRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'lang' => $request->lang,
            'is_show' => $request->is_show,
            'status' => $request->status,
        ]);
        toast(__('Updated category successfully'), 'success')->width('400px');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['status' => 'success', 'message' => __('Category deleted successfully')]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('Category not deleted')]);
        }
    }
}
