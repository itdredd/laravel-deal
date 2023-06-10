<script setup>

import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {Head} from "@inertiajs/inertia-vue3";
import GuarantorList from "@/Components/GuarantorList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>
    <Head :title="$t('deal.deals')"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('admin.panel') }}</h2>
            </div>
        </template>
        <div class="container p-4 bg-gray-300 rounded mb-2">
            <span><a :href="route('admin.get-users')">{{ $t('admin.get_users') }}</a></span>
        </div>
        <div class="container p-4 bg-gray-300 rounded mb-2">
            <span><a :href="route('admin.set-guarantor')">{{ $t('admin.set_guarantor') }}</a></span>
        </div>


    </AuthenticatedLayout>

</template>

<style scoped lang="scss">

</style>
