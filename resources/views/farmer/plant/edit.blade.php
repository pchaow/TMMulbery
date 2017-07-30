@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/farmer" class="fa fa-arrow-left"> จัดการแปลงหม่อน </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/farmer"><i class="fa fa-tree"></i>จัดการแปลงหม่อน</a></li>
            <li>รหัสเกษตรกร : {{$user->id}}</li>
            <li><i class="fa fa-pencil"></i> แก้ไขแปลงหม่อน ID : {{$plant->id}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-edit
                :plant="{{json_encode($plant)}}"
                plant_id="{{$plant->id}}"
                :show-side-panel="false"

                save-plant-url="/api/farmer/plant/{{$plant->id}}"
                role-type="farmer"
        ></farmer-plant-edit>
    </section>
    <!-- /.content -->
@endsection
