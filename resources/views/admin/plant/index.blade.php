@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-user"></i> จัดการแปลงหม่อน</a></li>
            <li>รายการแปลงหม่อน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <plant-index
                plant-load-url="{{url("/api/admin/plant")}}"
                page-url="{{url("/admin/plants")}}"
        >
        </plant-index>

    </section>
    <!-- /.content -->
@endsection


