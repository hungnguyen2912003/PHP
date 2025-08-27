@extends('admin.layouts.master')

@section('title', 'Language')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('Language') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('All Languages') }}</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Create new') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Is Default') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($languages as $language)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->lang }}</td>
                            <td>
                                @if ($language->is_default)
                                    <span class="badge badge-primary">{{ __('Default') }}</span>
                                @else
                                    <span class="badge badge-warning">{{ __('Not Default') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($language->status)
                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.languages.edit', $language->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.languages.destroy', $language->id) }}" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script>
    $("#table-1").DataTable({
        "columnDefs": [{ 
            "sortable": false, 
            "targets":[2,3] 
        }]
    });
</script>
@endpush