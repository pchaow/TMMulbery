<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    ค้นหาเกษตรกร
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
                    <div class="btn-group btn-group-sm pull-right">
                        <a v-bind:href="createFarmerUrl" class="btn btn-warning">ลงทะเบียนเกษตรกร</a>
                    </div>
                    รายการเกษตรกร
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>ชื่อ-ชื่อสกุล</th>
                                    <th>ชื่อบัญชีผู้ใช้</th>
                                    <th>อีเมล</th>
                                    <th>ตำบล</th>
                                    <th>อำเภอ</th>
                                    <th>จังหวัด</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="farmer in farmers">
                                    <td>{{farmer.name}}</td>
                                    <td>{{farmer.username}}</td>
                                    <td>{{farmer.email}}</td>
                                    <td>{{farmer.district ? farmer.district.name : '-'}}</td>
                                    <td>{{farmer.amphure ? farmer.amphure.name : '-'}}</td>
                                    <td>{{farmer.province ? farmer.province.name : '-'}}</td>
                                    <td>
                                        <a v-bind:href="strFormat(editUrl,{id : farmer.id})"
                                           class="btn btn-primary">แก้ไข</a>

                                        <button type="button" class="btn btn-danger" v-on:click="deleteFarmer(farmer)">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div>
                                            จำนวนทั้งหมด {{farmersPage.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (farmersPage.current_page == n) }"

                                                v-for="n in farmersPage.last_page ">
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
            roleType: String,
        },
        data() {

            var editUrl = this.$routes.web[this.roleType].farmer.index + "/{id}/edit";
            var viewUrl = this.$routes.web[this.roleType].farmer.index + "/{id}/view";
            var deleteUrl = this.$routes.api[this.roleType].farmer + "/{id}";
            var loadFarmerUrl = this.$routes.api[this.roleType].farmer;

            var createFarmerUrl = this.$routes.web[this.roleType].farmer.create;

            console.log(loadFarmerUrl);
            return {
                editUrl: editUrl,
                viewUrl: viewUrl,
                deleteUrl: deleteUrl,
                loadFarmerUrl: loadFarmerUrl,
                createFarmerUrl: createFarmerUrl,

                farmers: [],
                farmersPage: {},
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
                axios.get(this.loadFarmerUrl, {
                    params: this.form
                }).then(r => {
                    console.log(r.data)
                    this.farmersPage = r.data
                    this.farmers = this.farmersPage.data
                })
            },
            deleteFarmer: function (farmer) {
                if (confirm("ต้องการลบเกษตรกรรายนี้?")) {
                    axios.delete(this.strFormat(this.deleteUrl, {id: farmer.id})).then(response => {
                        console.log(response)
                        this.load()
                    })
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.load();
        }
    }


</script>
