@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('Edit Category') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Edit Category') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="lang">{{ __('Language') }}</label>
                    <select name="lang" class="form-control select2" id="language-select">
                        <option value="">{{ __('Select Language') }}</option>
                        @foreach ($languages as $language)
                        <option value="{{ $language->lang }}" {{ $category->lang == $language->lang ? 'selected' : '' }}>{{ $language->name }}</option>
                        @endforeach
                    </select>
                    @error('lang')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_show">{{ __('Show at Navigation?') }}</label>
                    <select name="is_show" class="form-control">
                        <option value="1" {{ $category->is_show == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                        <option value="0" {{ $category->is_show == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                    </select>
                    @error('is_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>


@endsection