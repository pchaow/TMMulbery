<template>
    <div class="vue-map-container">
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-md-12">
                <div class="input-group input-group-sm">
                    <input type="text" ref="address" class="form-control" placeholder="ค้นหาจากที่อยู่">
                    <span class="input-group-btn">
                      <button v-on:click="searchClick"
                              type="button" ref="search" class="btn btn-info btn-flat">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="vue-map" ref="vueMap"></div>
            </div>
        </div>


        <slot></slot>
    </div>
</template>
<style>
    .vue-map-container {
        width: 100%;
        height: 400px;
    }

    .vue-map-container .vue-map {
        width: 100%;
        height: 400px;
    }

</style>
<script>
    export default{
        props: {
            lat: Number,
            lng: Number,

        },
        data(){
            return {
                map: null,
                geocoder: null,
            }
        },
        methods: {
            searchClick: function () {
                this.geocodeAddress(this.geocoder, this.map)
            },
            geocodeAddress: function (geocoder, resultsMap) {
                var address = this.$refs.address.value;
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            },

            initMap: function () {
                const element = this.$refs.vueMap;
                this.map = new google.maps.Map(element, {
                    center: {
                        lat: this.lat,
                        lng: this.lng
                    },
                    scrollwheel: false,
                    zoom: 10
                })

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.MARKER,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
                    },
                    markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
                    circleOptions: {
                        fillColor: '#ffff00',
                        fillOpacity: 1,
                        strokeWeight: 5,
                        clickable: false,
                        editable: true,
                        zIndex: 1
                    }
                });
                drawingManager.setMap(this.map);

                this.geocoder = new google.maps.Geocoder();



            }
        },
        mounted: function () {
            this.initMap();
        }
    }
</script>
