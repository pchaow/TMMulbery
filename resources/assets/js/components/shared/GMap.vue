<template>
    <div class="vue-map-container">
        <div class="vue-map" ref="vueMap"></div>
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
            lat : Number,
            lng : Number,

        },
        data(){
            return {
                mapObject: null,
            }
        },
        methods: {
            initMap: function () {
                const element = this.$refs.vueMap;
                this.map = new google.maps.Map(element, {
                    center: {
                        lat: this.lat,
                        lng: this.lng},
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
            }
        },
        mounted: function () {
            this.initMap();
        }
    }
</script>
