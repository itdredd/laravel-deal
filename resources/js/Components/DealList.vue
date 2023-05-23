<template>
    <div class="deal-list">
        <div class="deal bg-white my-2 p-4 flex rounded-lg" v-for="deal in deals" v-if="deals">
            <div class="information information-main my-auto">
                <a :href="route('deal.view', {'id': deal.id})" class="title">{{ deal.title }}</a>
            </div>

            <div class="information information-members mr-16">
                <span class="block">{{ $t('deal.members') + ':' }}</span>
                <span class="block">{{ formatMembers(deal) }}</span>
            </div>
            <div class="information information-date">
                <span class="block">{{ convertTime(deal.created_at) }}</span>
                <span class="block">{{ $t('deal.status.' + deal.status) }}</span>
            </div>
        </div>

        <div class="deal bg-white my-2 p-4 flex justify-between" v-if="deals.length === 0">
            {{ $t('deal.nothing_to_render') }}
        </div>
    </div>
</template>

<script setup>
import {defineProps} from "vue";

const props = defineProps({
    deals: Object,
})

function convertTime(time) {
    return new Date(time).toLocaleString();
}

function formatMembers(deal) {
    let list = '';

    for (const member of deal.members) {
        if (member.user.id === deal.guarantor.id) {
            continue;
        }

        if (list.length) {
            list += ', ';
        }
        list += member.user.name;
    }
    return list;
}
</script>

<style lang="scss">

.information-main{
  width: 70%;
}
.information-members{
  width: 15%;
}
.information-date{
  width: 15%;
}
</style>
