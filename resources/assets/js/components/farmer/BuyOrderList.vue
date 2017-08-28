<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการประกาศรับซื้อ
                </div>

                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" v-if="orders">
                                <thead>
                                <tr>

                                    <th>วันที่</th>
                                    <th>ผู้รับซื้อ</th>
                                    <th>เบอร์โทรติดต่อ</th>
                                    <th>สถานะ</th>
                                    <th>ปริมาณ (กก.)</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order in orders.data">

                                    <td>{{order.duedate | moment("DD-MMM-YYYY")}}</td>
                                    <td>{{order.user.name}}</td>
                                    <td>{{order.user.contact_number}}</td>
                                    <td>{{order.status}}</td>
                                    <td>{{numeral(order.amount).format("0,0.00")}}</td>
                                    <td>
                                        <button @click="openSellOrder(order)" type="button" class="btn btn-primary">
                                            ขาย
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div>
                                            จำนวนทั้งหมด {{orders.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        props: {
            orderApi: String,
        },
        components: {},
        data() {
            return {
                orders: null,
            }
        },
        methods: {
            strFormat: window.strFormat,
            loadOrders: function () {
                this.orders = []
                axios.post(this.orderApi + "/loadBuyOpenOrder")
                    .then(response => {
                        this.orders = response.data;
                    })
            },
            openSellOrder: function (order) {
                if (confirm("คุณต้องการขายให้กับรายการนี้ใช่หรือไม่")) {
                    var form = {
                        order_id: order.id
                    }
                    axios.post(this.orderApi + "/openWithConfirm", form)
                        .then(response => {
                            window.location.href = "/home"
                        })
                        .catch(error => {

                        })
                }
            },
        },
        created() {
            this.loadOrders();
        },
        mounted() {
        }
    }
</script>