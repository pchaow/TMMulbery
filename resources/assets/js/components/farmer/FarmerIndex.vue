<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    Search Farmer
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="search">
                            <div class="form-group">
                                <label>Keyword : </label>
                                <input class="form-control" v-model="form.keyword" @keypress placeholder="keyword"/>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" @click="reset" class="btn btn-default">Clear</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="btn-group btn-group-sm pull-right">
                        <a v-bind:href="createFarmerUrl" class="btn btn-default">Create Farmer</a>
                    </div>
                    Farmer Table
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>E-mail</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="farmer in farmers">
                                    <td>{{farmer.email}}</td>
                                    <td>{{farmer.username}}</td>
                                    <td>{{farmer.name}}</td>
                                    <td>


                                        <a v-bind:href="strFormat(editUrl,{id : farmer.id})"
                                           class="btn btn-primary">Edit</a>
                                        <button type="button" class="btn btn-danger" v-on:click="deleteFarmer(farmer)">
                                            Delete
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
            editUrl : String,
            loadFarmerUrl : String,
            deleteUrl : String,
            createFarmerUrl : String
        },
        data() {
            return {
                farmers: [],
                farmersPage: {},
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
                this.$http.get(this.loadFarmerUrl, {
                    params: this.form
                }).then(function (r) {
                    console.log(r.data)
                    this.farmersPage = r.data
                    this.farmers = this.farmersPage.data
                })
            },
            deleteFarmer: function (farmer) {
                if (confirm("Do you want to delete this farmer?")) {
                    this.$http.delete(this.strFormat(this.deleteUrl,{id:farmer.id}), {
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
