import Vue from 'vue';
import VueRouter from 'vue-router';
import authService from "../services/auth.service";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    meta: { layout: 'main' },
    component: () => import('../views/main/Home.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: { layout: 'main' },
    component: () => import('../views/main/Login.vue')
  },
  {
    path: '/register',
    name: 'register',
    meta: { layout: 'main' },
    component: () => import('../views/main/Register.vue')
  },
  {
    path: '/admin',
    name: 'admin',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/Admin.vue')
  },
  {
    path: '/admin/page',
    name: 'page',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/Page.vue')
  },
  {
    path: '/admin/page-add',
    name: 'page-add',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/PageAdd.vue')
  },
  {
    path: '/admin/page-edit/:id',
    props: true,
    name: 'page-edit',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/PageEdit.vue')
  },
  {
    path: '/admin/page-view/:id',
    props: true,
    name: 'page-view',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/PageView.vue')
  },
  {
    path: '/admin/category',
    name: 'category',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/Category.vue')
  },
  {
    path: '/admin/tags',
    name: 'tags',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/Tags.vue')
  },
  {
    path: '/admin/blog',
    name: 'blog',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/Blog.vue')
  },
  {
    path: '/admin/blog-list',
    name: 'blog-list',
    meta: { layout: 'admin', auth: true },
    component: () => import('../views/admin/BlogList.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {

  const currentUser = authService.isLoggedIn();
  const reqAuth = to.matched.some(record => record.meta.auth);

  if (reqAuth && !currentUser) {
    next('/login')
  } else {
    next()
  }
});

export default router
