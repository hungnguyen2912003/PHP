<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateLanguageHandleRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.language.index');
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
}
