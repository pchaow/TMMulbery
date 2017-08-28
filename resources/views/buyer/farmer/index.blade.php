@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">จัดการเกษตรกร</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-index role-type="buyer">
        </farmer-index>

    </section>
    <!-- /.content -->
@endsection


