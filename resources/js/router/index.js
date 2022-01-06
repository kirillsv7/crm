import {createRouter, createWebHistory} from "vue-router";

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
import ProjectEdit from '../views/Project/Edit'
import ProjectDeleted from '../views/Project/Deleted'

const routes = [
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