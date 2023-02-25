<template>
    <div class="message-input">
        <form method="POST" :action="route('deal.post-reply', {deal: deal})">
            <TextArea class="w-full" name="message" placeholder="Enter your message" :disabled="deal.status === 'rejected'"/>
            <PrimaryButton class="block" :disabled="deal.status === 'rejected'">
                Sent
            </PrimaryButton>
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </div>
</template>

<script setup>
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    deal: Object,
})
</script>

<style scoped>

</style>
