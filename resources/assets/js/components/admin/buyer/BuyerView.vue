<template>
    <div class="row" v-if="buyer">
        <div class="col-md-12" v-show="showSidePanel">

            <buyer-profile-column v-if="buyerData"
                                   :buyer="buyerData"
                                   :edit-url="buyerEditUrl"
            ></buyer-profile-column>
        </div>
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
                                        <tr v-for="order in buyer.buy_orders">

                                            <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                            <td>{{order.status}}</td>
                                            <td>{{order.amount}}</td>
                                            <td>{{order.plant.name}}</td>
                                            <td>{{order.plant.user.name}}</td>
                                            <td>{{order.plant.user.contact_number}}</td>


                                            <td></td>

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
            showSidePanel: true,


        },
        components: {
            BuyerProfileColumn
        },
        data() {
            return {
                buyerData: {
                },
                buyOrders: [],
            }
        },
        methods: {
            strFormat: window.strFormat,

            loadBuyOrders: function () {

                axios.get(this.buyerLoadOrderUrl)
                    .then(response => {
                        this.buyOrders = response.data;
                        //console.log(this.buyOrders)
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
            //this.buyOrders = this.loadBuyOrders();
        },
        mounted() {

            console.log(this.buyer)
            //console.log(this.buyOrders)

        }
    }
</script>