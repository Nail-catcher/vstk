<template>
    <li class="application-icon arrow-link">
        <span>
            <slot name="header"></slot>
        </span>
        <ul class="sub-menu">
            <slot></slot>
        </ul>
    </li>
</template>

<script>
export default {
    name: "ArrowLink",
    props: {
        active: false
    },
    data: () => ({
        show: false
    }),
    computed: {
        visible() {
            return this.show || this.active;
        }
    },
}
</script>
