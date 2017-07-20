@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Dashboard

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
                <farmer-view
                        load-url="'/api/farmer/"
                        farmer-api-url="/api/farmer"
                        v-bind:farmer-edit-url="'/farmers/edit'"
                        v-bind:load-plant-url="'/api/farmer/plant'"
                        v-bind:plant-create-url="'/farmer/plant/create'"
                        v-bind:plant-edit-url="'/farmer/plant/{id}/edit'"
                        plant-delete-url="/api/farmer/plant/{id}"
                        v-bind:farmer="{{json_encode($farmer)}}"
                        farmer-load-url="/api/farmer"
                        plant-transaction-url="/farmer/plant/{id}/view"
                        :show-side-panel="false"
                        plant-open-sell-order-url="/api/farmer/plant/{id}/open/sell"
                        plant-load-order-url="/api/farmer/order"

                >
                </farmer-view>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
