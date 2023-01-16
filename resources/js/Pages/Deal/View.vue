<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    deal: Object,
    user: Object,
    members: Object,
})

function convertTime(time) {
    return new Date(time).toLocaleString();
}

function listUsernames(members) {
    let list = '';
    for(const member of members) {
        list += member.name;
        if(member !== members[length+1])
            list += ', ';
    }
    return list;
}

</script>

<template>
    <Head :title="'Deal: ' + deal.title" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto inline mr-2">Deal: {{deal.title}}</h2>
                <a :href="route('deal.edit', {'deal': deal.id})" v-if="user.id == deal.author_id || ('editAnyDeal')"><i class="fa-solid fa-pen-to-square"></i></a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="deal-information">
                    <span class="deal-information--status block">Status: {{ deal.status }}</span>
                    <span class="deal-information--desciption block">Description: {{ deal.description }}</span>
                    <span class="deal-information--price block">Price: {{ deal.price }}</span>
                    <span class="deal-information--author block">Author: {{ deal.author.name }}</span>
                    <span class="deal-information--members block">Members: {{ listUsernames(members) }}</span>
                    <span class="deal-information--create-date block">Created at: {{ convertTime(deal.created_at) }}</span>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
