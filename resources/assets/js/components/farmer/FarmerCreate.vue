<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">

                    <i class="fa fa-user-plus"></i>
                    แบบฟอร์มลงทะเบียนเกษตรกร
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form role="form">

                    <div class="panel-body">
                        <h3 class="box-title"><i class="fa fa-laptop"></i> ข้อมูลในการเข้าสู่ระบบ</h3>
                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                            <label class="control-label">Username : </label>
                            <input type="text" class="form-control" placeholder="Username"
                                   v-model="formInputs.username"/>
                            <span v-if="formErrors['username']"
                                  class="help-block">{{ formErrors['username'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['password'] }">
                            <label class="control-label">Password : </label>
                            <input type="password" class="form-control" placeholder="Password"
                                   v-model="formInputs.password"/>
                            <span v-if="formErrors['password']"
                                  class="help-block">{{ formErrors['password'] }}</span>
                        </div>

                        <div class="form-group"
                             v-bind:class="{ 'has-error': formErrors['password_confirmation '] }">
                            <label class="control-label">Password Confirmation : </label>
                            <input type="password" class="form-control" placeholder="Password Confirmation"
                                   v-model="formInputs.password_confirmation "/>
                            <span v-if="formErrors['password_confirmation ']" class="help-block">{{ formErrors['password_confirmation '] }}</span>
                        </div>

                        <h3 class="box-title"><i class="fa fa-user"></i> ข้อมูลส่วนตัว</h3>

                        <div class="form-group">
                            <label for="name">ชื่อ-ชื่อสกุล</label>
                            <input type="text" class="form-control" id="name" placeholder="ชื่อ-ชื่อสกุล">
                        </div>
                        <div class="form-group">
                            <label for="identity">เลขประจำตัวประชาชน</label>
                            <input type="text" class="form-control" id="identity" placeholder="เลขประจำตัวประชาชน 13 หลัก">
                        </div>


                        <div class="form-group">
                            <label>เบอร์โทรติดต่อ</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input type="text" class="form-control" id="contact_number" placeholder="เบอร์โทรติดต่อ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="Email Address">
                            </div>
                            <!-- /.input group -->
                        </div>


                        <h3 class="box-title"> <i class="fa fa-home"></i> ข้อมูลที่อยู่</h3>

                        <div class="form-group">
                            <label for="address">ที่อยู่</label>
                            <input type="text" class="form-control" id="address" placeholder="เลขที่ หมู่บ้าน ถนน">
                        </div>
                        <div class="form-group">
                            <label>จังหวัด</label>
                            <select class="form-control">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>อำเภอ</label>
                            <select class="form-control">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ตำบล</label>
                            <select class="form-control">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="postal_code" placeholder="รหัสไปรษณีย์">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" style="margin-left: 5px">บันทึก</button>
                        <a v-bind:href="successUrl" class="btn btn-default pull-right">ยกเลิก</a>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            saveUrl : String,
            successUrl : String,
            loadRolesUrl : String,
        },
        data() {
            return {
                roles: [],
                formInputs: {
                    roles: [],
                },
                formErrors: [],
            }
        },
        methods: {
            strFormat : window.strFormat,
            save: function () {
                console.log(this.formInputs);
                this.formErrors = []
                this.$http.post(this.saveUrl, this.formInputs)
                        .then((response) => {
                                    // success callback
                                    console.log(response);
                                    window.location.href = this.successUrl
                                }, (response) => {
                                    // error callback
                                    this.formErrors = response.data;
                                }
                        );
            },
            loadRoles: function () {
                this.$http.get(this.loadRolesUrl, {
                    params: {all: true}
                }).then(function (r) {
                    console.log(r.data)
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.loadRoles();
        }
    }




</script>
