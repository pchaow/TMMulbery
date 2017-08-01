@extends('layouts.app')

@section('css')
    <link rel='stylesheet' href='/css/fullcalendar.min.css' />
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

                <buyer-calendar-dashboard></buyer-calendar-dashboard>

                <buyer-view
                        :buyer="{{json_encode($buyer)}}"
                        :show-side-panel="true"
                        buyer-load-url="/api/buyer"
                        role-type="buyer"
                >
                </buyer-view>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
