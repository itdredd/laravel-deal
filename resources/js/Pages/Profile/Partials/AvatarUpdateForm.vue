<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    avatar: null,
});

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Avatar</h2>
        </header>

        <form @submit.prevent="form.patch(route('profile.avatar'))" class="mt-6 space-y-6">
            <div>
                <form :action="route('profile.avatar')" method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" class="block mb-4">
                    <input type="hidden" name="_token" :value="csrf">
                    <PrimaryButton>Update</PrimaryButton>
                </form>
            </div>
        </form>
    </section>
</template>
