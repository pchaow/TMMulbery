<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    ค้นหาสิทธิการใช้งาน
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
                        <a v-bind:href="createUrl" class="btn btn-default">เพิ่มสิทธิการใช้งาน</a>
                    </div>
                    ตารางสิทธิการใช้งาน
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>ชื่อสิทธิการใช้งาน</th>
                                    <th>ชื่อที่ใช้แสดง</th>
                                    <th>คำอธิบาย</th>
                                    <th>จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="role in roles">
                                    <td>{{role.name}}</td>
                                    <td>{{role.display_name}}</td>
                                    <td>{{role.description}}</td>
                                    <td>
                                        <a v-bind:href="strFormat(editUrl,{id : role.id})"
                                           class="btn btn-primary">แก้ไข</a>
                                        <button type="button" class="btn btn-danger" v-on:click="deleteRole(role)">
                                            ลบ
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            จำนวนทั้งหมด {{rolesPage.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (rolesPage.current_page == n) }"

                                                v-for="n in rolesPage.last_page ">
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
            createUrl: String,
            editUrl : String,
            successUrl : String,
            loadUrl : String,
            deleteUrl : String,
        },
        data() {
            return {
                roles: [],
                rolesPage: {},
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
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            },
            deleteRole: function (role) {
                if (confirm("Do you want to delete this role?")) {
                    this.$http.delete(this.deleteUrl + role.id, {
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
