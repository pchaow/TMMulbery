@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Role Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/roles"><i class="fa fa-sign-in"></i> Role Management</a></li>
            <li>Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <role-index
                v-bind:create-role-url="'/admin/roles/create'"
                v-bind:edit-role-prefix="'/admin/roles/'"
                v-bind:edit-role-postfix="'/edit'"
                v-bind:load-roles-url="'/api/admin/role/'"
                v-bind:delete-role-url="'/api/admin/role/'"
        ></role-index>

    </section>
    <!-- /.content -->
@endsection