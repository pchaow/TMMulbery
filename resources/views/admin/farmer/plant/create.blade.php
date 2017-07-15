@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i>จัดการเกษตรกร</a></li>
            <li><a href="/admin/farmers/{{$user->id}}/view"><i class="fa fa-search"></i>ดูข้อมูลเกษตรกร</a></li>
            <li>รหัสเกษตรกร : {{$user->id}}</li>
            <li><a href="/admin/farmers/{{$user->id}}/plant/create"><i class="fa fa-plus"></i> เพิ่มแปลงหม่อน</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-create
                v-bind:save-plant-url="'/api/admin/farmer/{{$user->id}}/plant'"
                success-url="/admin/farmers/{{$user->id}}/view"
                v-bind:load-url="'/api/admin/farmer/{{$user->id}}'"
                v-bind:edit-url="'/admin/farmers/{{$user->id}}/edit'"
                v-bind:load-plant-url="'/api/admin/farmer/{{$user->id}}/plant'"
                v-bind:plant-create-url="'/admin/farmers/{{$user->id}}/plant/create'"
                v-bind:farmer="{{json_encode($user)}}"
                :show-side-panel="true"

        ></farmer-plant-create>
    </section>
    <!-- /.content -->
@endsection
