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
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/project',
        name: 'project',
        component: Project,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/task',
        name: 'task',
        component: Task,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/materials',
        name: 'materials',
        component: Material,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/rab',
        name: 'transaction',
        component: Transaction,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/analisa',
        name: 'analisa',
        component: AHS,
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
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/analisa_lokal',
        name: 'adjust',
        component: AHSLokal,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/calculate',
        name: 'calculate',
        component: Calculate
      },
      {
        path: '/reference',
        name: 'reference',
        component: Reference,
        beforeEnter: middleware([
          auth
        ])
      },
    ]
  },
];

