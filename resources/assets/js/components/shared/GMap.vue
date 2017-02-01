<template>
    <div class="vue-map-container">
        <div class="vue-map"></div>
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
        props: {},
        data(){
            return {
                mapObject: null,
            }
        },
        methods: {
            initMap: function () {
                const element = this.$el.getElementsByClassName('vue-map')[0];
                this.map = new google.maps.Map(element, {
                    center: {lat: 19.1163145, lng: 99.9073988},
                    scrollwheel: false,
                    zoom: 10
                })
            }
        },
        mounted: function () {
            this.initMap();
            console.log('test');
        }
    }
</script>
