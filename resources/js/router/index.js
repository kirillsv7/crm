import {createRouter, createWebHistory} from "vue-router";

import DashboardPage from "../components/DashboardPage"

import LoginForm from "../components/Auth/LoginForm";

import UserIndex from '../components/User/UserIndex'
import UserCreate from '../components/User/UserCreate'
import UserEdit from '../components/User/UserEdit'
import UserDeleted from '../components/User/UserDeleted'

import ClientIndex from '../components/Client/ClientIndex'
import ClientCreate from '../components/Client/ClientCreate'
import ClientEdit from '../components/Client/ClientEdit'
import ClientDeleted from '../components/Client/ClientDeleted'

import ProjectIndex from '../components/Project/ProjectIndex'
import ProjectCreate from '../components/Project/ProjectCreate'
import ProjectEdit from '../components/Project/ProjectEdit'
import ProjectDeleted from '../components/Project/ProjectDeleted'

const routes = [
    {
        path: '/login',
        name: 'auth.login',
        component: LoginForm
    },
    {
        path: '/',
        name: 'dashboard',
        component: DashboardPage
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
        path: '/project/:id/edit',
        name: 'project.edit',
        component: ProjectEdit,
        props: true
    },
    {
        path: '/project/deleted',
        name: 'project.deleted',
        component: ProjectDeleted
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})