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
                                    <th>ปริมาณ (กก.)</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order in sellOrder.data">

                                    <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                    <td>{{order.plant ? order.plant.name : "-"}}</td>
                                    <td>{{order.plant ? order.plant.user.name : order.user.name}}</td>
                                    <td>{{order.plant ? order.plant.user.contact_number : order.user.contact_number}}
                                    </td>
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
            roleType: String,
        },
        components: {},
        data() {
            return {
                sellOrder: null,
                orderApi: this.$routes.api[this.roleType].order,
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
                if (confirm("ต้องการซื้อรายการนี้?")) {
                    var form = {
                        plant_id: order.plant ? order.plant.id : null,
                        order_id: order.id
                    }

                    if (order.plant) {
                        axios.post(this.orderApi + "/openWithConfirm", form)
                            .then(response => {
                                window.location.href = "/home"
                            })
                            .catch(error => {

                            })
                    } else {
                        axios.post(this.orderApi + "/openWithConfirm", form)
                            .then(response => {
                                window.location.href = "/home"
                            })
                            .catch(error => {

                            })
                    }


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