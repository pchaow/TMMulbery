<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    ค้นหาแปลงหม่อน
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="search">
                            <div class="form-group">
                                <label>ค้นหาตามคำสำคัญ : </label>
                                <input class="form-control" v-model="form.keyword" @keypress placeholder="คำสำคัญ"/>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                                <button type="button" @click="reset" class="btn btn-default">ล้าง</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการแปลงหม่อน
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive" v-if="plantsPage">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>ชื่อแปลง</th>
                                    <th>เกษตรกร</th>
                                    <th>พื้นที่(ตรม.)</th>
                                    <th>คงเหลือเก็บเกี่ยว</th>
                                    <th>ตำบล</th>
                                    <th>อำเภอ</th>
                                    <th>จังหวัด</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="plant in plants">
                                    <td>{{plant.name}}</td>
                                    <td>{{plant.user ? plant.user.name : '-' }}</td>
                                    <td>{{plant.area_sqm}}</td>
                                    <td><span class="badge bg-gray">Unknown</span></td>
                                    <td>{{plant.district ? plant.district.name : '-'}}</td>
                                    <td>{{plant.amphure ? plant.amphure.name : '-'}}</td>
                                    <td>{{plant.province ? plant.province.name : '-'}}</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div>
                                            จำนวนทั้งหมด {{plantsPage.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (plantsPage.current_page == n) }"

                                                v-for="n in plantsPage.last_page ">
                                                <a style="cursor: default;" v-on:click="gotoPage(n)">{{ n }}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            plantLoadUrl: String,
        },
        data() {
            return {
                plants: null,
                plantsPage: null,
                form: {
                    keyword: "",
                    page: 1,
                }
            }
        },
        methods: {
            strFormat: window.strFormat,
            reset: function () {
                this.form = {
                    keyword: "",
                    page: 1,
                }
            },
            search: function () {
                this.form.page = 1
                this.load();
            },
            gotoPage: function (n) {
                this.form.page = n;
                this.load()
            },
            load: function () {
                this.$http.get(this.plantLoadUrl, {
                    params: this.form
                }).then(function (r) {
                    console.log(r.data)
                    this.plantsPage = r.data
                    this.plants = this.plantsPage.data
                })
            },
        },
        created(){
            this.load();
        },
        mounted() {
            console.log('Component mounted.')

        }
    }


</script>
