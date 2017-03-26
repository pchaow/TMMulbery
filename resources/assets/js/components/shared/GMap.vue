<template>
    <div class="vue-map-container">
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-success dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    เพิ่ม
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a v-on:click="setDrawingMode('marker')">Marker</a></li>
                    <li><a>Rectangle</a></li>
                    <li><a>Polygon</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="input-group input-group-sm">
                    <input v-bind:value="text" type="text" ref="address" class="form-control"
                           placeholder="ค้นหาจากที่อยู่">
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
    .dropdown-menu li a {
        cursor: pointer;
    }

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
            text: String,

        },
        data(){
            return {
                map: null,
                geocoder: null,
                drawingManager: null,
            }
        },
        methods: {
            setDrawingMode: function (type) {
                this.drawingManager.setDrawingMode(type);
            },
            searchClick: function () {
                this.geocodeAddress(this.geocoder, this.map)
            },
            geocodeAddress: function (geocoder, resultsMap) {
                var address = this.$refs.address.value;
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            },
            initDrawingManager(){
                this.drawingManager = new google.maps.drawing.DrawingManager({
                    drawingControl: false,

                    markerOptions: {
                        icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                        draggable: true,
                        clickable: true,
                    },
                    circleOptions: {
                        fillColor: '#ffff00',
                        fillOpacity: 1,
                        strokeWeight: 5,
                        clickable: false,
                        editable: true,
                        zIndex: 1,
                    }
                });
                this.drawingManager.setMap(this.map);

                google.maps.event.addListener(this.drawingManager, 'markercomplete', function (marker) {
                    this.setDrawingMode(null);

                    marker.infowindow = new google.maps.InfoWindow({
                        content: "Hello World"
                    });

                    marker.addListener('click', function () {
                        marker.infowindow.open(this.map, marker);
                    })
                });
            },
            initMap: function () {
                const element = this.$refs.vueMap;
                this.map = new google.maps.Map(element, {
                    center: {
                        lat: this.lat,
                        lng: this.lng
                    },
                    scrollwheel: true,
                    zoom: 10
                })
                this.geocoder = new google.maps.Geocoder();
            }
        },
        mounted: function () {
            this.initMap();
            this.initDrawingManager();
        }
    }
</script>
