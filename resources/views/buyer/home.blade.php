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

                        load-url="/api/buyer"
                        buyer-edit-url="/buyers/edit"
                        buyer-load-url="/api/buyer"
                        buyer-load-order-url="/api/buyer/order/loadOpenPendingOrder"
                        order-api-url="/api/buyer/order"
                        order-confirm-url="/buyer/order/{id}/confirm"
                >
                    <div class="col-lg-12">
                        <sell-order-list
                                order-api="/api/buyer/order"
                        >
                        </sell-order-list>
                    </div>

                </buyer-view>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
