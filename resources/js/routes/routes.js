import {useAuthStore} from "@/store/auth";

const AuthenticatedLayout = () => import('../layouts/Authenticated.vue')
const GuestLayout = ()  => import('../layouts/Guest.vue');

function requireLogin(to, from, next) {
  const auth = useAuthStore()
  let isLogin = false;
  isLogin = !!auth.authenticated;

  if (isLogin) {
    next()
  } else {
    next('/login')
  }
}

function guest(to, from, next) {
  const auth = useAuthStore()
  let isLogin;
  isLogin = !!auth.authenticated;

  if (isLogin) {
    next('/')
  } else {
    next()
  }
}

export default [
  {
    path: '/',
    component: GuestLayout,
    children: [
      {
        path: '/',
        name: 'home',
        redirect: {
          name: 'auth.login'
        },
        component: () => import('../views/home/index.vue'),
      },
      {
        path: 'login',
        name: 'auth.login',
        component: () => import('../views/login/Login.vue'),
        beforeEnter: guest,
      },
    ]
  },
  {
    path: '/admin',
    component: AuthenticatedLayout,
    beforeEnter: requireLogin,
    children: [
      {
        name: 'admin.index',
        path: '',
        component: () => import('../views/admin/index.vue'),
        meta: { breadCrumb: 'Admin' }
      },
      {
        name: 'profile.index',
        path: 'profile',
        component: () => import('../views/admin/profile/index.vue'),
        meta: { breadCrumb: 'Profile' }
      },
      {
        name: 'users.index',
        path: 'users',
        component: () => import('../views/admin/users/Index.vue'),
        meta: { breadCrumb: 'Users' }
      },
      {
        name: 'users.create',
        path: 'users/create',
        component: () => import('../views/admin/users/Create.vue'),
        meta: { breadCrumb: 'Add New' }
      },
      {
        name: 'users.edit',
        path: 'users/edit/:id',
        component: () => import('../views/admin/users/Edit.vue'),
        meta: { breadCrumb: 'User Edit' }
      },
      {
        name: 'brands.list',
        path: 'brands',
        component: () => import('../views/admin/list/Brands.vue'),
        meta: { breadCrumb: 'Brands' }
      },
      {
        name: 'cdt-codes.list',
        path: 'cdt-codes',
        component: () => import('../views/admin/list/CdtCodes.vue'),
        meta: { breadCrumb: 'CDT Codes' }
      },
      {
        name: 'items.list',
        path: 'items',
        component: () => import('../views/admin/list/Items.vue'),
        meta: { breadCrumb: 'Items' }
      },
      {
        name: 'procedure-template.list',
        path: 'procedure-templates',
        component: () => import('../views/admin/list/ProcedureTemplates.vue'),
        meta: { breadCrumb: 'Procedure Templates' }
      },
      {
        name: 'procedures.list',
        path: 'procedures',
        component: () => import('../views/admin/list/Procedures.vue'),
        meta: { breadCrumb: 'Procedures' }
      },
      {
        name: 'inventory.list',
        path: 'inventory',
        component: () => import('../views/admin/list/Inventory.vue'),
        meta: { breadCrumb: 'Inventory' }
      },
    ]
  },
  {
    path: "/:pathMatch(.*)*",
    name: 'NotFound',
    component: () => import("../views/errors/404.vue"),
  },
];
