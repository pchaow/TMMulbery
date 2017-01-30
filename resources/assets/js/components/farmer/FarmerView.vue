<template>
          <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">กอไก่ ใจดี</h3>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>แปลงทั้งหมด</b> <a class="pull-right">7</a>
                            </li>

                            <li class="list-group-item">
                                <b>ซื้อขาย</b> <a class="pull-right">287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>

                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                        <p>
                            <span class="label label-danger">UI Design</span>
                            <span class="label label-success">Coding</span>
                            <span class="label label-info">Javascript</span>
                            <span class="label label-warning">PHP</span>
                            <span class="label label-primary">Node.js</span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
        </div>
        <!-- /.row -->







</template>

<script>
    export default {
        props: {
            userId: Number,
            saveUrl: String,
            loadUrl: String,
            successUrl: String,
            loadRolesUrl: String,
        },
        data() {
            return {
                roles: [],
                formInputs: {},
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                    .then((response) => {
                        // success callback
                        // console.log(response);
                        window.location.href = this.successUrl
                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    });


            },
            load: function () {

                this.$http.get(this.loadUrl)
                    .then((response) => {
                        // success callback
                        // console.log(response);
                        this.formInputs = response.data;
                        this.reInitialMultiOption(this.roles, this.formInputs.roles);

                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    })
            },
            loadRoles: function () {
                return this.$http.get(this.loadRolesUrl, {
                    params: {all: true}
                }).then(function (r) {
                    console.log(r.data)
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            },
            reInitialMultiOption: function (master, selected) {

                var choiceOpt = master
                var userOpt = selected

                for (var i = 0; i < choiceOpt.length; i++) {
                    //console.log("choice", choiceOpt[i].id, choiceOpt[i].choice)

                    for (var j = 0; j < userOpt.length; j++) {

                        //console.log("user", userOpt[j])
                        if (choiceOpt[i].id == userOpt[j].id) {
                            choiceOpt.splice(i, 1, userOpt[j]);
                            break;
                        }
                    }
                }
            }
        },
        created(){
            this.loadRoles()
        },
        mounted() {
            console.log('ready to edit user.id =', this.userId)
            this.load()
        }
    }


</script>
