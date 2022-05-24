<template>
  <modal
    name="modalBaseStations"
    class="modal_regular modal_bts"
    width="300"
    height="250"
  >
    <div class="modal_regular__header column2" v-if="data.id">
      <p>
        {{
          typeList === 'bts'
            ? `Список БС заявки ${data.id}`
            : `Вид работ заявки ${data.id}`
        }}
      </p>
      <div class="modal_regular__close">
        <span class="material-icons pointer" @click="switchModalStatus(false)"
          >close</span
        >
      </div>
    </div>
    <div
      class="modal_regular__body custom-scroll inner-scroll"
      v-if="typeList === 'bts' && data.list.length"
    >
      <div
        class="modal_bts__item"
        v-for="(station, index) in data.list"
        :key="index"
      >
        <p>{{ station.bts_id }}</p>
        <p></p>
      </div>
    </div>
    <div
      class="modal_regular__body custom-scroll inner-scroll"
      v-else-if="typeList === 'works' && data.list.length"
    >
      <div
        class="modal_bts__item"
        v-for="(work, index) in data.list"
        :key="index"
      >
        <p>{{ work.title }}</p>
        <p></p>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  data: () => ({
    data: {
      id: null,
      list: []
    },
    typeList: null
  }),
  methods: {
    switchModalStatus(status = false, application, type = 'bts') {
      this.typeList = type
      if (status) {
        this.$modal.show('modalBaseStations')
        if (this.typeList === 'bts') {
          this.data = {
            id: application.id,
            list: application.stations
          }
        } else if (this.typeList === 'works') {
          this.data = {
            id: application.id,
            list: application.works
          }
        }
        return
      }
      this.$modal.hide('modalBaseStations')
    }
  }
}
</script>

<style lang="scss" scoped></style>
