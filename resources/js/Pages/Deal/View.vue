<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MessageList from '@/Components/MessageList.vue';
import LinkButton from "@/Components/LinkButton.vue";
import {ref} from "vue";

defineProps({
    deal: Object,
    visitor: Object,
    members: Object,
    messages: Object,
});

let shortDesc = ref(true);

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

</script>


<template>
    <Head :title="$t('deal.deal_x', {'title': deal.title})"/>

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto inline mr-2">
                    {{ $t('deal.deal_x', {'title': deal.title}) }}
                </h2>
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
            <span class="deal-information--status block">{{ $t('deal.status_x', {'status': $t('deal.status.' + deal.status)}) }}</span>
            <span class="deal-information--desciption block">
                {{ $t('deal.description_x', {'description': shortDesc ? deal.description.substring(0, 500) : deal.description}) }}
                <i class="fas fa-ellipsis-h" v-if="deal.description.length > 500" @click="shortDesc = !shortDesc" title="Extend text"></i>
            </span>
            <span class="deal-information--price block">{{ $t('deal.price_x', {'amount': deal.value, 'currency': deal.currency}) }}</span>
            <span class="deal-information--balance block">{{ $t('deal.balance_x', {'amount': deal.balance, 'currency': deal.currency}) }}</span>
            <span class="deal-information--author block">{{ $t('deal.author_x', {'name': deal.author.name}) }}</span>
            <span class="deal-information--members block">{{ $t('deal.members_x', {'members': listUsernames(members)}) }}</span>
            <span class="deal-information--guarantor block" v-if="deal.guarantor"> {{ $t('deal.guarantor_x', {'name': deal.guarantor.name}) }}</span>
            <span class="deal-information--create-date block">{{ $t('deal.created_at_x', {'date': convertTime(deal.created_at)})}}</span>
        </div>
        <div class="deal-actions mb-8">
            <LinkButton v-if="deal.status === 'open' && visitor.id === deal.author.id"
                        :href="route('deal.close', {'deal': deal})">
                {{ $t('deal.close') }}
            </LinkButton>
            <LinkButton :href="route('deal.request-guarantor', {'deal': deal})" v-if="!deal.guarantor">
                {{ $t('deal.request_guarantor') }}
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
i {
    cursor: pointer;
}

.deal-actions {
    a+a {
        margin-left: 1em;
    }
}
</style>
