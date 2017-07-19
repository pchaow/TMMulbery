<template>
    <div class="row" v-if="buyer">
        <div class="col-md-12" v-show="showSidePanel">

          <!--  <buyer-profile-column v-if="buyerData"
                                  :buyer="buyerData"
                                  :edit-url="buyerEditUrl"
            ></buyer-profile-column> -->
        </div>

        <slot>
        </slot>

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">รายการคำขอซื้อ</a></li>
                    <li><a href="#timeline" @click="" data-toggle="tab">ประวัติการซื้อ</a></li>

                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-money"></i>
                                รายการคำขอซื้อ
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>สถานะ</th>
                                            <th>จำนวน(กก.)</th>
                                            <th>ชื่อแปลง</th>
                                            <th>ชื่อเกษตรกร</th>
                                            <th>เบอร์โทรติดต่อ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="order in buyOrders.data">

                                            <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                            <td>{{order.status}}</td>
                                            <td>{{numeral(order.amount).format("0,0.00")}}</td>
                                            <td>{{order.plant.name}}</td>
                                            <td>{{order.plant.user.name}}</td>
                                            <td>{{order.plant.user.contact_number}}</td>


                                            <td>
                                                <a :href="strFormat(orderConfirmUrl,{id:order.id})"
                                                   class="btn btn-default">ยืนยัน</a>
                                                <button type="button" @click="closeOrder(order)" class="btn btn-danger">
                                                    ยกเลิก
                                                </button>
                                            </td>

                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    จำนวนทั้งหมด รายการ
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
                        <!-- Post -->
                    </div>
                    <div class="tab-pane" id="timeline">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>สถานะ</th>
                                            <th>จำนวน(กก.)</th>
                                            <th>ชื่อแปลง</th>
                                            <th>ชื่อเกษตรกร</th>
                                            <th>เบอร์โทรติดต่อ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="order in buyHistoryOrders.data">

                                            <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                            <td>
                                                {{order.buy_confirm_orders[0] ? order.buy_confirm_orders[0].status : order.status}}
                                            </td>
                                            <td>{{numeral(order.amount).format("0,0.00")}}</td>
                                            <td>{{order.plant.name}}</td>
                                            <td>{{order.plant.user.name}}</td>
                                            <td>{{order.plant.user.contact_number}}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    จำนวนทั้งหมด รายการ
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
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>


    </div>
</template>

<script>
    import BuyerProfileColumn from './BuyerProfileColumn.vue'

    export default {
        props: {
            loadUrl: String,
            buyerEditUrl: String,
            buyerLoadUrl: String,
            buyer: Object,
            //plantOpenSellOrderUrl: String,
            buyerLoadOrderUrl: String,
            orderApiUrl: String,
            showSidePanel: true,
            orderConfirmUrl: String,
        },
        components: {
            BuyerProfileColumn
        },
        data() {
            return {
                buyerData: {},
                buyOrders: [],
                buyHistoryOrders: [],
            }
        },
        methods: {
            strFormat: window.strFormat,

            refreshOrder: function () {
                this.loadBuyOrders();
                this.loadBuyHistoryOrders();
            },
            closeOrder: function (order) {


                if (confirm("คุณต้องการยกเลิกคำสั่งซื้อนี้หรือไม่")) {
                    axios.post(this.orderApiUrl + "/" + order.id + "/closed")
                        .then(response => {
//                            this.refreshOrder();
                            window.location.href = window.location.href;
                        })
                        .catch(error => {

                        })
                }

            },
            loadBuyHistoryOrders: function () {

                axios.post(this.orderApiUrl + "/loadBuyHistoryOrder")
                    .then(response => {
                        this.buyHistoryOrders = response.data;
                        console.log(this.buyOrders)
                    })
            },
            loadBuyOrders: function () {

                axios.post(this.orderApiUrl + "/loadBuyOpenPendingOrder")
                    .then(response => {
                        this.buyOrders = response.data;
                        console.log(this.buyOrders)
                    })
            },

            loadBuyerData: function () {
                this.$http.get(this.buyerLoadUrl).then(
                    function (response) {
                        this.buyerData = response.data
                    }
                )
            },
        },
        created() {
            this.buyerData = this.buyer;
            this.refreshOrder();
        },
        mounted() {
            console.log(this.buyer)
        }
    }
</script>