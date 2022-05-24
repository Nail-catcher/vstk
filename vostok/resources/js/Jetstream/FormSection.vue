<template>
    <div>
        <form @submit.prevent="$emit('submitted')">
            <div class="profile-form">
                <jet-section-title>
                    <template #title>
                        <slot name="title"></slot>
                    </template>
                    <template #description>
                        <slot name="description"></slot>
                    </template>
                </jet-section-title>


                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <slot name="form"></slot>
                        </div>
                    </div>

                </div>

            </div>
            <div v-if="hasActions">
                <slot name="actions"></slot>
            </div>
        </form>
    </div>
</template>

<script>
import JetSectionTitle from './SectionTitle'

export default {
    components: {
        JetSectionTitle,
    },

    computed: {
        hasActions() {
            return !!this.$slots.actions
        }
    }
}
</script>
