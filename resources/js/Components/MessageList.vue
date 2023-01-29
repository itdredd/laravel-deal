<script setup>
import {defineProps, onBeforeMount, onMounted, ref} from "vue";
import MessageInput from "@/Components/MessageInput.vue";

const props = defineProps({
    deal: Object,
});

let messages = ref([]);
function convertTime(time) {
    let options = {year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute:'2-digit'};
    return new Date(time).toLocaleString([], options);
}

setInterval(() => {
    axios.get('/message/deal/' + props.deal.id + '?type=json')
        .then(function (response) {
            messages.value = response.data;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
}, 10000)


</script>

<template>
    <div class="message-list">
        <div class="message bg-white rounded-md p-4" v-for="message in messages" :id="message.id" v-if="messages">
            <span class="block message-information text-sm text-gray-700">{{ message.user.name }} | {{ convertTime(message.created_at) }}</span>
            <hr class="mb-2">
            <span class="message-text">{{message.message}}</span>
        </div>
        <div class="message bg-white rounded-md p-4" v-else>
            <span class="block message-information text-sm text-gray-700">Empty.</span>
            <hr class="mb-2">
            <span class="message-text">No message yet.</span>
        </div>
    </div>
</template>

<style lang="scss">
    .message + .message {
        margin-top: 1em;
    }
</style>
