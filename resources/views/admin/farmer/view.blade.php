@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Farmer Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i> Farmer Management</a></li>
            <li><a href="/admin/farmers/{{$userId}}/view"><i class="fa fa-search"></i>ดูข้อมูลเกษตรกร</a></li>
            <li>Farmers ID : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-view
                v-bind:load-url="'/api/admin/farmer/{{$userId}}'"
                v-bind:farmer-id="{{$userId or 0}}">
        </farmer-view>

    </section>
    <!-- /.content -->
@endsection
