<template>
    <div class="row" v-if="farmer">
        <div class="col-md-12" v-show="showSidePanel">

            <farmer-profile-column v-if="farmerData"
                                   :farmer="farmerData"
                                   :edit-url="farmerEditUrl"
            ></farmer-profile-column>
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

                                    <a v-bind:href="plantCreateUrl" class="btn btn-default">
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
                                        <tr v-for="plant in plants.data">

                                            <td>{{plant.name}}</td>
                                            <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                            <td>{{numeral(plant.remainingBalance).format("0,0.00")}}</td>
                                            <td>
                                                {{plant.lastHarvestDate ? plant.lastHarvestDate : '-' | moment("from", "now")}}
                                            </td>
                                            <td>{{plant.district ? plant.district.name : '-'}}</td>
                                            <td>{{plant.amphure ? plant.amphure.name : '-'}}</td>
                                            <td>{{plant.province ? plant.province.name : '-'}}</td>
                                            <td>
                                                <button v-if="plantOpenSellOrderUrl && plant.countOpenOrder == 0"
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
                                                    จำนวนทั้งหมด {{farmerData.plants ? farmerData.plants.length : 0}} รายการ
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
                                            <td>{{order.plant ? order.plant.name : "ERROR"}}</td>
                                            <td>{{order.sell_confirm_orders.length > 0 ? order.sell_confirm_orders[0].status : order.status}}</td>
                                            <td>
                                                {{numeral(order.amount).format("0,0.00")}}
                                                <template v-if="order.sell_confirm_orders.length > 0 && order.sell_confirm_orders[0].status == 'Success'">
                                                    ({{order.sell_confirm_orders[0].remark.unit}})
                                                </template>
                                            </td>
                                            <td>
                                                <template>
                                                    <template v-for="cforder in order.sell_confirm_orders">
                                                        {{cforder.buy_order.user.name}} - {{cforder.buy_order.user.contact_number}}
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
            loadUrl: String,
            farmerApiUrl: String,
            farmerEditUrl: String,
            farmerLoadUrl: String,
            plantCreateUrl: String,
            plantEditUrl: String,
            plantDeleteUrl: String,
            plantTransactionUrl: String,
            farmer: Object,
            plantOpenSellOrderUrl: String,
            plantLoadOrderUrl: String,
            showSidePanel: true,
            loadPlantUrl: String,

        },
        components: {
            FarmerProfileColumn,
            numeral
        },
        data() {
            return {
                farmerData: {
                    withbalance: true,
                    withLastHarvest: true,
                },
                sellOrders: [],
                plants: [],
            }
        },
        methods: {
            strFormat: window.strFormat,

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
                axios.post(this.farmerApiUrl + "/order/" + order.id + "/close")
                    .then(response => {
                        console.log(response.data);
                        this.loadOrders();
                    })
                    .catch(error => {

                    })
            },

            OpenSellOrder: function (plant) {
                var form = {
                    "amount": plant.remainingBalance.toFixed(2)
                }

                axios.post(this.strFormat(this.plantOpenSellOrderUrl, {id: plant.id}), form)
                    .then(response => {
                        var data = response.data;
                        this.reloadPlants();
                    })
                    .catch(error => {
                        var data = error.response.data;
                    })
            },
            loadFarmerData: function () {
                this.$http.get(this.farmerLoadUrl).then(
                    function (response) {
                        this.farmerData = response.data
                    }
                )
            },
            deletePlant: function (plant) {
                if (confirm("Do you want to delete this plant?")) {
                    this.$http.delete(this.strFormat(this.plantDeleteUrl, {id: plant.id}), {}).then(function (r) {
                        this.loadFarmerData();
                        window.location.href = "/home"
                    })
                }
            },

            reloadPlants: function () {
                axios.get(this.loadPlantUrl)
                    .then(response => {
                        this.plants = response.data;
                        console.log(response.data);
                    })
                    .catch(error => {

                    })
            },


        },
        created() {
            this.farmerData = this.farmer;

        },
        mounted() {
            console.log(this.farmer.plants);
            this.reloadPlants();
            //this.loadOrders();
        }
    }
</script>