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
                <form action="{{route('profile.avatar')}}" method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" class="text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                </form>
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton>Update</PrimaryButton>
            </div>
        </form>
    </section>
</template>
