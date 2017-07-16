@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-users"></i> จัดการเกษตรกร</a></li>
            <li>รายการเกษตรกร</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-index
                v-bind:edit-url="'/admin/farmers/{id}/edit'"
                v-bind:view-url="'/admin/farmers/{id}/view'"
                v-bind:load-farmer-url="'/api/admin/farmer'"
                v-bind:delete-url="'/api/admin/farmer/{id}'"
                v-bind:create-farmer-url="'/admin/farmers/create'">
        </farmer-index>

    </section>
    <!-- /.content -->
@endsection


