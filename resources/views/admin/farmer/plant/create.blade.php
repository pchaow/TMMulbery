@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plants"><i class="fa fa-sign-in"></i> จัดการแปลงหม่อน</a></li>
            <li><a href="/admin/plants/create"><i class="fa fa-plus"></i> เพิ่มแปลงหม่อน</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-create
                v-bind:save-plant-url="'/api/admin/farmer/{{$userId}}/plant'"
                v-bind:load-url="'/api/admin/farmer/{{$userId}}'"
                v-bind:edit-url="'/admin/farmers/{{$userId}}/edit'"
                v-bind:load-plant-url="'/api/admin/farmer/{{$userId}}/plant'"
                v-bind:plant-create-url="'/admin/farmers/{{$userId}}/plant/create'"
                v-bind:farmer-id="{{$userId or 0}}"
        ></farmer-plant-create>
    </section>
    <!-- /.content -->
@endsection
