<template>
    <div class="message-input">
        <form method="POST" :action="route('deal.post-reply', {deal: deal})">
            <TextArea class="w-full" name="message" placeholder="Enter your message"/>
            <PrimaryButton class="block">
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
