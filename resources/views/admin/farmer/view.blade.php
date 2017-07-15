@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i>จัดการเกษตรกร</a></li>
            <li><a href="/admin/farmers/{{$farmer->id}}/view"><i class="fa fa-search"></i>ดูข้อมูลเกษตรกร</a></li>
            <li>รหัสเกษตรกร : {{$farmer->id}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-view
                v-bind:load-url="'/api/admin/farmer/{{$farmer->id}}'"
                v-bind:farmer-edit-url="'/admin/farmers/{{$farmer->id}}/edit'"
                v-bind:load-plant-url="'/api/admin/farmer/{{$farmer->id}}/plant'"
                v-bind:plant-create-url="'/admin/farmers/{{$farmer->id}}/plant/create'"
                v-bind:plant-edit-url="'/admin/farmers/{{$farmer->id}}/plant/{id}/edit'"
                plant-delete-url="/api/admin/farmer/{{$farmer->id}}/plant/{id}"
                v-bind:farmer="{{json_encode($farmer)}}"
                farmer-load-url="/api/admin/farmer/{{$farmer->id}}"
                plant-transaction-url="/admin/plants/{id}/view"
                :show-side-panel="true"
                plant-load-order-url="/api/admin/farmer{{$farmer->id}}/order"
        >
        </farmer-view>

    </section>
    <!-- /.content -->
@endsection
