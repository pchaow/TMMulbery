@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            รายละเอียดผู้รับซื้อ
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-user-circle-o"></i>จัดการผู้รับซื้อ</a></li>
            <li><i class="fa fa-search"></i>ดูข้อมูลผู้รับซื้อ</li>
            <li>รหัสผู้รับซื้อ : {{$buyer->id}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <buyer-view
                        v-bind:load-url="'/api/admin/buyer/{{$buyer->id}}'"
                        v-bind:buyer-edit-url="'/admin/buyers/{{$buyer->id}}/edit'"
                        v-bind:buyer="{{json_encode($buyer)}}"
                        buyer-load-url="/api/admin/buyer/{{$buyer->id}}"
                        :show-side-panel="true"
                        buyer-load-order-url="/api/admin/buyer/{{$buyer->id}}/order"
                >
                </buyer-view>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
