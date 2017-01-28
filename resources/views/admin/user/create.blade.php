@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/users"><i class="fa fa-user"></i> User Management</a></li>
            <li><a href="/admin/users/create"><i class="fa fa-plus"></i> Create User</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <user-create
                v-bind:save-url="'/api/admin/user'"
                v-bind:success-url="'/admin/users'"
                v-bind:load-roles-url="'/api/admin/role'">
        </user-create>

    </section>
    <!-- /.content -->
@endsection