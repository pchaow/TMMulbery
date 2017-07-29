@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ลงทะเบียนเกษตรกร
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/farmer"><i class="fa fa-user"></i> จัดการเกษตรกร</a></li>
            <li><a href=""><i class="fa fa-plus"></i> ลงทะเบียนเกษตรกร</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <farmer-create role-type="buyer"></farmer-create>
    </section>
    <!-- /.content -->
@endsection