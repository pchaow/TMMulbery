<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    แบบฟอร์มลงทะเบียนผู้รับซื้อ
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลส่วนตัว</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['identity'] }">
                                    <label class="control-label">เลขประจำตัวประชาชน : </label>
                                    <input class="form-control" placeholder="หมายเลขประจำตัวประชาชน 13 หลัก"
                                           v-model="formInputs.identity"/>
                                    <span v-if="formErrors['identity']"
                                          class="help-block">{{ formErrors['identity'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                    <label class="control-label">ชื่อ-นามสกุล : </label>
                                    <input class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                    <span v-if="formErrors['name']"
                                          class="help-block">{{ formErrors['name'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['contact_number'] }">
                                    <label class="control-label">เบอร์โทรศัพท์ : </label>
                                    <input class="form-control" placeholder="เบอร์โทรศัพท์"
                                           v-model="formInputs.contact_number"/>
                                    <span v-if="formErrors['contact_number']" class="help-block">{{ formErrors['contact_number'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['address'] }">
                                    <label class="control-label">ที่อยู่ : </label>
                                    <input class="form-control" placeholder="ที่อยู่" v-model="formInputs.address"/>
                                    <span v-if="formErrors['address']"
                                          class="help-block">{{ formErrors['address'] }}</span>
                                </div>

                                <province v-bind:province="formInputs.province_id"
                                          v-on:province_update="formInputs.province_id = arguments[0]"
                                          v-bind:amphure="formInputs.amphure_id"
                                          v-on:amphure_update="formInputs.amphure_id = arguments[0]"
                                          v-bind:district="formInputs.district_id"
                                          v-on:district_update="formInputs.district_id = arguments[0]"
                                          v-bind:formErrors="formErrors"
                                ></province>


                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['postal_code'] }">
                                    <label class="control-label">รหัสไปรษณีย์ : </label>
                                    <input class="form-control" placeholder="รหัสไปรษณีย์"
                                           v-model="formInputs.postal_code"/>
                                    <span v-if="formErrors['postal_code']" class="help-block">{{ formErrors['postal_code'] }}</span>
                                </div>
                            </fieldset>

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลการเข้าใช้งานระบบ</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['email'] }">
                                    <label class="control-label">อีเมล : </label>
                                    <input class="form-control" placeholder="E-mail" v-model="formInputs.email"/>
                                    <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                                    <label class="control-label">บัญชีผู้ใช้ : </label>
                                    <input type="text" class="form-control" placeholder="Username"
                                           v-model="formInputs.username"/>
                                    <span v-if="formErrors['username']"
                                          class="help-block">{{ formErrors['username'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['password'] }">
                                    <label class="control-label">รหัสผ่าน : </label>
                                    <input type="password" class="form-control" placeholder="Password"
                                           v-model="formInputs.password"/>
                                    <span v-if="formErrors['password']"
                                          class="help-block">{{ formErrors['password'] }}</span>
                                </div>

                                <div class="form-group"
                                     v-bind:class="{ 'has-error': formErrors['password_confirmation '] }">
                                    <label class="control-label">ยืนยันรหัสผ่าน : </label>
                                    <input type="password" class="form-control" placeholder="Password Confirmation"
                                           v-model="formInputs.password_confirmation "/>
                                    <span v-if="formErrors['password_confirmation ']" class="help-block">{{ formErrors['password_confirmation '] }}</span>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                <a v-bind:href="successUrl" class="btn btn-default">ยกเลิก</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Province from '../../shared/Province.vue'

    export default {
        props: {
            saveUrl : String,
            successUrl : String,

        },
        components : {
            Province
        },
        data() {
            return {
                formInputs: {
                },
                formErrors: {},
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
        },
        mounted() {
            console.log('Component mounted.')
        },
    }




</script>
