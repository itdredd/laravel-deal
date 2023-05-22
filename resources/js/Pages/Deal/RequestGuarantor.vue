<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, onMounted, defineProps} from "vue";

let guarantors = ref([]); // todo edit to props?

const props = defineProps({
    deal: Object,
});

onMounted(() => {
    axios.get('/guarantors/find')
        .then(function (response) {
            guarantors.value = response.data;
        })
})

</script>

<template>
    <Head :title="$t('deal.deal_x', {'title': props.deal.title})"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{$t('deal.request_guarantor')}}</h2>
        </template>

        <form method="POST">
            <div class="mt-4">
                <InputLabel for="guarantor" :value="$t('deal.guarantor')"/>
                <select id="guarantor" name="guarantor" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option>{{ $t('deal.select_guarantor') }}</option>
                    <option v-for="guarantor in guarantors" :value="guarantor['id']">{{ guarantor['name'] }}</option>
                </select>
            </div>
            <div class="mt-4">
                <PrimaryButton>
                    {{ $t('form.request') }}
                </PrimaryButton>
            </div>
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </AuthenticatedLayout>
</template>

<style lang="scss">
</style>
