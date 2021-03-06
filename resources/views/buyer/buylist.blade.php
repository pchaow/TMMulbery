@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการคำสั่งซื้อ
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="active">จัดการคำสั่งซื้อ</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">

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
