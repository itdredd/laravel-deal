<template>
    <div class="deal-list">
        <div class="deal bg-white my-2 p-4 flex justify-between" v-for="deal in deals" v-if="deals">
            <div class="information-main my-auto">
                <a :href="route('deal.view', {'id': deal.id})" class="title">{{ deal.title }}</a>
            </div>
            <div class="information-users flex">
                <div class="information-main mr-16">
                    <span class="block">Author: {{ deal.author.name }}</span>
                    <span class="block">Members: {{ deal.members_id }}</span>
                </div>
                <div class="information-date">
                    <span class="block">{{ convertTime(deal.created_at) }}</span>
                    <span class="block">{{ deal.status }}</span>
                </div>
            </div>
        </div>

        <div class="deal bg-white my-2 p-4 flex justify-between" v-if="deals.length === 0">
            Nothing to render
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

</script>

<style scoped>

</style>
