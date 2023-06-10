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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('guarantor.set_guarantor') }}</h2>
            </div>
        </template>

        <form method="post">
            <InputLabel for="name" :value="$t('guarantor.name')"/>
            <TextInput
                id="name"
                type="text"
                name="name"
                class="mt-1 block w-full"
                required
                autofocus/>
            <div class="mt-4">
                <PrimaryButton>
                    {{ $t('form.create') }}
                </PrimaryButton>
            </div>
            <input type="hidden" name="_token" :value="csrf">
        </form>

    </AuthenticatedLayout>
</template>

<style scoped lang="scss">

</style>
