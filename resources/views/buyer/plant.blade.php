@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน  <a href="/buyer/plantmap" class="btn btn-primary">แผนที่</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="active">จัดการแปลงหม่อน</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <farmer-view
                        role-type="buyer"
                        :show-side-panel="false">
                </farmer-view>
            </div>
        </div>

        <buyer-children-plants role-type="buyer">
        </buyer-children-plants>
    </section>
    <!-- /.content -->
@endsection
