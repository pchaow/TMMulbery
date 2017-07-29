@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/plant"><i class="fa fa-dashboard"></i> จัดการแปลงหม่อน</a></li>
            <li><a href=""><i class="fa fa-plus"></i> เพิ่มแปลงหม่อน</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-plant-create role-type="buyer"></farmer-plant-create>
    </section>
    <!-- /.content -->
@endsection
