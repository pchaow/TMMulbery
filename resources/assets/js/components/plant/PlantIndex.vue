<template>
    <div class="row">
        <div class="col-md-12">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-search"></i>
                    ค้นหาแปลงหม่อน
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="search">
                            <div class="form-group">
                                <label>คำสำคัญ : </label>
                                <input class="form-control" v-model="form.keyword" @keypress
                                       placeholder="กรอกคำสำคัญที่ต้องการค้นหา"/>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                                <button type="button" @click="reset" class="btn btn-default">ยกเลิก</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="btn-group btn-group-sm pull-right">
                        <a v-bind:href="createUrl" class="btn btn-success" style="padding-bottom: 2px"><i
                                class="fa fa-plus"></i> เพิ่มแปลงหม่อน</a>
                    </div>
                    <i class="fa fa-tree"></i>
                    รายการแปลงหม่อน
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>เกษตรกร</th>
                                    <th>ชื่อแปลงหม่อน</th>
                                    <th>พื้นที่โดยประมาณ(ตรม.)</th>
                                    <th>ตำบล</th>
                                    <th>อำเภอ</th>
                                    <th>จังหวัด</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="p in plants">
                                    <td>กอไก่ ใจดี</td>
                                    <td>A1</td>
                                    <td>100,000</td>
                                    <td>แม่กา</td>
                                    <td>เมือง</td>
                                    <td>พะเยา</td>
                                    <td>
                                        <a class="btn btn-primary">เปิดดู</a>
                                        <a class="btn btn-warning">แก้ไข</a>
                                        <button type="button" class="btn btn-danger">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
<<<<<<< HEAD
                                <tr>
                                    <td>กอไก่ ใจดี</td>
                                    <td>A2</td>
                                    <td>5,000</td>
                                    <td>แม่ต๋ำ</td>
                                    <td>เมือง</td>
                                    <td>พะเยา</td>

                                    <td>
                                        <a class="btn btn-primary">เปิดดู</a>
                                        <a class="btn btn-warning">แก้ไข</a>
                                        <button type="button" class="btn btn-danger">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>กอไก่ ใจดี</td>
                                    <td>A3</td>
                                    <td>3,000</td>
                                    <td>แม่นาเรือ</td>
                                    <td>เมือง</td>
                                    <td>พะเยา</td>

                                    <td>
                                        <a class="btn btn-primary">เปิดดู</a>
                                        <a class="btn btn-warning">แก้ไข</a>
                                        <button type="button" class="btn btn-danger">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>ชอช้าง ขยันดี</td>
                                    <td></td>
                                    <td>40,000</td>
                                    <td>ก่อ</td>
                                    <td>ลี้</td>
                                    <td>ลำพูน</td>

                                    <td>
                                        <a class="btn btn-primary">เปิดดู</a>
                                        <a class="btn btn-warning">แก้ไข</a>
                                        <button type="button" class="btn btn-danger">
                                            ลบ
                                        </button>
                                    </td>
                                </tr>

=======
>>>>>>> origin/master
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            จำนวนทั้งหมด {{page.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (page.current_page == n) }"

                                                v-for="n in page.last_page ">
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
            createUrl : String,
            loadUrl : String,
            deleteUrl : String,
        },
        data() {
            return {
                roles: [],
                page: {},
                form: {
                    keyword: "",
                    page: 1,
                }
            }
        },
        methods: {
            strFormat : window.strFormat,
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
                this.$http.get(this.loadUrl, {
                    params: this.form
                }).then(function (r) {
//                    console.log(r.data)
                    this.page = r.data
                    this.plants = this.page.data
                })
            },
            deletePlant: function (plant) {
                if (confirm("คุณต้องการลบแปลงนี้หรือไม่ ?")) {
                    this.$http.delete(this.strFormat(this.deleteUrl,{id:plant.id}), {
                        params: this.form
                    }).then(function (r) {
                        this.load()
                    })
                }

            }
        },
        mounted() {
            console.log(this.loadUrl);
            this.load();
        }
    }





</script>
