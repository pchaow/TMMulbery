@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Plant Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/plants"><i class="fa fa-sign-in"></i> Plant Management</a></li>
            <li>Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <plant-index
                create-url="/admin/plants/create"
                load-url="/api/admin/plant"
        ></plant-index>


    </section>
    <!-- /.content -->
@endsection