@extends('admin.layouts.master')

@section('title', 'Create Category')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('Category') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Create new Category') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="lang">{{ __('Language') }}</label>
                    <select name="lang" class="form-control select2" id="language-select">
                        <option value="">{{ __('Select Language') }}</option>
                        @foreach ($languages as $language)
                        <option value="{{ $language->lang }}">{{ $language->name }}</option>
                        @endforeach
                    </select>
                    @error('lang')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_show">{{ __('Show at Navigation?') }}</label>
                    <select name="is_show" class="form-control">
                        <option value="1">{{ __('Yes') }}</option>
                        <option value="0" selected>{{ __('No') }}</option>
                    </select>
                    @error('is_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <select name="status" class="form-control">
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0">{{ __('Inactive') }}</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>


@endsection