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
                    <label for="name">Language Name</label>
                    <select name="name" class="form-control">
                        <option value="">Select Language</option>
                        <option value="en">English</option>
                        <option value="id">Indonesia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="code">Slug</label>
                    <input type="text" readonly name="slug" class="form-control">
                </div>
                <div class="form-group">
                    <label for="is_default">Is Default?</label>
                    <select name="is_default" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</section>


@endsection