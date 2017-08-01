<template>
    <div class="row">

        <div class="col-lg-12">

            <div class="box" style="height: 40em; width: 100%;">
                <gmap-map
                        ref="map"
                        style="width: 100%; height: 100%; position: absolute; left:0; top:0"
                        :center="map_default_position"
                        :zoom="13"
                >
                    <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" :content="infoContent" @closeclick="infoWinOpen=false"></gmap-info-window>
                    <google-marker  :key="i" v-for="(m,i) in maps" :position="m.position" :clickable="true" @click="toggleInfoWindow(m,i)"></google-marker>

                </gmap-map>
            </div>

        </div>
            </div>

</template>

<script>

    Vue.component('google-marker', VueGoogleMaps.Marker);

    export default {
        props: {
            roleType: String,
        },
        components: {},
        data() {

            var default_position = {lat: 18.779465, lng: 99.046323}
            return {
                map_default_position: default_position,
                planningData: null,
                maps: [],
                infoContent: '',
                infoWindowPos: {
                    lat: 0,
                    lng: 0
                },
                infoWinOpen: false,
            }
        },
        methods: {
            markPosition: function (lat, lng, plantName, farmerName) {
                if (lat && lng) {
                    console.log(lat, lng)
                    this.maps.push({
                        position: {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng),
                        },
                        infoText: plantName + " : " + farmerName
                    })
                    console.log(this.maps)
                }

            },
            toggleInfoWindow: function(marker, idx) {
                this.infoWindowPos = marker.position;
                this.infoContent = marker.infoText;
                //check if its the same marker that was selected if yes toggle
                if (this.currentMidx == idx) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMidx = idx;
                }
            },
            initMap: function () {

                axios.post(this.$routes.api.buyer.plantMap)
                    .then(res => {
                        this.planningData = res.data;
                        console.log(this.planningData)
                        for (var i = 0; i < this.planningData[0].length; i++) {
                            this.markPosition(this.planningData[0][i].map[0].position.lat, this.planningData[0][i].map[0].position.lng,this.planningData[0][i].name,this.planningData[0][i].user.name)
                        }
                        for (var i = 0; i < this.planningData[1].length; i++) {
                            this.markPosition(this.planningData[1][i].map[0].position.lat, this.planningData[1][i].map[0].position.lng,this.planningData[1][i].name,this.planningData[1][i].user.name)
                        }

                    })
                    .catch(err => {
                       // this.planningFormError = err.response.data;
                    })



            }
        },
        created() {



        },
        mounted() {
            console.log('Component mounted.')
            this.initMap();
        }
    }
</script>