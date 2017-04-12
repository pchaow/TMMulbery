/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component('user-index', require('./components/admin/user/UserIndex.vue'));
Vue.component('user-create', require('./components/admin/user/UserCreate.vue'));
Vue.component('user-edit', require('./components/admin/user/UserEdit.vue'));

Vue.component('role-index', require('./components/admin/role/RoleIndex.vue'));
Vue.component('role-create', require('./components/admin/role/RoleCreate.vue'));
Vue.component('role-edit', require('./components/admin/role/RoleEdit.vue'));

Vue.component('plant-index', require('./components/admin/plant/PlantIndex.vue'));


Vue.component('farmer-index', require('./components/admin/farmer/FarmerIndex.vue'));
Vue.component('farmer-create', require('./components/admin/farmer/FarmerCreate.vue'));
Vue.component('farmer-edit', require('./components/admin/farmer/FarmerEdit.vue'));
Vue.component('farmer-view', require('./components/admin/farmer/FarmerView.vue'));
Vue.component('farmer-plant-create', require('./components/admin/farmer/plant/PlantCreate.vue'));
Vue.component('farmer-plant-edit', require('./components/admin/farmer/plant/PlantEdit.vue'));


Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyAQhqp6RRe4zDyB2I1IeAiVsyQsVRJbHCA',
        v: '3.27',
        // libraries: 'places', //// If you need to use place input
    }
});
const app = new Vue({
    el: '#app',
});
