@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Dashboard

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
                <farmer-view
                        role-type="farmer"
                        :show-side-panel="false">
                </farmer-view>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
