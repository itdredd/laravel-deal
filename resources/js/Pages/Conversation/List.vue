<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {defineProps, onMounted, ref} from "vue";
import MessageInput from "@/Components/MessageInput.vue";

const props = defineProps({
    conversations: Object,
});

let messages = ref([]);
let page = 1;
let conversations = ref(props.conversations);
let currentConversation;

onMounted(() => {
    const masonry = document.querySelector('div.sidebar');
    masonry.addEventListener('scroll', (e) => {
        if (masonry.scrollTop + masonry.clientHeight === masonry.scrollHeight) {
            getConversation();
        }
    })
})

async function getMessages(conv) {
    currentConversation = conv;
    await axios.get(`conversation/${conv.id}`)
        .then(function (response) {
            messages.value = response.data;
        });
}

async function getConversation() {
    await axios.get(`conversation?page=${++page}&type=ajax`)
        .then(function (response) {
            conversations.value = conversations.value.concat(response.data);
        });
}

</script>

<template>
    <Head :title="$t('conversation.conversations')"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('conversation.conversations') }}</h2>
                <a :href="route('conv.create')"
                   class="bg-red-500 hover:red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">{{ $t('conversation.create_conversation')}}</a>
            </div>
        </template>
        <div class="container flex">
            <div class="sidebar bg-gray-200 w-1/3 overflow-hidden overflow-y-auto">
                <div class="chat p-2 border border-gray-300" v-for="conv in conversations" @click="getMessages(conv)">{{conv.title}}</div>
            </div>
            <div class="chat-side w-2/3 border border-gray-300 relative">
                <div class="message" v-for="message in messages">
                    <div class="message-author">{{message.user.name}}</div>
                    <div class="message-text">{{message.message}}</div>
                </div>
                <MessageInput class="absolute bottom-0" v-if="currentConversation" type="conversation" :object="currentConversation"/>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style lang="scss">
.sidebar {
    max-height: 700px;
}

</style>