@extends('layouts.app')
@section('css')
    <link rel='stylesheet' href='/css/fullcalendar.min.css'/>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            จัดการแปลงหม่อน
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tree"></i> จัดการแปลงหม่อน</a></li>
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
