<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    วางแผนเก็บเกี่ยว
                </div>

                <div class="panel-body">
                    <form role="form" @submit.prevent="planSubmit">
                        <div class="form-group" v-bind:class="{ 'has-error': planningFormError['date'] }">
                            <label>วันที่ต้องการเก็บเกี่ยว</label>
                            <input type="date" v-model="planningForm.date" class="form-control">
                            <span v-if="planningFormError['date']"
                                  class="help-block">{{ planningFormError['date'] }}</span>

                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': planningFormError['rai'] }">
                            <label>จำนวนไร่ที่ต้องการ</label>
                            <input type="number" v-model="planningForm.rai" class="form-control">
                            <span v-if="planningFormError['rai']"
                                  class="help-block">{{ planningFormError['rai'] }}</span>

                        </div>

                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                </div>
            </div>

            <div class="panel panel-info" v-if="planningData">
                <div class="panel-heading">
                    ผลการค้นหา
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">

                            <thead>
                            <tr>
                                <th>ชื่อแปลง</th>
                                <th>ชื่อเกษตรกร</th>
                                <th>เบอร์โทรติดต่อ</th>
                                <th>พื้นที่</th>
                                <th>คงเหลือเก็บเกี่ยว</th>
                                <th>#วันจากการเก็บเกี่ยวล่าสุด</th>
                                <th>จำนวนคำสั่งซื้อที่ยังไม่ยืนยัน</th>
                                <th>ระยะทาง</th>
                                <th>จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="plant in planningData[0]" style="background-color: #fffadd">
                                <td>{{plant.name}}</td>
                                <td>{{plant.user.name}}</td>
                                <td>{{plant.user.contact_number}}</td>
                                <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                <td>{{numeral(plant.planningBalance).format("0,0.00")}} กก.</td>
                                <td v-bind:style="{ 'background-color' : calculateRGBA(plant) }">
                                    {{plant.planningHarvestDate}}
                                </td>
                                <td>{{plant.countOpenOrder}}</td>
                                <td>
                                    <template v-if="plant.distanceFromPiankusol">
                                        {{ numeral(plant.distanceFromPiankusol).format("0,0.00")}} กม.
                                    </template>
                                    <template v-else>
                                        -
                                    </template>

                                </td>
                                <td>
                                    <a :href="$routes.web.buyer.plant + '/' + plant.id + '/view?previous='+$routes.web.buyer.plan "
                                       class="btn btn-success">การปลูก</a>
                                </td>
                            </tr>

                            <tr v-for="plant in planningData[1]">
                                <td>{{plant.name}}</td>
                                <td>{{plant.user.name}}</td>
                                <td>{{plant.user.contact_number}}</td>
                                <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                <td>{{numeral(plant.planningBalance).format("0,0.00")}}</td>
                                <td v-bind:style="{ 'background-color' : calculateRGBA(plant) }">
                                    {{plant.planningHarvestDate}}
                                </td>
                                <td>{{plant.countOpenOrder}}</td>
                                <td>
                                    <template v-if="plant.distanceFromPiankusol">
                                        {{ numeral(plant.distanceFromPiankusol).format("0,0.00")}} กม.
                                    </template>
                                    <template v-else>
                                        -
                                    </template>

                                </td>
                                <td>

                                    <button type="button" class="btn btn-default" @click="buyPlant(plant)">
                                        ซื้อ
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div><i class="fa fa-circle text-success">พร้อมเก็บเกี่ยว</i></div>
                <div><i class="fa fa-circle text-yellow"> แปลงของตัวเอง</i></div>
                <div><i class="fa fa-circle text-danger"> เก็บเกี่ยวล่วงหน้า</i></div>
            </div>


            <div class="panel panel-info" v-if="state == 'buy'">
                <div class="panel-heading">
                    ซื้อ {{buyForm.plant.name}}
                </div>

                <div class="panel-body">
                    <form role="form" @submit.prevent="createBuyOrder">
                        <div class="form-group" v-bind:class="{ 'has-error': buyFormError['date'] }">
                            <label>วันที่ซื้อ</label>
                            <input type="date" v-model="buyForm.date" class="form-control">
                            <span v-if="buyFormError['date']"
                                  class="help-block">{{ buyFormError['date'] }}</span>

                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': buyFormError['amount_rai'] }">
                            <label>จำนวนพื้นที่ที่ต้องการ (ไร่)</label>
                            <input type="number" v-model="buyForm.amount_rai" class="form-control">
                            <span v-if="buyFormError['amount_rai']"
                                  class="help-block">{{ buyFormError['amount_rai'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': buyFormError['amount_kg'] }">
                            <label>ปริมาณใบหม่อน คาดการณ์ (กก.)</label>
                            <input type="number" v-model="buyForm.amount_kg" class="form-control">
                            <span v-if="buyFormError['amount_kg']"
                                  class="help-block">{{ buyFormError['amount_kg'] }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary">สั่งซื้อ</button>
                        <button type="button" @click="cancelBuy" class="btn btn-default">ยกเลิก</button>
                    </form>
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
                planningForm: {
                    date: moment().format("YYYY-MM-DD"),
                    rai: 1,
                },
                planningFormError: {
                    date: null,
                    rai: null,
                },
                planningData: null,

                state: 'default',
                buyForm: {},
                buyFormError: {},

            }
        },
        methods: {
            calculateRGBA: function (plant) {
                var c = plant.planningHarvestDate
                var alpha = 0;
                console.log(c);
                if (c < 0) {
                    c = Math.abs(c)
                    c = c > 90 ? 90 : c;
                    alpha = c/90/2

                    console.log(alpha);
                    return 'rgba(255,0,0,' + alpha + ')'

                } else {
                    c = Math.abs(c);
                    alpha = c > 90 ? 1 : 1 - (90 - c) / 90;
                    return 'rgba(150,250,100,' + alpha + ')'
                }

            },
            createBuyOrder: function () {
                if (confirm("ยืนยันคำสั่งซื้อ")) {
                    axios.post(this.$routes.api.buyer.openBuySellOrder, this.buyForm)
                        .then(r => {
                            console.log(r.data);
                            window.location.href = this.$routes.web.buyer.index;
                        })
                }

            },
            resetState: function () {
                this.planningData = null;
                this.state = 'default';
                this.buyForm = {}
                this.buyFormError = {}
            },
            cancelBuy: function () {
                this.state = 'default';
                this.buyForm = {}
                this.buyFormError = {}
            },
            orderPlant: function (plants) {
                return _.orderBy(plants, ["planningHarvestDate", "distanceFromPiankusol"], ["desc", "asc"])
            },
            planSubmit: function () {

                this.resetState();

                this.planningFormError = {
                    date: null,
                    rai: null,
                }
                axios.post(this.$routes.api.buyer.plan, this.planningForm)
                    .then(res => {
                        this.planningData = res.data;

                        //do order here
                        this.planningData[0] = this.orderPlant(this.planningData[0])
                        this.planningData[1] = this.orderPlant(this.planningData[1])


                    })
                    .catch(err => {
                        this.planningFormError = err.response.data;
                    })
            },
            buyPlant: function (plant) {
                this.state = "buy"
                this.buyForm.date = this.planningForm.date
                this.buyForm.amount_rai = this.planningForm.rai
                var expectedValue = 0
                if (plant.area_sqm / 1600 <= this.buyForm.rai) {
                    expectedValue = Math.floor(plant.planningBalance);
                    this.buyForm.amount_rai = Math.floor(plant.area_sqm / 1600);
                } else {
                    expectedValue = Math.floor(plant.planningBalance / plant.area_sqm * 1600 * this.planningForm.rai);
                }
                this.buyForm.amount_kg = expectedValue;

                this.buyForm.plant = plant;
            }

        },
        created() {
        },
        mounted() {
        }
    }
</script>