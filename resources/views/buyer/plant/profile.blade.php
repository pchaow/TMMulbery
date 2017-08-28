@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/buyer/plant" class="fa fa-arrow-left"> จัดการแปลงหม่อน </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/plant"><i class="fa fa-tree"></i>จัดการเเปลงหม่อน</a></li>
            <li>รหัสเกษตรกร : {{$user->id}}</li>
            <li><a href="/"><i class="fa fa-search"></i> ข้อมูลแปลงหม่อน ID : {{$plant->id}}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-profile
                :plant="{{json_encode($plant)}}"
                plant_id="{{$plant->id}}"
                :show-side-panel="false"
                role-type="buyer"
        ></farmer-plant-profile>
    </section>
    <!-- /.content -->
@endsection
