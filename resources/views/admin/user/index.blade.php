@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการผู้ใช้งาน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/users"><i class="fa fa-user"></i> จัดการผู้ใช้งาน</a></li>
            <li>รายการผู้ใช้งาน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <user-index
                v-bind:edit-url="'/admin/users/{id}/edit'"
                v-bind:load-user-url="'/api/admin/user'"
                v-bind:delete-url="'/api/admin/user/{id}'"
                v-bind:create-user-url="'/admin/users/create'"
        >
        </user-index>

    </section>
    <!-- /.content -->
@endsection

