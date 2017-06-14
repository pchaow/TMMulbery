@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการสถานะการปลูก (Plant Transaction Status)
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plant_transaction_status"><i class="fa fa-sign-in"></i> จัดการสถานะการปลูก (Plant Transaction Status)</a></li>
            <li><a href="/admin/plant_transaction_status/{{$id}}/edit"><i class="fa fa-plus"></i> แกำ้ไขรายการสถานะการปลูก</a></li>
            <li>Plant Status ID : {{$id}}</li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <plant-transaction-status-edit
                v-bind:api-url="'/api/admin/plant_transaction_status/{{$id or 0}}'"
                v-bind:page-url="'/admin/plant_transaction_status'"
                v-bind:id="{{$id or 0}}"></plant-transaction-status-edit>
    </section>
    <!-- /.content -->
@endsection
