//import middleware, { auth } from './middleware'
import App from './components/App'
import Login from './components/LoginComponent'
import Dashboard from './components/DashboardComponent'
import Project from './components/ProjectComponent'
import Job from './components/JobComponent'
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
      },
      {
        path: '/job',
        name: 'job',
        component: Job,
      }
    ]
  },
];

