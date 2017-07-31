<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    แปลงเกษตรกรในเครือข่าย
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
                            <tr v-for="plant in plants">
                                <td>{{plant.name}}</td>
                                <td>{{plant.user.name}}</td>
                                <td>{{plant.user.contact_number}}</td>
                                <td>{{plant.area_rai}} ไร่ {{plant.area_ngan}} งาน</td>
                                <td>{{numeral(plant.remainingBalance).format("0,0.00")}}</td>
                                <td>
                                    <template v-if="plant.lastHarvestDate">
                                        {{plant.lastHarvestDate | moment("from",'now') }}
                                    </template>
                                    <template v-else >
                                        -
                                    </template>
                                </td>
                                <td>ตำบล {{plant.district ? plant.district.name : '-'}} อำเภอ {{plant.amphure ?
                                    plant.amphure.name : '-'}} จังหวัด {{plant.province ? plant.province.name : '-'}}
                                </td>
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
                plants: [],

            }
        },
        methods: {
            loadPlants: function () {
                axios.post(this.$routes.api.buyer.farmerPlant)
                    .then(res => {
                        this.plants = res.data;
                    })
            }
        },
        created() {
            this.loadPlants();
        },
        mounted() {
            console.log('children plant')
        }
    }
</script>