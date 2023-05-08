<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MessageList from '@/Components/MessageList.vue';
import LinkButton from "@/Components/LinkButton.vue";

defineProps({
    deal: Object,
    visitor: Object,
    members: Object,
    messages: Object,
});

function convertTime(time) {
    return new Date(time).toLocaleString();
}

function listUsernames(members) {
    let list = '';

    for (const member of members) {
        list += member.name;

        if (member !== members[members.length - 1])
            list += ', ';
    }
    return list;
}

function price(value, currency) {
    return value + ' ' + currency;
}

</script>


<template>
    <Head :title="'Deal: ' + deal.title"/>

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto inline mr-2">Deal:
                    {{ deal.title }}</h2>
                <div class="action-icons inline">
                    <a :href="route('deal.edit', {'deal': deal.id})"
                       v-if="visitor.id == deal.author_id || visitor.is_admin"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a :href="route('deal.approve', {'deal': deal.id})"
                       v-if="deal.status === 'awaiting' && members.some(data => data.id === visitor.id)"><i
                        class="fa-solid fa-square-check"></i></a>
                    <a :href="route('deal.reject', {'deal': deal.id})"
                       v-if="deal.status === 'awaiting' && members.some(data => data.id === visitor.id)"><i
                        class="fa-solid fa-square-xmark"></i></a>
                </div>
            </div>
        </template>


        <div class="deal-information mb-4">
            <span class="deal-information--status block">Status: {{ deal.status }}</span>
            <span class="deal-information--desciption block">Description: {{ deal.description }}</span>
            <span class="deal-information--price block">Price: {{ price(deal.value, deal.currency) }}</span>
            <span class="deal-information--price block">Balance: {{ price(deal.balance, deal.currency) }}</span>
            <span class="deal-information--author block">Author: {{ deal.author.name }}</span>
            <span class="deal-information--members block">Members: {{ listUsernames(members) }}</span>
            <span class="deal-information--guarantor block" v-if="deal.guarantor">Guarantor: {{ deal.guarantor.name }}</span>
            <span class="deal-information--create-date block">Created at: {{ convertTime(deal.created_at) }}</span>
        </div>
        <div class="deal-actions mb-8">
          <LinkButton v-if="deal.status === 'open' && visitor.id === deal.author.id" :href="route('deal.close', {'deal': deal})">
            Close
          </LinkButton>
        </div>

        <div class="messages">
            <MessageList :deal="deal" :messages="messages"/>
        </div>

    </AuthenticatedLayout>
</template>

<style lang="scss">
.action-icons {
    a + a {
        margin-left: 0.5em;
    }
}
</style>
