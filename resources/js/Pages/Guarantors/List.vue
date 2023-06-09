<script setup>
import {defineProps} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import GuarantorList from "@/Components/GuarantorList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps(
    {
        guarantors: Object,
    });

</script>

<template>
    <Head :title="$t('guarantor.guarantors')"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('guarantor.guarantors') }}</h2>
            </div>
        </template>

        <GuarantorList :guarantors="guarantors"></GuarantorList>

    </AuthenticatedLayout>

</template>

<style scoped lang="scss">

</style>
