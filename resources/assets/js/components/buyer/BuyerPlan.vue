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
                                <th>name</th>
                                <th>farmer name</th>
                                <th>tel</th>
                                <th>area</th>
                                <th>remaining balance</th>
                                <th>last plan harvest date</th>
                                <th>address</th>
                                <th>length</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="plant in planningData">
                                <td>{{plant.name}}</td>
                                <td>{{plant.user.name}}</td>
                                <td>{{plant.user.contact_number}}</td>
                                <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                <td>{{plant.planningBalance}}</td>
                                <td>{{plant.planningHarvestDate}}</td>
                                <td>ตำบล {{plant.district ? plant.district.name : '-'}} อำเภอ {{plant.amphure ? plant.amphure.name : '-'}} จังหวัด {{plant.province ? plant.province.name : '-'}} </td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-default">
                                        ซื้อ
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                planningForm: {
                    date: moment().format("YYYY-MM-DD"),
                    rai: 1,
                },
                planningFormError: {
                    date: null,
                    rai: null,
                },
                planningData: null,

            }
        },
        methods: {
            planSubmit: function () {
                this.planningData = null;
                this.planningFormError = {
                    date: null,
                    rai: null,
                }
                axios.post(this.$routes.api.buyer.plan, this.planningForm)
                    .then(res => {
                        this.planningData = res.data;
                    })
                    .catch(err => {
                        this.planningFormError = err.response.data;
                    })
            }
        },
        created() {
        },
        mounted() {
        }
    }
</script>