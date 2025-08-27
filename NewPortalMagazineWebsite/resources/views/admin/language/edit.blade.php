@extends('admin.layouts.master')

@section('title', 'Update Language')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('Language') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Update Language') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.languages.update', $language->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="lang">{{ __('Language') }}</label>
                    <select name="lang" class="form-control select2" id="language-select">
                        <option value="">{{ __('Select Language') }}</option>
                        @foreach (config('language') as $key => $item)
                        <option value="{{ $key }}" {{ $language->lang == $key ? 'selected' : '' }}>{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @error('lang')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" readonly name="name" id="name" class="form-control" value="{{ $language->name }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">{{ __('Slug') }}</label>
                    <input type="text" readonly name="slug" id="slug" class="form-control" value="{{ $language->slug }}">
                    @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_default">{{ __('Is Default?') }}</label>
                    <select name="is_default" class="form-control">
                        <option value="1" {{ $language->is_default == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                        <option value="0" {{ $language->is_default == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                    </select>
                    @error('is_default')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $language->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ $language->status == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#language-select').on('change', function() {
            let value = $(this).val();
            let name = $(this).children('option:selected').text();
            $('#name').val(name);
            $('#slug').val(value);
        });
    });
</script>
@endpush