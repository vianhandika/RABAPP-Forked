import middleware, { auth } from './middleware'
import App from './components/App'
import Login from './components/LoginComponent'
import Dashboard from './components/DashboardComponent'
import Project from './components/ProjectComponent'
import Job from './components/JobComponent'
import Material from './components/MaterialsComponent'
import Transaction from './components/RABComponent'
import AHS from './components/AHSComponent'
import Home from './components/HomeComponent'
import Store from './components/StoreComponent'

import VueRouter from 'vue-router';

export const routes = [
  {
    path: '/',
    name: 'login',
    component: Login,
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    children:[
      {
        path: '/project',
        name: 'project',
        component: Project,
        beforeEnter: middleware([
          auth
        ])
      },
      {
        path: '/job',
        name: 'job',
        component: Job,
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
        path: '/transaction',
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
      }
    ]
  },
];

