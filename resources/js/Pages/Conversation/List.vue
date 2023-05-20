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
        <div class="container flex conversation">
            <div class="sidebar bg-gray-200 w-1/3 overflow-hidden overflow-y-auto">
                <div class="chat p-2 border border-gray-300" v-for="conv in conversations" @click="getMessages(conv)">{{conv.title}}</div>
            </div>
            <div class="chat-side flex flex-col w-2/3 border border-gray-300 overflow-hidden overflow-y-auto">
                <div class="w-full h-full px-5 justify-between overflow-x-auto">
                    <div class="flex flex-col mt-5">
                        <div class="message" v-for="message in messages">
                            <div class="flex justify-end mb-4 items-end" v-if="message.user.id == $page.props.auth.user.id">
                                <div
                                    class="mr-2 py-3 px-4 bg-blue-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white"
                                >
                                    {{message.message}}
                                </div>
                                <img
                                    :src="'/storage/avatars/' +  message.user.avatar"
                                    class="object-cover h-8 w-8 rounded-full"
                                    alt=""
                                />
                            </div>
                            <div class="flex justify-start mb-4 items-end" v-else>
                                <img
                                    :src="'/storage/avatars/' +  message.user.avatar"
                                    class="object-cover h-8 w-8 rounded-full"
                                    alt=""
                                />
                                <div
                                    class="ml-2 py-3 px-4 bg-gray-400 rounded-br-3xl rounded-tr-3xl rounded-tl-xl text-white"
                                >
                                    {{message.message}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <MessageInput v-if="currentConversation" type="conversation" :object="currentConversation"/>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style lang="scss">
.conversation {
    max-height: 700px;
}

.chat {
    cursor: pointer;
}
</style>
