import {default as PageLogin} from "@/views/pages/auth/login/Main";
import {default as PageRegister} from "@/views/pages/auth/register/Main";
import {default as PageResetPassword} from "@/views/pages/auth/reset-password/Main";
import {default as PageForgotPassword} from "@/views/pages/auth/forgot-password/Main";
import {default as PageNotFound} from "@/views/pages/shared/404/Main";

import {default as PageDashboard} from "@/views/pages/private/dashboard/Main";
import {default as PageProfile} from "@/views/pages/private/profile/Main";

import {default as PageUsers} from "@/views/pages/private/users/Index";
import {default as PageUsersCreate} from "@/views/pages/private/users/Create";
import {default as PageUsersEdit} from "@/views/pages/private/users/Edit";

import {default as PageCategories} from "@/views/pages/private/categories/Index";
import {default as PageCategoriesCreate} from "@/views/pages/private/categories/Create";
import {default as PageCategoriesEdit} from "@/views/pages/private/categories/Edit";

import {default as PageItems} from "@/views/pages/private/items/Index";
import {default as PageItemsCreate} from "@/views/pages/private/items/Create";
import {default as PageItemsEdit} from "@/views/pages/private/items/Edit";

import abilities from "@/stub/abilities";

const routes = [
    {
        name: "home",
        path: "/",
        meta: {requiresAuth: false, isPublicAuthPage: true},
        component: PageLogin,
    },
    {
        name: "panel",
        path: "/panel",
        children: [
            {
                name: "dashboard",
                path: "dashboard",
                meta: {requiresAuth: true},
                component: PageDashboard,
            },
            {
                name: "profile",
                path: "profile",
                meta: {requiresAuth: true, isOwner: true},
                component: PageProfile,
            },
            {
                path: "users",
                children: [
                    {
                        name: "users.list",
                        path: "list",
                        meta: {requiresAuth: true, requiresAbility: abilities.LIST_USER},
                        component: PageUsers,
                    },
                    {
                        name: "users.create",
                        path: "create",
                        meta: {requiresAuth: true, requiresAbility: abilities.CREATE_USER},
                        component: PageUsersCreate,
                    },
                    {
                        name: "users.edit",
                        path: ":id/edit",
                        meta: {requiresAuth: true, requiresAbility: abilities.EDIT_USER},
                        component: PageUsersEdit,
                    },
                ]
            },
            {
                path: "categories",
                children: [
                    {
                        name: "categories.list",
                        path: "list",
                        meta: {requiresAuth: true, requiresAbility: abilities.LIST_CATEGORY},
                        component: PageCategories,
                    },
                    {
                        name: "categories.create",
                        path: "create",
                        meta: {requiresAuth: true, requiresAbility: abilities.CREATE_CATEGORY},
                        component: PageCategoriesCreate,
                    },
                    {
                        name: "categories.edit",
                        path: ":id/edit",
                        meta: {requiresAuth: true, requiresAbility: abilities.EDIT_CATEGORY},
                        component: PageCategoriesEdit,
                    },
                ]
            },
            {
                path: "items",
                children: [
                    {
                        name: "items.list",
                        path: "list",
                        meta: {requiresAuth: true, requiresAbility: abilities.LIST_ITEM},
                        component: PageItems,
                    },
                    {
                        name: "items.create",
                        path: "create",
                        meta: {requiresAuth: true, requiresAbility: abilities.CREATE_ITEM},
                        component: PageItemsCreate,
                    },
                    {
                        name: "items.edit",
                        path: ":id/edit",
                        meta: {requiresAuth: true, requiresAbility: abilities.EDIT_ITEM},
                        component: PageItemsEdit,
                    },
                ]
            },
        ]
    },
    {
        path: "/login",
        name: "login",
        meta: {requiresAuth: false, isPublicAuthPage: true},
        component: PageLogin,
    },
    {
        path: "/register",
        name: "register",
        meta: {requiresAuth: false, isPublicAuthPage: true},
        component: PageRegister,
    },
    {
        path: "/reset-password",
        name: "resetPassword",
        meta: {requiresAuth: false, isPublicAuthPage: true},
        component: PageResetPassword,
    },
    {
        path: "/forgot-password",
        name: "forgotPassword",
        meta: {requiresAuth: false, isPublicAuthPage: true},
        component: PageForgotPassword,
    },
    {
        path: "/:catchAll(.*)",
        name: "notFound",
        meta: {requiresAuth: false},
        component: PageNotFound,
    },
]

export default routes;
