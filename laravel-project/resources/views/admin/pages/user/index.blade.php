@extends('admin.layouts.admin-layout')

@section('title', 'Users')

@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-sub-header">
                <h3 class="page-title">Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users') }}">User</a>
                    </li>
                    <li class="breadcrumb-item active">
                        All Users
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="student-group-form">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search by Name ..." />
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search by Phone ..." />
            </div>
        </div>
        <div class="col-lg-2">
            <div class="search-student-btn">
                <button type="btn" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">
                                Users
                            </h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="#" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
                            <a href="#" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
                            <a href="{{ route('admin.users.add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                 </div>

                <div class="table-responsive">
                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">       
                        <thead class="student-thread">
                            <tr>
                                <th>
                                    <div class="form-check check-tables">
                                        <input class="form-check-input" type="checkbox" value="something"/>
                                    </div>
                                </th>
                                <th>Name</th>
                                <th>Birthdate</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="user-list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/admin/users', {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const users = data.data; 
            let html = '';
            users.forEach(user => {
                const avatarUrl = user.avatar 
                    ? `/storage/avatar/${user.id}/${user.avatar}` 
                    : '/images/user.png';

                html += `
                    <tr>
                        <td>
                            <div class="form-check check-tables">
                                <input class="form-check-input" type="checkbox" value="${user.id}"/>
                            </div>
                        </td>
                        <td>
                            <h2 class="table-avatar">
                                <a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="${avatarUrl}" alt="User Image"/></a>
                                <a href="#">${user.name}</a>
                            </h2>
                        </td>
                        <td>${user.birthdate || ''}</td>
                        <td>${user.email}</td>
                        <td>${user.phone || ''}</td>
                        <td>${user.address || ''}</td>
                        <td>${user.role || ''}</td>
                        <td class="text-end">
                            <div class="actions">
                                <a href="javascript:void(0);" class="btn btn-sm bg-success-light me-1" data-id="${user.id}"><i class="feather-eye"></i></a>
                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light me-1" data-id="${user.id}"><i class="feather-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light me-1" data-id="${user.id}"><i class="feather-trash"></i></a>
                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light me-1" data-id="${user.id}"><i class="feather-upload"></i></a>
                            </div>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('user-list').innerHTML = html;
        })
        .catch(error => console.error('Error fetching users:', error));
    });
</script>

@endsection