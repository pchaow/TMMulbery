@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @if(Request::has('previous'))
                <a href="{{Request::get('previous')}}" class="fa fa-arrow-left"> แปลงหม่อน {{$plant->name}} - {{$farmer->name}} </a>
            @else
                <a href="/buyer/plant" class="fa fa-arrow-left"> แปลงหม่อน {{$plant->name}} - {{$farmer->name}} </a>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/plant"><i class="fa fa-user"></i> จัดการแปลงหม่อน</a></li>
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
                role-type="buyer">
        </plant-view>

    </section>
    <!-- /.content -->
@endsection
