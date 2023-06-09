<script setup>

import {defineProps} from "vue";

const props = defineProps(
    {
        guarantors: Object,
    });

</script>

<template>
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th>{{ $t('guarantor.guarantor') }}</th>
            <th>{{ $t('guarantor.rating') }}</th>
            <th>{{ $t('guarantor.reviews') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="guarantor in guarantors">
            <td>{{ guarantor.user.name }}</td>
            <td>{{ guarantor.rating }}</td>
            <td><span class="text-green-500">{{ guarantor.successful_deals }} / <span class="text-red-500">{{ guarantor.dissatisfied_deals }}</span></span></td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped lang="scss">
th {
    text-align: start;
}
</style>
