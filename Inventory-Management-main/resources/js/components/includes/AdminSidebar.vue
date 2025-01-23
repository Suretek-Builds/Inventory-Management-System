

<template>
  <nav class="bg-white sidebar">
    <div class="pt-3 sidebar-sticky">

      <div class="sidebar-profile">
        <img src="/images/patient5.png" class="img-shadow img-3x me-3 rounded-5" >
        <div class="m-0">
          <h5 class="mb-1 profile-name text-nowrap text-truncate">{{ user.name }}</h5>
        </div>
      </div>
      <ul id="menu" class="nav flex-column mb-2">
        <li class="nav-item">
          <router-link to="/admin" class="nav-link">
            <div class="bg-site">
              <img src="/images/dashboard.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Dashboard</span>  <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'brands.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/diamond.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Brands Management</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'cdt-codes.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/number-blocks.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">CDT Codes</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'items.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/product-management.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Item Management</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'procedure-template.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/layout.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Procedure Template</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>

        <li class="nav-item">
          <router-link :to="{ name: 'procedures.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/process-diagram.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Procedure</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'inventory.list' }" class="nav-link">
            <div class="bg-site">
              <img src="/images/product-management.png" class="site-icons">
            </div>
            <span class="d-none d-sm-inline ps-2">Inventory</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
// import {useAbility} from '@casl/vue'
// const {can} = useAbility();
import { useAuthStore } from "@/store/auth";

export default {
  computed: {
    user() {
      return useAuthStore().user;
    },
  },
}
</script>

<style scoped>

</style>
