<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateLanguageHandleRequest;
use App\Http\Requests\Admin\UpdateLanguageHandleRequest;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.language.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.language.create');
    }

    public function store(CreateLanguageHandleRequest $request)
    {
        $language = new Language();
        $language->name = $request->name;
        $language->lang = $request->lang;
        $language->slug = $request->slug;
        $language->is_default = $request->is_default;
        $language->status = $request->status;
        $language->save();
        toast()->success(__('Language created successfully'))->width('400px');
        return redirect()->route('admin.languages.index');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit', compact('language'));
    }

    public function update(UpdateLanguageHandleRequest $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->lang = $request->lang;
        $language->slug = $request->slug;
        $language->is_default = $request->is_default;
        $language->status = $request->status;
        $language->save();
        toast()->success(__('Language updated successfully'))->width('400px');
        return redirect()->route('admin.languages.index');
    }

    public function destroy($id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->delete();
            return response()->json(['status' => 'success', 'message' => __('Language deleted successfully')]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('Language not deleted')]);
        }
    }
}
