<script setup>

import {defineProps, ref} from "vue";
import {TailwindPagination} from 'laravel-vue-pagination';
import MessageInput from "@/Components/MessageInput.vue";

const props = defineProps(
    {
        deal: Object,
        messages: Object,
    });

const messages = ref(props.messages);

Echo.private('deal-message.' + props.deal.id)
    .listen('MessageSent', (e) => {
        messages.value.data.push(e.message);
    });

function convertTime(time) {
    let options = {year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit'};
    return new Date(time).toLocaleString([], options);
}

const getResults = async (page = 1) => {
    axios.get(`http://localhost/deal/${props.deal.id}?page=${page}`)
        .then(function (response) {
            messages.value = response.data.messages
        });
}
</script>

<template>
    <div class="message-list">
        <div class="pagination text-center mb-2">
            <TailwindPagination class="center"
                                :data="messages"
                                @pagination-change-page="getResults"
            />
        </div>
        <div class="message bg-white rounded-md p-4" v-for="message in messages.data" :id="message.id"
             v-if="messages.data.length">
            <div class="message-top-information flex justify-between">
                <div class="text-sm text-gray-700">
                    <span class="text-sm text-gray-700">{{ message.user.name }} | {{
                        convertTime(message.created_at)
                        }}</span>
                </div>
                <div class="text-sm text-gray-700">
                    <span class="text-sm text-gray-700">#{{ message.id }}</span>
                </div>
            </div>
            <div class="message-action-button">
                <span v-if="$page.props.auth.user.is_admin" class="message-action"><a
                        :href="route('message.remove', {message: message.id})"><i
                        class="fa-solid fa-trash"></i></a></span>
                <span v-if="$page.props.auth.user.is_admin" class="message-action"><a
                        :href="route('message.edit', {message: message.id})"><i
                        class="fa-solid fa-pen-to-square"></i></a></span>
            </div>
            <hr class="mb-2">
            <span class="message-text">{{ message.message }}</span>
        </div>
        <div class="message bg-white rounded-md p-4" v-else>
            <span class="block message-information text-sm text-gray-700">Empty.</span>
            <hr class="mb-2">
            <span class="message-text">No message yet.</span>
        </div>
        <div class="pagination text-center mt-2">
            <TailwindPagination class="center"
                                :data="messages"
                                @pagination-change-page="getResults"
            />
        </div>
    </div>
    <MessageInput :deal="deal"/>
</template>

<style lang="scss">
.message + .message {
    margin-top: 1em;
}

i {
    color: gray;

    &:hover {
        color: #a7a7a7;
    }
}

.message-action + .message-action {
    margin-left: 0.3em;
}
</style>
