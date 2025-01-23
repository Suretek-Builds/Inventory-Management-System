<template>
  <div class="">
  <div class="breadcrumb-ds">
  <nav class="">
    <ol class="breadcrumb border-radius-0"> <i class="fas fa-home"></i>
      <li
        v-for="(crumb, ci) in crumbs"
        :key="ci"
        class="breadcrumb-item align-items-center"
      > 
        <router-link :to="crumb.href" class="btn btn-link" :class="{ disabled: isLast(ci) }" @click="selected(crumb)">
          {{ crumb.text }}
        </router-link>
      </li>
    </ol>
  </nav>
</div>
</div>
</template>

<script>
export default {
  props: {
    crumbs: {
      type: Array,
      required: true,
    },
  },
  methods: {
    isLast(index) {
      return index === this.crumbs.length - 1;
    },
    selected(crumb) {
      this.$emit('selected', crumb);
    },
  },
};
</script>

<style scoped>

</style>
