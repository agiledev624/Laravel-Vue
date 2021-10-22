/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue').default
import VueRouter from 'vue-router'
import CxltToastr from 'cxlt-vue2-toastr'

window.Vue.use(VueRouter)
window.Vue.use(CxltToastr, { position: 'top right' })

import CompaniesIndex from './components/companies/CompaniesIndex.vue'
import CourierPage from './components/companies/CourierPage.vue'
import LockersEdit from './components/companies/LockersEdit.vue'
import FirstScreen from './components/FirstScreen.vue'
import OwnerPage from './components/companies/OwnerPage.vue'
import LockerSetting from './components/companies/LockerSetting.vue'
import LockerList from './components/companies/LockerList.vue'
import ApartList from './components/companies/ApartList.vue'
import ApartmentSetting from './components/companies/ApartmentSetting.vue'

const routes = [
  {
    path: '/',
    components: {
      firstScreen: FirstScreen,
    },
  },
  { path: '/courier', component: CourierPage, name: 'courierPage' },
  {
    path: '/lockers/edit/:id',
    component: LockersEdit,
    name: 'editLocker',
  },
  {
    path: '/owner',
    component: OwnerPage,
    name: 'ownerPage',
  },
  {
    path: '/apartsetting',
    component: ApartmentSetting,
    name: 'apartSetting',
  },
  {
    path: '/lockersetting',
    component: LockerSetting,
    name: 'lockerSetting',
  },
  {
    path: '/lockerlist',
    component: LockerList,
    name: 'lockerList',
  },
  {
    path: '/apartlist',
    component: ApartList,
    name: 'apartList',
  },
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
