@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ยืนยันรายการ
        </h1>
        <ol class="breadcrumb">
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <order-confirm
                        order-id="{{$orderId or 0}}"
                        order-api="/api/buyer/order"
                >
                </order-confirm>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
