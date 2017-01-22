@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Role Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/roles"><i class="fa fa-sign-in"></i> Role Management</a></li>
            <li><a href="/admin/roles/create"><i class="fa fa-pencil"></i> Edit Role</a></li>
            <li>Role ID : {{$roleId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <role-edit
                v-bind:save-prefix="'/api/admin/role/'"
                v-bind:save-postfix="''"
                v-bind:load-prefix="'/api/admin/role/'"
                v-bind:load-postfix="''"
                v-bind:success-url="'/admin/roles'"
                v-bind:role-id="{{$roleId or 0}}"></role-edit>
    </section>
    <!-- /.content -->
@endsection
