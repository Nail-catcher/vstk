<template>
  <app-layout>
    <div class="main-wrap swap">
      <div class="base-header">
        <h1>История обменов 1С</h1>
      </div>
      <table class="main-table base-table">
        <thead class="main-thead">
          <tr>
            <td>№</td>
            <td>Дата</td>
            <td>Результат</td>
          </tr>
        </thead>
        <span></span>
        <tbody>
          <tr v-for="item in 5" :key="item">
            <td>1</td>
            <td>2.3.213</td>
            <td>10 артикулов</td>
          </tr>
        </tbody>
      </table>
      <button class="btn btn-orange">Произвести обмен</button>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
  components: {
    AppLayout,
  },
}
</script>

<style scoped>
</style>
