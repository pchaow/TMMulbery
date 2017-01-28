@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Plant Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plant"><i class="fa fa-sign-in"></i> Plant Management</a></li>
            <li>Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <plant-index

        ></plant-index>

    </section>
    <!-- /.content -->
@endsection