@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Farmer Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i> Farmer Management</a></li>
            <li><a href="/admin/farmers/create"><i class="fa fa-plus"></i> Create Farmer</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-create
                v-bind:save-url="'/api/admin/farmer'"
                v-bind:success-url="'/admin/farmers'"
                v-bind:load-roles-url="'/api/admin/role'">
        </farmer-create>

    </section>
    <!-- /.content -->
@endsection