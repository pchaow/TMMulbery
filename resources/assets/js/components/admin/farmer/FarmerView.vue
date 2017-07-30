<template>
    <div class="row">
        <div class="col-md-12" v-show="openFormStatus">
            <div class="panel panel-info">
                <div class="panel-heading">
                    ประกาศขาย
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="saveOpenSellOrderForm">

                            <div class="form-group"
                                 v-bind:class="{ 'has-error': sellOrder.errors['transaction_date'] }">
                                <label>Date:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input v-model="sellOrder.form['duedate']"
                                           type="date"
                                           class="form-control pull-right">
                                </div>
                                <span v-if="sellOrder.errors['transaction_date']"
                                      class="help-block">{{ sellOrder.errors['transaction_date'] }}</span>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <label>น้ำหนัก (กก.):</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calculator"></i>
                                    </div>
                                    <input v-model="sellOrder.form.amount" type="number" step="0.01"
                                           class="form-control pull-right">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                <button @click="openFormStatus = false" class="btn btn-default">ยกเลิก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">แปลงหม่อน</a></li>
                    <li><a href="#timeline" @click="loadOrders()" data-toggle="tab">ประวัติซื้อขาย</a></li>

                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-tree"></i>
                                รายการแปลงหม่อน

                                <div class="pull-right">

                                    <button v-if="false" @click="openSellOrderForm" class="btn btn-primary">
                                        ประกาศขาย
                                    </button>

                                    <a v-bind:href="plantCreateUrl" class="btn btn-warning">
                                        เพิ่มแปลงหม่อน
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>

                                            <th>ชื่อแปลง</th>
                                            <th>พื้นที่</th>
                                            <th>คงเหลือเก็บเกี่ยว</th>
                                            <th>เก็บเกี่ยวล่าสุด</th>
                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="plant in plants.data"
                                            v-bind:style="{ 'background-color' : calculateRGBA(plant) }"
                                            style="background-color: rgba(150,250,100,1);">

                                            <td>{{plant.name}}</td>
                                            <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                            <td>{{plant.remainingBalance ?
                                                numeral(plant.remainingBalance).format("0,0.00") : '-'}} กก.
                                            </td>
                                            <td>
                                                <template v-if="plant.lastHarvestDate">
                                                    {{plant.lastHarvestDate | moment("from","now")}}
                                                </template>
                                                <template v-else>
                                                    -
                                                </template>
                                            </td>

                                            <td>{{plant.district ? plant.district.name : '-'}}</td>
                                            <td>{{plant.amphure ? plant.amphure.name : '-'}}</td>
                                            <td>{{plant.province ? plant.province.name : '-'}}</td>
                                            <td>
                                                <button v-if="false"
                                                        @click="OpenSellOrder(plant)"
                                                        type="button" class="btn btn-warning">ประกาศขาย
                                                </button>
                                                <a class="btn btn-success"
                                                   v-bind:href="strFormat(plantTransactionUrl,{id : plant.id})">
                                                    การปลูก
                                                </a>
                                                <a class="btn btn-primary"
                                                   v-bind:href="strFormat(plantEditUrl,{id : plant.id})">แก้ไข</a>
                                                <button @click="deletePlant(plant)" type="button"
                                                        class="btn btn-danger">
                                                    ลบ
                                                </button>
                                            </td>

                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    จำนวนทั้งหมด {{plants.data ? plants.data.length : 0}}
                                                    รายการ
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
                                            <th>แปลง</th>
                                            <th>สถานะ</th>
                                            <th>จำนวน (กก.)</th>
                                            <th>ผู้ติดต่อซื้อ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="order in sellOrders.data">

                                            <td>{{order.created_at | moment("DD-MMM-YYYY")}}</td>
                                            <td>{{order.plant ? order.plant.name : "-"}}</td>
                                            <td>
                                                {{order.sell_confirm_orders.length > 0 ?
                                                order.sell_confirm_orders[0].status : order.status}}
                                            </td>
                                            <td>
                                                {{numeral(order.amount).format("0,0.00")}}
                                                <template
                                                        v-if="order.sell_confirm_orders.length > 0 && order.sell_confirm_orders[0].status == 'Success'">
                                                    ({{order.sell_confirm_orders[0].remark.unit}})
                                                </template>
                                            </td>
                                            <td>
                                                <template>
                                                    <template v-for="cforder in order.sell_confirm_orders">
                                                        {{cforder.buy_order.user.name}} -
                                                        {{cforder.buy_order.user.contact_number}}
                                                    </template>
                                                </template>
                                            </td>
                                            <td>
                                                <button v-if="order.status != 'Closed'" type="button"
                                                        class="btn btn-danger" @click="closeOrder(order)">
                                                    ยกเลิก
                                                </button>
                                            </td>

                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    จำนวนทั้งหมด {{sellOrders.total}} รายการ
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
    import FarmerProfileColumn from './FarmerProfileColumn.vue'
    import numeral from 'numeral'

    export default {
        props: {
            roleType: String,
            showSidePanel: true,
        },
        components: {
            FarmerProfileColumn,
            numeral
        },
        data() {
            return {
                //url refactoring
                plantCreateUrl: this.$routes.web[this.roleType].plant + '/create',
                plantEditUrl: this.$routes.web[this.roleType].plant + '/{id}/edit',
                plantTransactionUrl: this.$routes.web[this.roleType].plant + '/{id}/view',
                plantDeleteApi: this.$routes.api[this.roleType].plant + '/{id}',
                plantOpenSellOrderApi: this.$routes.api[this.roleType].plant + '/{id}/open/sell',
                plantLoadOrderUrl: this.$routes.api.farmer.order,
                //
                farmerData: {
                    withbalance: true,
                    withLastHarvest: true,
                },
                sellOrders: [],
                plants: {},
                sellOrder: {
                    form: {},
                    errors: {},
                },
                openFormStatus: false,
            }
        },
        methods: {
            strFormat: window.strFormat,

            calculateRGBA: function (plant) {
                var now = moment();
                var lastdate = plant.lastHarvestDate

                var c = now.diff(lastdate, "days");
                c = Math.abs(c);

                var alpha = c > 90 ? 1 : 1 - (90 - c) / 90;

                return 'rgba(150,250,100,' + alpha + ')'
            },

            openSellOrderForm: function () {
                this.openFormStatus = true;
            },
            saveOpenSellOrderForm: function () {
                console.log(this.sellOrder.form);
                this.sellOrders.errors = {};
                axios.post(this.plantLoadOrderUrl + "/sell/open", this.sellOrder.form)
                    .then(res => {
                        this.openFormStatus = false;
                        this.sellOrders.form = {};

                    })
                    .catch(err => {
                        this.sellOrders.errors = err.response.data;
                    })
            },
            loadOrders: function () {

                axios.get(this.plantLoadOrderUrl)
                    .then(response => {
                        this.sellOrders = response.data;
                        this.sellOrders.data = _.orderBy(this.sellOrders.data, function (d) {
                            if (d.status == "Closed") return 3;
                            if (d.status == "Open") return 2;
                            if (d.status == "Pending") return 1;

                        })
                    })
            },

            closeOrder: function (order) {
                if (confirm("ต้องการลบรายการขายนี้?")) {
                    axios.post(this.$routes.api[this.roleType] + "/order/" + order.id + "/close")
                        .then(response => {
                            console.log(response.data);
                            this.loadOrders();
                        })
                        .catch(error => {

                        })
                }
            },

            OpenSellOrder: function (plant) {
                var form = {
                    "amount": plant.remainingBalance.toFixed(2)
                }

                axios.post(this.strFormat(this.plantOpenSellOrderApi, {id: plant.id}), form)
                    .then(response => {
                        var data = response.data;
                        this.reloadPlants();
                    })
                    .catch(error => {
                        var data = error.response.data;
                    })
            },
            loadFarmerData: function () {
                axios.get(this.$routes.api[this.roleType].index)
                    .then(response => {
                            this.farmerData = response.data
                        }
                    )
            },
            deletePlant: function (plant) {
                if (confirm("ต้องการลบแปลงหม่อนนี้?")) {
                    this.$http.delete(this.strFormat(this.plantDeleteApi, {id: plant.id}), {}).then(function (r) {
                        this.loadFarmerData();
                        if (this.roleType == 'farmer') {
                            window.location.href = this.$routes.web[this.roleType].index;
                        } else {
                            window.location.href = this.$routes.web[this.roleType].plant;
                        }

                    })
                }
            },

            reloadPlants: function () {
                axios.get(this.$routes.api[this.roleType].plant)
                    .then(response => {
                        var data = response.data;
                        var d = data.data
                        d = _.orderBy(d, ["lastHarvestDate"], ["asc"])
                        data.data = d;
                        this.plants = data;
                    })
                    .catch(error => {
                    })
            },
        },
        created() {
            this.loadFarmerData();
        },
        mounted() {
            this.reloadPlants();
            //this.loadOrders();
        }
    }
</script>