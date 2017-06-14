@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการสถานะการปลูก (Plant Transaction Status)
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plant_transaction_status"><i class="fa fa-sign-in"></i> จัดการสถานะการปลูก (Plant Transaction Status)</a></li>
            <li><a href="/admin/plant_transaction_status/create"><i class="fa fa-plus"></i> เพิ่มรายการสถานะการปลูก</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <plant-transaction-status-create
                api-url="/api/admin/plant_transaction_status"
                page-url="/admin/plant_transaction_status"
        ></plant-transaction-status-create>
    </section>
    <!-- /.content -->
@endsection
