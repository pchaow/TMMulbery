<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Create Farmer
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลส่วนตัว</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['identity'] }">
                                    <label class="control-label">รหัสประจำตัว : </label>
                                    <input class="form-control" placeholder="Identity ID"
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

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['province_id'] }">
                                    <label class="control-label">จังหวัด : </label>
                                    <select class="form-control" v-model="formInputs.province_id">
                                        <option>กรุณาเลือก</option>
                                        <option>AAA</option>
                                        <option>AAA</option>
                                    </select>
                                    <span v-if="formErrors['province_id']" class="help-block">{{ formErrors['province_id'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['amphure_id'] }">
                                    <label class="control-label">อำเภอ : </label>
                                    <select class="form-control" v-model="formInputs.amphure_id">
                                        <option>กรุณาเลือก</option>
                                        <option>AAA</option>
                                        <option>AAA</option>
                                    </select>
                                    <span v-if="formErrors['amphure_id']"
                                          class="help-block">{{ formErrors['amphure_id'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['district_id'] }">
                                    <label class="control-label">ตำบล : </label>
                                    <select class="form-control" v-model="formInputs.district_id">
                                        <option>กรุณาเลือก</option>
                                        <option>AAA</option>
                                        <option>AAA</option>
                                    </select>
                                    <span v-if="formErrors['district_id']" class="help-block">{{ formErrors['district_id'] }}</span>
                                </div>

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
                                    <label class="control-label">E-mail : </label>
                                    <input class="form-control" placeholder="E-mail" v-model="formInputs.email"/>
                                    <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                                    <label class="control-label">รหัสผู้ใช้ : </label>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a v-bind:href="successUrl" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            saveUrl : String,
            successUrl : String,

        },
        data() {
            return {
                formInputs: {
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
        },
        mounted() {
            console.log('Component mounted.')
            this.loadRoles();
        }
    }

</script>
