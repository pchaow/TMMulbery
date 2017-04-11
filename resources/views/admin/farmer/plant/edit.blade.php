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
            <li><a href="/admin/plants/create"><i class="fa fa-pencil"></i> แก้ไขแปลงหม่อน ID : {{$plant->id}}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-edit
                success-url="/admin/farmers/{{$user->id}}/view"
                save-plant-url="'/api/admin/farmer/{{$user->id}}/plant/{{$plant->id}}'"
                edit-farmer-url="/admin/farmers/{{$user->id}}/edit"
                :farmer="{{json_encode($user)}}"
                :plant="{{json_encode($plant)}}"

        ></farmer-plant-edit>
    </section>
    <!-- /.content -->
@endsection
