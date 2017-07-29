@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/farmer"><i class="fa fa-users"></i> จัดการเกษตรกร</a></li>
            <li>รายการเกษตรกร</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-index role-type="buyer">
        </farmer-index>

    </section>
    <!-- /.content -->
@endsection


