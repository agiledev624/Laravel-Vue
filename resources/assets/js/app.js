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
window.Vue.use(CxltToastr, { position: 'bottom right' })

import CompaniesIndex from './components/companies/CompaniesIndex.vue'
import CourierPage from './components/companies/CourierPage.vue'
import LockersEdit from './components/companies/LockersEdit.vue'
import FirstScreen from './components/FirstScreen.vue'
import OwnerPage from './components/companies/OwnerPage.vue'
import LockerSetting from './components/companies/LockerSetting.vue'
import LockerList from './components/companies/LockerList.vue'
import ApartList from './components/companies/ApartList.vue'
import ApartmentSetting from './components/companies/ApartmentSetting.vue'
import ApartmentEdit from './components/companies/ApartmentEdit.vue'
import ThanksPage from './components/companies/ThanksPage.vue'
import Status from './components/companies/Status.vue'
import BaseLayout from './components/Base.vue'

import Vue from 'vue'
const routes = [
  {
    path: '/',
    component: BaseLayout,
    name: 'root',
  },
  { path: '/courier/:id', component: CourierPage, name: 'courierPage' },
  { path: '/thanks', component: ThanksPage, name: 'thanksPage' },
  {
    path: '/lockerlist',
    component: LockerList,
    name: 'lockerList',
  },
  // {
  //   path: '/lockers/edit/:id',
  //   component: LockersEdit,
  //   name: 'editLocker',
  // },
  // {
  //   path: '/lockersetting',
  //   component: LockerSetting,
  //   name: 'lockerSetting',
  // },
  {
    path: '/owner/:id',
    component: OwnerPage,
    name: 'ownerPage',
  },
  {
    path: '/apartsetting',
    component: ApartmentSetting,
    name: 'apartSetting',
  },
  {
    path: '/apartlist',
    component: ApartList,
    name: 'apartList',
  },
  {
    path: '/aparts/edit/:id',
    component: ApartmentEdit,
    name: 'editApartment',
  },
  {
    path: '/status',
    component: Status,
    name: 'status',
  },
]

const router = new VueRouter({ mode: 'history', routes })
if (document.querySelector("meta[name='user_id']")) {
  Vue.prototype.$userId = document
    .querySelector("meta[name='user_id']")
    .getAttribute('content')
  Vue.prototype.$userPort = document
    .querySelector("meta[name='user_port']")
    .getAttribute('content')
}

// var mixin = {
//   methods: {
//     foo: function() {
//       console.log('foo')
//     },
//     conflicting: function() {
//       console.log('from mixin')
//     },
//   },
// }

Vue.mixin({
  methods: {
    parsePhone: function(phone) {
      const pattern = /(\(|\)| )/g
      let trimmed = phone.replace(pattern, '')
      const regex = new RegExp('^0+(?!$)', 'g')

      // Replaces the matched
      // value with given string
      return '+61' + trimmed.replaceAll(regex, '')
    },
  },
})

const app = new Vue({
  // mixins: [mixin],

  router,
  render: (h) => h(BaseLayout),
}).$mount('#vueApp')
