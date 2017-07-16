<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    ค้นหาผู้รับซื้อ
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
                        <a v-bind:href="createBuyerUrl" class="btn btn-default">ลงทะเบียนผู้รับซื้อ</a>
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
                                    <th>บัญชีผู้ใช้</th>
                                    <th>อีเมล</th>
                                    <th>ตำบล</th>
                                    <th>อำเภอ</th>
                                    <th>จังหวัด</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="buyer in buyers">
                                    <td>{{buyer.name}}</td>
                                    <td>{{buyer.username}}</td>
                                    <td>{{buyer.email}}</td>
                                    <td>{{buyer.district ? buyer.district.name : '-'}}</td>
                                    <td>{{buyer.amphure ? buyer.amphure.name : '-'}}</td>
                                    <td>{{buyer.province ? buyer.province.name : '-'}}</td>
                                    <td>

                                        <a v-bind:href="strFormat(viewUrl,{id : buyer.id})"
                                           class="btn btn-success">รายละเอียด</a>
                                        <a v-bind:href="strFormat(editUrl,{id : buyer.id})"
                                           class="btn btn-primary">แก้ไข</a>



                                        <button type="button" class="btn btn-danger" v-on:click="deleteBuyer(buyer)">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div>
                                            จำนวนทั้งหมด {{buyersPage.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (buyersPage.current_page == n) }"

                                                v-for="n in buyersPage.last_page ">
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
            editUrl: String,
            viewUrl: String,
            loadBuyerUrl: String,
            deleteUrl: String,
            createBuyerUrl: String
        },
        data() {
            return {
                buyers: [],
                buyersPage: {},
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
                this.$http.get(this.loadBuyerUrl, {
                    params: this.form
                }).then(function (r) {
                    console.log(r.data)
                    this.buyersPage = r.data
                    this.buyers = this.buyersPage.data
                })
            },
            deleteBuyer: function (buyer) {
                if (confirm("ต้องการลบผู้รับซื้อ?")) {
                    this.$http.delete(this.strFormat(this.deleteUrl, {id: buyer.id}), {
                        params: this.form
                    }).then(function (r) {
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
