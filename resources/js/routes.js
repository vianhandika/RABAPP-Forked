import middleware, { auth } from './middleware'
import App from './components/App'
import Login from './components/LoginComponent'
import Dashboard from './components/DashboardComponent'
import Project from './components/ProjectComponent'
import Task from './components/TaskComponent'
import Material from './components/MaterialsComponent'
import Transaction from './components/RABComponent'
import AHS from './components/AHSComponent'
import Home from './components/HomeComponent'
import Store from './components/StoreComponent'
import SPA from './components/SPAComponent'
import Calculate from './components/CalculateComponent'
import AHSLokal from './components/AHSLokalComponent'
import Reference from './components/ReferenceComponent'

import VueRouter from 'vue-router';

export const routes = [
  {
    path: '/',
    name: 'login',
    component: Login,
  },
  {
    path: '/spa',
    name: 'spa',
    component: SPA,
    children:[
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
          name: 'Dashboard',
          Akses:[
            'Panel',
            'R-Dashboard-R'
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/project',
        name: 'project',
        component: Project,
        meta: {
          name: 'Project',
          Akses:[
            'R-Proyek-C',
            'R-Proyek-R',
            'R-Proyek-U',
            'R-Proyek-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/task',
        name: 'task',
        component: Task,
        meta: {
          name: 'Task',
          Akses:[
            'R-Pekerjaan-C',
            'R-Pekerjaan-R',
            'R-Pekerjaan-U',
            'R-Pekerjaan-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/materials',
        name: 'materials',
        component: Material,
        meta: {
          name: 'Material',
          Akses:[
            'R-BahanTenagaKerja-C',
            'R-BahanTenagaKerja-R',
            'R-BahanTenagaKerja-U',
            'R-BahanTenagaKerja-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/rab',
        name: 'transaction',
        component: Transaction,
        meta: {
          name: 'RAB',
          Akses:[
            'R-RAB-C',
            'R-RAB-R',
            'R-RAB-U',
            'R-RAB-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/analisa',
        name: 'analisa',
        component: AHS,
        meta: {
          name: 'AHS Master',
          Akses:[
            'R-AHSMaster-C',
            'R-AHSMaster-R',
            'R-AHSMaster-U',
            'R-AHSMaster-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/home',
        name: 'home',
        component: Home,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/store',
        name: 'store',
        component: Store,
        meta: {
          name: 'Store',
          Akses:[
            'R-Toko-C',
            'R-Toko-R',
            'R-Toko-U',
            'R-Toko-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/analisa_lokal',
        name: 'adjust',
        component: AHSLokal,
        meta: {
          name: 'AHS Lokal',
          Akses:[
            'R-AHSLokal-C',
            'R-AHSLokal-R',
            'R-AHSLokal-U',
            'R-AHSLokal-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/calculate',
        name: 'calculate',
        meta: {
          name: 'Calculate',
          Akses:[
            'R-Kalkulator-R',
          ]
        },
        component: Calculate
      },
      {
        path: '/reference',
        name: 'reference',
        component: Reference,
        meta: {
          name: 'AHS Lokal',
          Akses:[
            'R-DetailReferensi-C',
            'R-DetailReferensi-R',
            'R-DetailReferensi-U',
            'R-DetailReferensi-D',
          ]
        },
        beforeEnter: middleware([
          auth
        ])
      },
    ]
  },
];

