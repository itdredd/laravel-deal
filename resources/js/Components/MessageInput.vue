<template>
    <div class="message-input mt-2">
        <form method="POST" @submit="sentMessage" v-if="!action && !message">
            <TextArea class="w-full" name="message" :placeholder="$t('form.enter_your_message')"
                      :disabled="deal.status === 'rejected' || deal.status === 'close'"/>
            <PrimaryButton class="block" :disabled="deal && (deal.status === 'rejected' || deal.status === 'close')">
                {{ $t('form.sent') }}
            </PrimaryButton>
            <input type="hidden" name="_token" :value="csrf">
        </form>
        <form method="POST" v-else>
            <TextArea class="w-full" name="message" :value="message.message" :placeholder="$t('form.enter_your_message')"/>
            <PrimaryButton class="block">
                {{ action }}
            </PrimaryButton>
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </div>
</template>

<script setup>
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    deal: Object,
    action: String,
    message: Object
})

function sentMessage(e) {
    e.preventDefault();
    let formData = new FormData(e.target);

    axios.post(`/deal/${props.deal.id}/post-reply`, {
        _token: formData.get('_token'),
        message: formData.get('message'),
    });
}
</script>

<style scoped>

</style>
