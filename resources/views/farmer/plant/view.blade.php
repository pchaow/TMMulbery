@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/farmer/plant" class="fa fa-arrow-left"> แปลงหม่อน {{$plant->name}} - {{$farmer->name}}</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/farmer/plant"><i class="fa fa-tree"></i> จัดการแปลงหม่อน</a></li>
            <li><a href=""><i class="fa fa-table"></i> {{$plant->name}}
                    - {{$farmer->name}} </a></li>
            <li>รายการการปลูก</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <admin-plant-harvest-stock :plant-id="{{$plant->id}}"></admin-plant-harvest-stock>
        <plant-view
                plant-id="{{$plant->id}}"
                role-type="farmer">
        </plant-view>

    </section>
    <!-- /.content -->
@endsection
