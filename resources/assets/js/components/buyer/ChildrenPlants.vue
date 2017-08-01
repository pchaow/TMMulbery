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
                                <th>ชื่อแปลง</th>
                                <th>ชื่อเกษตรกร</th>
                                <th>เบอร์โทรติดต่อ</th>
                                <th>พื้นที่จำนวน</th>
                                <th>คงเหลือเก็บเกี่ยว (กก.)</th>
                                <th>ระยะเวลาจากวันเก็บเกี่ยวล่าสุด (วัน)</th>
                                <th>ที่อยู่</th>
                                <th>ระยะทาง</th>
                                <th>คุณภาพ</th>
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
                                    <template v-else>
                                        -
                                    </template>
                                </td>
                                <td>ตำบล {{plant.district ? plant.district.name : '-'}} อำเภอ {{plant.amphure ?
                                    plant.amphure.name : '-'}} จังหวัด {{plant.province ? plant.province.name : '-'}}
                                </td>
                                <td></td>
                                <td>
                                    <star-rating v-model="plant.rating" :star-size="20"
                                                 @rating-selected="setRating($event,plant)"
                                                 :show-rating="false"></star-rating>
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

    import StarRating from 'vue-star-rating'


    export default {
        props: {
            roleType: String,
        },
        components: {
            StarRating,
        },
        data() {
            return {
                plants: [],

            }
        },
        methods: {
            setRating: function ($event, plant) {
                axios.post(this.$routes.api.buyer.plant_rating, {
                    'plant_id': plant.id,
                    'rating': $event,
                })
                    .then(r => {
                        plant.rating = $event;
                        console.log(r);
                    })
            },
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