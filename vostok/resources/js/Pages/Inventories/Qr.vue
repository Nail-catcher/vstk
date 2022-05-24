<template>
    <app-layout>
        <div class="main-wrap swap">
            <div class="base-header">
                <h1>Список QR кодов</h1>
            </div>
            <table class="main-table base-table">
                <thead class="main-thead">
                <tr>
                    <td>№</td>
                    <td>Артикул</td>
                    <td>Наименование</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in 5" :key="item">
                    <td>1</td>
                    <td>2.3.213</td>
                    <td>10 артикулов</td>
                    <td class="base-history">
                        <a href="#">Скачать QR код</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout
    }
}
</script>
