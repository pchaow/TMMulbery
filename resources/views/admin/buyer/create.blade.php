@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ลงทะเบียนผู้รับซื้อ
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/buyers"><i class="fa fa-user-circle-o"></i> จัดการผู้รับซื้อ</a></li>
            <li><a href="/admin/buyers/create"><i class="fa fa-plus"></i> ลงทะเบียนผู้รับซื้อ</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <buyer-create
                v-bind:save-url="'/api/admin/buyer'"
                v-bind:success-url="'/admin/buyers'">
        </buyer-create>

    </section>
    <!-- /.content -->
@endsection