<template>
  <nav class="d-flex justify-content-center">
    <ul class="pagination">
      <li
        class="page-item"
        :aria-disabled="link.url === null"
        :aria-current="currentPage() === link.label ? 'page' : false"
        v-for="link in pagination.links"
      >
        <span class="page-link" v-if="link.url === null">{{ link.label }}</span>
        <inertia-link  class="page-link" replace preserve-state :class="{active: link.active === true}" :href="link.url" v-else>{{ link.label }}</inertia-link>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ['pagination'],
  methods: {
    currentPage() {
      return this.pagination.current_page
    },
    onFirstPage() {
      return this.currentPage() <= 1
    },
    path() {
      return this.pagination.path
    },
    hasMorePages() {
      return this.currentPage() < this.lastPage()
    },
    lastPage() {
      this.pagination.last_page
    },
  },
}
</script>
