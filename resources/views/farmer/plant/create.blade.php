@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/farmer/plant" class="fa fa-arrow-left"> จัดการแปลงหม่อน </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/farmer/plant"><i class="fa fa-tree"></i> จัดการแปลงหม่อน</a></li>
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
