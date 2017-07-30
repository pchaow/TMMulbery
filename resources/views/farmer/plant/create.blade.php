@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/farmer" class="fa fa-arrow-left"> จัดการแปลงหม่อน </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-plus"></i> เพิ่มแปลงหม่อน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-create
                role-type="farmer"
        ></farmer-plant-create>
    </section>
    <!-- /.content -->
@endsection
