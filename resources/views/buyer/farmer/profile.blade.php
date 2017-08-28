@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <a href="/buyer/farmer" class="fa fa-arrow-left">  จัดการเกษตรกร </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/buyer/farmer"><i class="fa fa-user"></i>จัดการเกษตรกร</a></li>
            <li><a href=""><i class="fa fa-search"></i> ข้อมูลเกษตรกร</a></li>
            <li>รหัสเกษตรกร : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-profile
                :user-id="{{$userId or 0}}"
                role-type="buyer">

        </farmer-profile>

    </section>
    <!-- /.content -->
@endsection
