<script setup>
import {defineProps} from "vue";
import MessageInput from "@/Components/MessageInput.vue";

const props = defineProps({
    messages: Object,
});
</script>

<template>
    <div class="message-list">
        <div class="message" v-for="message in messages" :id="message.id">
            <span class="message-author">{{ message.user.name + ' '}}</span>
            <span class="message-text">{{message.message}}</span>
        </div>
    </div>
</template>
