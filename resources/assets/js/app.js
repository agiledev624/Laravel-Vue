
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import CompaniesIndex from './components/companies/CompaniesIndex.vue';
import CompaniesCreate from './components/companies/CompaniesCreate.vue';
import CompaniesEdit from './components/companies/CompaniesEdit.vue';
import FirstScreen from './components/FirstScreen.vue';
import ApartmentPage from './components/companies/ApartmentPage.vue';
import LockerSetting from './components/companies/LockerSetting.vue';
import ApartmentSetting from './components/companies/ApartmentSetting.vue';
const routes = [
    {
        path: '/',
        components: {
            firstScreen: FirstScreen
        }
    },
    {path: '/admin/companies/create', component: CompaniesCreate, name: 'createCompany'},
    {path: '/admin/companies/edit/:id', component: CompaniesEdit, name: 'editCompany'},
    {path: '/admin/companies/apartment', component: ApartmentPage, name: 'apartment'},
    {path: '/admin/companies/apartsetting', component: ApartmentSetting, name: 'apartSetting'},
    {path: '/admin/companies/lockersetting', component: LockerSetting, name: 'lockerSetting'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
