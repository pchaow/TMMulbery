@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-user"></i>จัดการเกษตรกร</a></li>
            <li><a href=""><i class="fa fa-search"></i>ดูข้อมูลเกษตรกร</a></li>
            <li>รหัสเกษตรกร : {{$user->id}}</li>
            <li><a href="/"><i class="fa fa-pencil"></i> แก้ไขแปลงหม่อน ID : {{$plant->id}}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-edit
                :plant="{{json_encode($plant)}}"
                plant_id="{{$plant->id}}"
                :show-side-panel="false"
                role-type="buyer"
        ></farmer-plant-edit>
    </section>
    <!-- /.content -->
@endsection
