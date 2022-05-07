import axios from "axios";
import {createRouter, createWebHistory} from "vue-router";

import AuthLogin from "../views/Auth/Login";

import Dashboard from "../views/Dashboard"

import UserIndex from '../views/User/Index'
import UserCreate from '../views/User/Create'
import UserEdit from '../views/User/Edit'
import UserDeleted from '../views/User/Deleted'

import ClientIndex from '../views/Client/Index'
import ClientCreate from '../views/Client/Create'
import ClientEdit from '../views/Client/Edit'
import ClientDeleted from '../views/Client/Deleted'

import ProjectIndex from '../views/Project/Index'
import ProjectCreate from '../views/Project/Create'
import ProjectShow from '../views/Project/Show'
import ProjectEdit from '../views/Project/Edit'
import ProjectDeleted from '../views/Project/Deleted'

import TaskIndex from '../views/Task/Index'
import TaskCreate from '../views/Task/Create'
import TaskShow from '../views/Task/Show'
import TaskEdit from '../views/Task/Edit'
import TaskDeleted from '../views/Task/Deleted'

const routes = [
    {
        path: '/login',
        name: 'auth.login',
        component: AuthLogin
    },

    {
        path: '/',
        name: 'dashboard',
        component: Dashboard
    },

    {
        path: '/user',
        name: 'user.index',
        component: UserIndex
    },
    {
        path: '/user/create',
        name: 'user.create',
        component: UserCreate
    },
    {
        path: '/user/:id/edit',
        name: 'user.edit',
        component: UserEdit,
        props: true
    },
    {
        path: '/user/deleted',
        name: 'user.deleted',
        component: UserDeleted
    },

    {
        path: '/client',
        name: 'client.index',
        component: ClientIndex
    },
    {
        path: '/client/create',
        name: 'client.create',
        component: ClientCreate
    },
    {
        path: '/client/:id/edit',
        name: 'client.edit',
        component: ClientEdit,
        props: true
    },
    {
        path: '/client/deleted',
        name: 'client.deleted',
        component: ClientDeleted
    },

    {
        path: '/project',
        name: 'project.index',
        component: ProjectIndex
    },
    {
        path: '/project/create',
        name: 'project.create',
        component: ProjectCreate
    },
    {
        path: '/project/:id',
        name: 'project.show',
        component: ProjectShow,
        props: true
    },
    {
        path: '/project/:id/edit',
        name: 'project.edit',
        component: ProjectEdit,
        props: true
    },
    {
        path: '/project/deleted',
        name: 'project.deleted',
        component: ProjectDeleted
    },

    {
        path: '/task',
        name: 'task.index',
        component: TaskIndex,
        props: true
    },
    {
        path: '/task/create',
        name: 'task.create',
        component: TaskCreate
    },
    {
        path: '/task/:id',
        name: 'task.show',
        component: TaskShow,
        props: true
    },
    {
        path: '/task/:id/edit',
        name: 'task.edit',
        component: TaskEdit,
        props: true
    },
    {
        path: '/task/deleted',
        name: 'task.deleted',
        component: TaskDeleted
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            }
        }
    },
})

router.beforeEach((to, from) => {
    axios.interceptors.response.use(
        response => response,
        e => {
            if (e.response.status === 401 || e.response.status === 419) {
                location.assign('/login')
            }
            return Promise.reject(e)
        }
    )
})

export default router