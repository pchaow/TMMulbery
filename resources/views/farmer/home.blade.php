@extends('layouts.app')
@section('css')
    <link rel='stylesheet' href='/css/fullcalendar.min.css'/>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <buyer-calendar-dashboard role-type="farmer"></buyer-calendar-dashboard>
            </div>


        </div>
    </section>
    <!-- /.content -->
@endsection
