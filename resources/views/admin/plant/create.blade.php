@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Plant Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plants"><i class="fa fa-sign-in"></i> Plant Management</a></li>
            <li><a href="/admin/plants/create"><i class="fa fa-plus"></i> Create Plant</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <role-create
                v-bind:success-url="'/admin/plants'"
                v-bind:save-role-url="'/api/admin/role'"
        ></role-create>
    </section>
    <!-- /.content -->
@endsection
