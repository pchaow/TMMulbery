@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/users"><i class="fa fa-user"></i> User Management</a></li>
            <li><a href="/admin/users//{{$userId}}/edit"><i class="fa fa-plus"></i> Edit User</a></li>
            <li>User ID : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <user-edit
                v-bind:save-url="'/api/admin/user/{{$userId or 0}}'"
                v-bind:load-url="'/api/admin/user/{{$userId or 0}}'"
                v-bind:success-url="'/admin/users'"
                v-bind:load-roles-url="'/api/admin/role'"
                v-bind:user-id="{{$userId or 0}}">
        </user-edit>

    </section>
    <!-- /.content -->
@endsection
