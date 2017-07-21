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
                        confirm-order-id="{{$confirmOrderId or 0}}"
                        confirm-order-api="/api/buyer/confirm-order"
                        success-url="/home"
                >
                </order-confirm>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
