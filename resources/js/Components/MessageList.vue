<script setup>

import {defineProps, onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";

const props = defineProps({
  deal: Object,
});

let messages = ref([]);

onMounted(() => {
  updateMessages();
})

setInterval(updateMessages, 10000); // TODO ?

function convertTime(time) {
  let options = {year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit'};
  return new Date(time).toLocaleString([], options);
}

async function updateMessages() {
  await axios.get('/message/deal/' + props.deal.id)
      .then(function (response) {
        if(messages.value != response.data)
          messages.value = response.data;
      })
      .catch(function (error) {
        // handle error
        console.log(error);
      });
}

function sentMessage(e) {
  e.preventDefault();
  let formData = new FormData(e.target);

  axios.post('/deal/' + props.deal.id + '/post-reply', {
    _token: formData.get('_token'),
    message: formData.get('message'),
  }).then(function (response) {
    updateMessages();
  })
      .catch(function (error) {
        console.log(error)
      });
}

</script>

<template>
  <div class="message-list">
    <div class="message bg-white rounded-md p-4" v-for="message in messages" :id="message.id" v-if="messages.length">
      <div class="message-top-information flex justify-between">
        <div class="text-sm text-gray-700">
          <span class="text-sm text-gray-700">{{ message.user.name }} | {{ convertTime(message.created_at) }}</span>
          <span v-if="$page.props.auth.user.is_admin"> | <a :href="route('message.remove', {message: message.id})"><i class="fa-solid fa-trash"></i></a></span>
        </div>
        <div class="text-sm text-gray-700">
          <span class="text-sm text-gray-700">#{{ message.id }}</span>
        </div>
      </div>

      <hr class="mb-2">
      <span class="message-text">{{ message.message }}</span>
    </div>
    <div class="message bg-white rounded-md p-4" v-else>
      <span class="block message-information text-sm text-gray-700">Empty.</span>
      <hr class="mb-2">
      <span class="message-text">No message yet.</span>
    </div>
  </div>
  <div class="message-input mt-2">
    <form id="message" method="POST" :action="route('deal.post-reply', {deal: deal})" @submit="sentMessage">
      <TextArea class="w-full" name="message" placeholder="Enter your message" :disabled="deal.status === 'rejected' || deal.status === 'close'"/>
      <PrimaryButton class="block" :disabled="deal.status === 'rejected' || deal.status === 'close'">
        Sent
      </PrimaryButton>
      <input type="hidden" name="_token" :value="csrf">
    </form>
  </div>
</template>

<style lang="scss">
.message + .message {
  margin-top: 1em;
}
</style>
