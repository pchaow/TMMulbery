@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            แปลงหม่อน {{$plant->name}} - {{$farmer->name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plants"><i class="fa fa-user"></i> จัดการแปลงหม่อน</a></li>
            <li><a href="/admin/plants/{{$plant->id}}/view"><i class="fa fa-table"></i> {{$plant->name}} - {{$farmer->name}} </a></li>
            <li>รายการแปลงหม่อน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    </section>
    <!-- /.content -->
@endsection
