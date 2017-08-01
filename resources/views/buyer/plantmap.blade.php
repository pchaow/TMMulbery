@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/buyer/plant" class="fa fa-arrow-left"> จัดการแปลงหม่อน </a>
        </h1>
        <br>
        <h1>
            แผนที่แปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">แผนที่แปลงหม่อน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <buyer-plant-map></buyer-plant-map>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
