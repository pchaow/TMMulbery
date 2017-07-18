<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการขายจากเกษตรกร
                </div>

                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" v-if="sellOrder">
                                <thead>
                                <tr>

                                    <th>วันที่</th>
                                    <th>แปลง</th>
                                    <th>ชื่อเกษตรกร</th>
                                    <th>เบอร์โทรติดต่อ</th>
                                    <th>สถานะ</th>
                                    <th>จำนวน (กก.)</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order in sellOrder.data">

                                    <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                    <td>{{order.plant ? order.plant.name : "ERROR"}}</td>
                                    <td>{{order.plant.user.name}}</td>
                                    <td>{{order.plant.user.contact_number}}</td>
                                    <td>{{order.plant ? order.plant.name : "ERROR"}}</td>

                                    <td>{{order.status}}</td>
                                    <td>{{numeral(order.amount).format("0,0.00")}}</td>
                                    <td>
                                        <button @click="openBuyOrder(order)" type="button" class="btn btn-primary">
                                            ซื้อ
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div>
                                            จำนวนทั้งหมด {{sellOrder.total}} รายการ
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
                sellOrder: null,
            }
        },
        methods: {
            strFormat: window.strFormat,
            loadSellOrder: function () {
                this.sellOrders = []
                axios.post(this.orderApi + "/loadSellOpenOrder")
                    .then(response => {
                        this.sellOrder = response.data;
                        console.log(this.sellOrder);
                    })
            },
            openBuyOrder: function (order) {
                if (confirm("คุณต้องการซื้อรายการนี้ใช่หรือไม่")) {
                    var form = {
                        plant_id: order.plant.id,
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
            this.loadSellOrder();
        },
        mounted() {
        }
    }
</script>