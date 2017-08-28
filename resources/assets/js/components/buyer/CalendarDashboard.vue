<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    แผนงาน
                </div>

                <div class="panel-body">

                    <div id="calendar"></div>
                </div>
            </div>
            <div><i class="fa fa-circle text-success"> ปลูก/เก็บเกี่ยว</i></div>
            <div><i class="fa fa-circle text-primary"> คำสั่งซื้อยืนยันแล้ว</i></div>
            <div><i class="fa fa-circle" style="color: #ff00ff"> คำสั่งซื้อยังไม่ได้ยืนยัน</i></div>
        </div>
    </div>
</template>


<style>

    .cdb-transaction {
        background-color: green;
    }

</style>

<script>

    import fullCalendar from 'fullcalendar'

    export default {
        props: {
            roleType: String,
        },
        components: {},
        data() {
            var eventUrl = this.$routes.api[this.roleType].event;
            return {
                fcEvents: [],
                eventUrl: eventUrl,
            }
        },
        methods: {
            initialCalendar: function () {
                var self = this;

                $('#calendar').fullCalendar({
                    height: 650,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'listWeek,month'
                    },

                    // customize the button names,
                    // otherwise they'd all just say "list"
                    views: {
                        listWeek: {buttonText: 'list week'}
                    },

                    events: function (start, end, timezone, callback) {
                        axios.post(self.eventUrl, {
                            start: start.unix(),
                            end: end.unix()
                        })
                            .then(response => {
                                self.fcEvents = response.data;

                                for (var i = 0; i < self.fcEvents.length; i++) {
                                    if (self.fcEvents[i].type == "order") {
                                        if (self.fcEvents[i].status == "Pending") {
                                            self.fcEvents[i].backgroundColor = "#ff00ff"

                                        } else if (self.fcEvents[i].status == "Success") {

                                        }
                                    } else {
                                        self.fcEvents[i].backgroundColor = "#92c340"
                                    }
                                    self.fcEvents[i].allDay = true;
                                }

                                callback(self.fcEvents);
                            })
                    },
                    eventClick: function(calEvent, jsEvent, view) {

                        if(calEvent.link){
                            if(confirm("ไปหน้ายืนยันคำสั่งซื้อหรือไม่")){
                                window.location.href = calEvent.link;
                            }

                        }

                    }

                })

            },
            loadCalendar: function () {
                axios.post(this.$routes.api.buyer.event)
                    .then(res => {
                        this.fcEvents = res.data;

                        for (var i = 0; i < this.fcEvents.length; i++) {
                            if (this.fcEvents[i].type == "order") {

                            } else {
                                this.fcEvents[i].backgroundColor = "green"
                            }
                            this.fcEvents[i].allDay = true;

                        }

                        this.initialCalendar();
                    })
            }
        },
        created() {
        },
        mounted() {
//            this.loadCalendar();
            this.initialCalendar();
        }
    }
</script>