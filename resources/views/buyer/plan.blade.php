@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            วางแผนเก็บเกี่ยว
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">วางแผนเก็บเกี่ยว</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <buyer-plan></buyer-plan>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
