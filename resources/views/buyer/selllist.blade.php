@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            รายการขาย
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <sell-order-list
                        order-api="/api/buyer/order"
                >
                </sell-order-list>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
