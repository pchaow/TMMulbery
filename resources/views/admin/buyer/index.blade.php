@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการผู้รับซื้อ
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-user-circle-o"></i> จัดการผู้รับซื้อ</a></li>
            <li>รายการผู้รับซื้อ</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <buyer-index
                v-bind:edit-url="'/admin/buyers/{id}/edit'"
                v-bind:view-url="'/admin/buyers/{id}/view'"
                v-bind:load-buyer-url="'/api/admin/buyer'"
                v-bind:delete-url="'/api/admin/buyer/{id}'"
                v-bind:create-buyer-url="'/admin/buyers/create'">
        </buyer-index>

    </section>
    <!-- /.content -->
@endsection


