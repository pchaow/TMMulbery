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
                                <th>พื้นที่</th>
                                <th>คงเหลือเก็บเกี่ยว (กก.)</th>
                                <th>#วันจากการเก็บเกี่ยวล่าสุด</th>
                                <th>ระยะทาง (กม.)</th>
                                <th>คุณภาพ</th>
                                <th>จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="plant in plants"
                                v-bind:style="{ 'background-color' : calculateRGBA(plant) }"
                                style="background-color: rgba(150,250,100,1);">
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

                                <td>{{numeral(plant.distanceFromPiankusol).format("0,0.00")}}</td>
                                <td>
                                    <star-rating :rating="plant.rating" :star-size="20"
                                                 @rating-selected="setRating($event,plant)"
                                                 :show-rating="true"></star-rating>
                                </td>
                                <td> <a v-bind:href="strFormat(viewProfilePlantUrl,{id : plant.id})"
                                        class="btn btn-info">ดูข้อมูล</a>
                                </td>
                            </tr>
                            </tbody>

                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div>
                                        จำนวนทั้งหมด {{plants ? plants.length : 0}}
                                        รายการ
                                    </div>
                                    <ul class="pagination">
                                        <li></li>
                                    </ul>
                                </td>

                            </tr>
                            </tfoot>


                        </table>
                        <div><i class="fa fa-circle text-success"> พร้อมเก็บเกี่ยว</i>
                        <i class="fa fa-circle text-danger"> เก็บเกี่ยวล่วงหน้า</i></div>
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
            var viewProfilePlantUrl = this.$routes.web[this.roleType].plant + "/{id}/profile";

            return {
                plants: [],
                viewProfilePlantUrl: viewProfilePlantUrl,

            }
        },
        methods: {
            calculateRGBA: function (plant) {
                var now = moment();
                var lastdate = plant.lastHarvestDate

                var c = now.diff(lastdate, "days");
                var alpha;
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

                        var data = res.data;
                        var d = data
                      //  console.log(d);
                        d = _.orderBy(d, ["lastHarvestDate"], ["asc"])

                        //console.log(d);
                        data.data = d;
                        this.plants = data.data;
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