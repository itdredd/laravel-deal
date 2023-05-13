<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, onMounted} from "vue";

let users = ref([]);
let finalUsers = ref([]);
let membersId = '';
let errors = ref([]);

function insertInFinal(user) {
    finalUsers.value.push(user);

    if (!membersId.length) {
        membersId += user.name;
    } else {
        membersId += ', ' + user.name;
    }
}

function findUser(event) {
    if (event.target.value.length >= 2) {
        axios.post('/users/find/', {name: event.target.value}).then((response) => {
            users.value = [];
            response.data.forEach(elem => users.value.push(elem));

        }, (error) => {
            console.log(error);
        });
    }

}

function remove(index, user) {
    let users = membersId.split(', ');

    finalUsers.value.splice(index, 1);
    users.splice(index, 1);

    membersId = users;
}

function checkForm(e) {
    errors.value = [];
    if (!membersId.length) {
        errors.value.push("Members is required.")
        e.preventDefault();
    }

    return true;
}

</script>

<template>
    <Head :title="$t('conversation.create_conversation')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('conversation.create_conversation') }}</h2>
        </template>

        <form method="POST" @submit="checkForm">
            <p v-if="errors.length">
                <span class="error" v-for="error in errors">{{ error }}</span>
            </p>
            <div>
                <InputLabel for="title" :value="$t('form.title')"/>

                <TextInput
                    id="title"
                    type="text"
                    name="title"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    :placeholder="$t('form.title')"
                />
            </div>

            <div class="mt-4">
                <InputLabel for="message" :value="$t('message.message')"/>

                <TextArea
                    id="message"
                    type="text"
                    name="message"
                    class="mt-1 block w-full"
                    :placeholder="$t('message.message')"
                />
            </div>
            <div class="mt-4">
                <InputLabel for="members_id" :value="$t('message.members')"/>
                <div class="inline-block p-1 border rounded bg-gray-200 mr-2 mb-2" :id="user['id']" v-for="(user, index) in finalUsers"
                     @click="remove(index, user)">{{ user['name'] }}
                    <i class="fa-solid fa-trash fa-sm"></i>
                </div>
                <TextInput
                    id="members_id"
                    type="text"
                    class="mt-1 w-full"
                    @input="findUser"
                />
                <ul>
                    <li class="inline-block rounded p-1 my-2 bg-gray-400 cursor-pointer" v-for="user in users" :id="user['id']" @click="insertInFinal(user)">User: {{
                            user['name']
                        }}
                    </li>
                </ul>
            </div>
            <div class="mt-4">
                <PrimaryButton>
                    {{ $t('form.sent') }}
                </PrimaryButton>
            </div>
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="members_id" v-model="membersId">
        </form>
    </AuthenticatedLayout>
</template>

<style lang="scss">
li.inline-block + li.inline-block {
    margin-left: 1em;
}

</style>
