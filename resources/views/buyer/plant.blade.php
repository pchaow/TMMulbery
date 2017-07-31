@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-tree"></i> จัดการแปลงหม่อน</a></li>
            <li class="active">รายการแปลงหม่อน</li>
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
