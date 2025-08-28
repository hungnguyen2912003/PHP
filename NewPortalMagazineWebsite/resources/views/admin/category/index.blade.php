@extends('admin.layouts.master')

@section('title', __('admin.category.title'))

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Categories') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.category.title') }}</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('admin.category.create_new') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                @foreach ($languages as $language)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" id="home-tab2" data-toggle="tab"
                        href="#home-{{ $language->lang }}" role="tab" aria-controls="home"
                        aria-selected="true">{{ $language->name }}</a>
                </li>
                @endforeach

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                @foreach ($languages as $language)
                @php
                $categories = \App\Models\Category::where('lang', $language->lang)->orderByDesc('id')->get();
                @endphp
                <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                    id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-{{ $language->lang }}">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>{{ __('admin.category.name') }}</th>
                                        <th>{{ __('admin.category.language_code') }}</th>
                                        <th>{{ __('admin.category.in_nav') }}</th>
                                        <th>{{ __('admin.category.status') }}</th>
                                        <th>{{ __('admin.category.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->lang }}</td>
                                        <td>
                                            @if ($category->is_show == 1)
                                            <span class="badge badge-primary">{{ __('admin.yes') }}</span>
                                            @else
                                            <span class="badge badge-danger">{{ __('admin.no') }}</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($category->status == 1)
                                            <span class="badge badge-success">{{ __('admin.yes') }}</span>
                                            @else
                                            <span class="badge badge-danger">{{ __('admin.no') }}</span>
                                            @endif

                                        </td>


                                        <td>
                                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>


    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        $('table[id^="table-"]').dataTable({
            columnDefs: [{
                sortable: false,
                targets: [2, 3]
            }]
        });
    });
</script>
@endpush