@extends('admin.layouts.master')

@section('title', 'Language')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Language</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create new Language</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.languages.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="lang">Language</label>
                    <select name="lang" class="form-control select2" id="language-select">
                        <option value="">Select Language</option>
                        @foreach (config('language') as $key => $language)
                        <option value="{{ $key }}">{{ $language['name'] }}</option>
                        @endforeach
                    </select>
                    @error('lang')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" readonly name="name" id="name" class="form-control">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" readonly name="slug" id="slug" class="form-control">
                    @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_default">Is Default?</label>
                    <select name="is_default" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0" selected>No</option>
                    </select>
                    @error('is_default')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
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