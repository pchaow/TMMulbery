@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/users"><i class="fa fa-user"></i> User Management</a></li>
            <li>Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <user-index
                v-bind:edit-prefix="'/admin/users/'"
                v-bind:edit-postfix="'/edit'"
                v-bind:load-user-url="'/api/admin/user'"
                v-bind:delete-user-prefix="'/api/admin/user/'"
                v-bind:create-user-url="'/admin/users/create'"
        >
        </user-index>

    </section>
    <!-- /.content -->
@endsection

