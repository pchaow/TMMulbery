@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Role Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/roles"><i class="fa fa-sign-in"></i> Role Management</a></li>
            <li><a href="/admin/roles/create"><i class="fa fa-plus"></i> Create Role</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <role-create
                v-bind:success-url="'/admin/roles'"
                v-bind:save-role-url="'/api/admin/role'"
        ></role-create>
    </section>
    <!-- /.content -->
@endsection
