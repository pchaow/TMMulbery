@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Optional description</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
            <buyer-view
                    :buyer="{{json_encode($buyer)}}"
                    :show-side-panel="true"

                    load-url="/api/buyer/{{$buyer->id}}"
                    buyer-edit-url="/buyers/{{$buyer->id}}/edit"
                    buyer-load-url="/api/buyer/{{$buyer->id}}"
                    buyer-load-order-url="/api/buyer/{{$buyer->id}}/order"
            >
            </buyer-view>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
