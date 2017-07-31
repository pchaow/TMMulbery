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


        <div class="col-md-12" v-if="showOrderForm">

            <div class="panel panel-info">
                <div class="panel-heading">
                    ประกาศรับซื้อ
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="saveBuyOrder()">

                            <div class="form-group"
                                 v-bind:class="{ 'has-error': order.errors['duedate'] }">
                                <label>Date:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input v-model="order.form['duedate']"
                                           type="date"
                                           class="form-control pull-right">
                                </div>
                                <span v-if="order.errors['duedate']"
                                      class="help-block">{{ order.errors['duedate'] }}</span>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <label>น้ำหนัก (กก.):</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calculator"></i>
                                    </div>
                                    <input v-model="order.form.amount" type="number" step="0.01"
                                           class="form-control pull-right">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                <button @click="openOrderForm(false)" class="btn btn-default">ยกเลิก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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

                                <div class="pull-right">

                                    <!--<button @click="openOrderForm(true)" class="btn btn-primary">
                                        ประกาศซื้อ
                                    </button> -->

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>วันนัดซื้อขาย</th>
                                            <th>สถานะ</th>
                                            <th>พื้นที่(ไร่)</th>
                                            <th>ปริมาณ(กก.)</th>
                                            <th>ชื่อแปลง</th>
                                            <th>ชื่อเกษตรกร</th>
                                            <th>เบอร์โทรติดต่อ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="order in buyOrders.data">
                                            <!--tr>

                                                <td>{{order.duedate | moment("DD-MMM-YYYY")}}</td>
                                                <td>{{order.status}}</td>
                                                <td>{{numeral(order.amount_rai).format("0,0.00")}}</td>
                                                <td>{{numeral(order.amount_kg).format("0,0.00")}}</td>
                                                <td>{{order.plant ? order.plant.name : "-"}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <button type="button" @click="closeOrder(order)"
                                                            class="btn btn-danger">
                                                        ยกเลิก
                                                    </button>
                                                </td>
                                            </--tr-->

                                            <tr v-for="sell in order.sell_paired_order">
                                                <td>
                                                    {{order.id}}-{{sell.id}}
                                                </td>
                                                <td>
                                                    {{order.duedate | moment("DD-MMM-YYYY")}}
                                                </td>
                                                <td>{{sell.status}}</td>
                                                <td>{{numeral(sell.amount_rai).format("0,0.00")}}</td>
                                                <td>{{numeral(sell.amount_kg).format("0,0.00")}}</td>
                                                <td>{{sell.plant ? sell.plant.name : '-'}}</td>
                                                <td>{{sell.user ? sell.user.name : '-'}}</td>
                                                <td>{{sell.user ? sell.user.contact_number : '-'}}</td>

                                                <td>
                                                    <a :href="$routes.web[roleType].order +'/'+ sell.pivot.id + '/confirm'"
                                                       class="btn btn-default">ยืนยัน</a>
                                                    <button type="button" @click="closeOrder(order)"
                                                            class="btn btn-danger">
                                                        ยกเลิก
                                                    </button>
                                                </td>

                                            </tr>

                                        </template>


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
                                            <th>ID</th>
                                            <th>สถานะ</th>
                                            <th>พื้นที่(ไร่)</th>
                                            <th>ปริมาณ(กก.)</th>
                                            <th>ชื่อแปลง</th>
                                            <th>ชื่อเกษตรกร</th>
                                            <th>เบอร์โทรติดต่อ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="order in buyHistoryOrders.data">
                                            <tr>
                                                <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                                <td>{{order.id}}</td>
                                                <td colspan="5">{{order.status}}</td>
                                            </tr>

                                            <tr v-for="sell in order.sell_paired_order">

                                                <td colspan="2" class="text-right">
                                                    Sell ID : {{sell.id}}
                                                </td>
                                                <td>{{sell.status}}</td>
                                                <td>{{sell.pivot.remark.unit}}</td>
                                                <td>{{sell.plant ? sell.plant.name : '-'}}</td>
                                                <td>{{sell.user ? sell.user.name : '-'}}</td>
                                                <td>{{sell.user ? sell.user.contact_number : '-'}}</td>


                                            </tr>
                                        </template>
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
            showSidePanel: true,
            buyer: Object,
            roleType: String,
        },
        components: {
            BuyerProfileColumn
        },
        data() {
            return {
                buyerData: {},
                buyOrders: [],
                buyHistoryOrders: [],
                showOrderForm: false,
                order: {
                    form: {},
                    errors: {},
                },

                buyerEditUrl: this.$routes.web[this.roleType] + "edit",

            }
        },
        methods: {
            saveBuyOrder: function () {
                this.order.errors = {};
                axios.post(this.$routes.api[this.roleType].order, this.order.form)
                    .then(res => {
                        this.refreshOrder()
                        this.openOrderForm(false)
                    })
                    .catch(err => {
                        this.order.errors = err.response.data;
                    })
            },
            openOrderForm: function (bool) {
                this.showOrderForm = bool
            },
            refreshOrder: function () {
                this.loadBuyOrders();
                this.loadBuyHistoryOrders();
            },
            closeConfirmOrder: function (order) {
            },
            closeOrder: function (order) {


                if (confirm("ต้องการยกเลิกคำสั่งซื้อนี้")) {
                    axios.post(this.$routes.api[this.roleType].order + "/" + order.id + "/closed")
                        .then(response => {
//                            this.refreshOrder();
                            window.location.href = window.location.href;
                        })
                        .catch(error => {

                        })
                }

            },
            loadBuyHistoryOrders: function () {

                axios.post(this.$routes.api[this.roleType].order + "/loadBuyHistoryOrder")
                    .then(response => {
                        var data = response.data;
                        for (var i = 0; i < data.data.length; i++) {
                            var order = data.data[i];
                            for (var j = 0; j < order.sell_paired_order.length; j++) {
                                var pairOrder = order.sell_paired_order[j];
                                pairOrder.pivot.remark = JSON.parse(pairOrder.pivot.remark);
                            }
                        }
                        this.buyHistoryOrders = data;
                    })
            },
            loadBuyOrders: function () {

                axios.post(this.$routes.api[this.roleType].order + "/loadBuyOpenPendingOrder")
                    .then(response => {
                        this.buyOrders = response.data;
                        //console.log(this.buyOrders)
                    })
            },

            loadBuyerData: function () {
                this.$http.get(this.$routes.api[this.roleType].index).then(
                    function (response) {
                        this.buyerData = response.data
                    }
                )
            },
        },
        created() {
            this.buyerData = this.buyer;

        },
        mounted() {
            this.refreshOrder();
        }
    }
</script>