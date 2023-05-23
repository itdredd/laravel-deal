<template>
    <div class="message-input w-full">
        <form class="flex" method="POST" @submit="sentMessage">
            <TextArea class="w-full" name="message" :value="message ? message.message : ''" :placeholder="$t('form.enter_your_message')"
                      :disabled="object ? (object.status === 'rejected' || object.status === 'close') : false"/>
            <PrimaryButton class="min-w-max" :disabled="object ? (object.status === 'rejected' || object.status === 'close') : false">
                {{ action ?? $t('form.sent') }}
            </PrimaryButton>
            <input type="hidden" name="_token" :value="csrf">
        </form>
    </div>
</template>

<script setup>
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    type: String,
    object: Object,
    action: String,
    message: Object
})

function sentMessage(e) {
    e.preventDefault();
    let formData = new FormData(e.target);

    axios.post(`/${props.type}/${props.object.id}/post-reply`, {
        _token: formData.get('_token'),
        message: formData.get('message'),
    });
}
</script>