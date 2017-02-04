@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i>จัดการเกษตรกร</a></li>
            <li><a href="/admin/farmers/{{$userId}}/view"><i class="fa fa-search"></i>ดูข้อมูลเกษตรกร</a></li>
            <li>รหัสเกษตรกร : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-view
                v-bind:load-url="'/api/admin/farmer/{{$userId}}'"
                v-bind:edit-url="'/admin/farmers/{{$userId}}/edit'"
                v-bind:load-plant-url="'/api/admin/farmer/{{$userId}}/plant'"
                v-bind:plant-create-url="'/admin/farmers/{{$userId}}/plant/create'"
                v-bind:farmer-id="{{$userId or 0}}">
        </farmer-view>

    </section>
    <!-- /.content -->
@endsection
