@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/farmers/plant/create"><i class="fa fa-plus"></i> เพิ่มแปลงหม่อน</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-create
                v-bind:save-plant-url="'/api/farmer/plant'"
                success-url="/home"
                v-bind:load-url="'/api/farmer/'"
                v-bind:edit-url="'/farmers/edit'"
                v-bind:load-plant-url="'/api/farmer/plant'"
                v-bind:plant-create-url="'/farmers/plant/create'"
                v-bind:farmer="{{json_encode($user)}}"
        ></farmer-plant-create>
    </section>
    <!-- /.content -->
@endsection
