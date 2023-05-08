<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import CurrencySelect from '@/Components/CurrencySelect.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, onMounted} from "vue";

let users = ref([]);
let finalUsers = ref([]);
let membersId = '';
let errors = ref([]);
let guarantors = ref([]);


onMounted(() => {
    axios.get('/guarantors/find')
        .then(function (response) {
            guarantors.value = response.data;
        })
})

function insertInFinal(user) {
    finalUsers.value.push(user);

    if (!membersId.length) {
        membersId += user.name;
    } else {
        membersId += ', ' + user.name;
    }
}

function findUser(event) {
    users.value = [];
    if (event.target.value.length >= 1) {
        axios.post('/users/find/', {name: event.target.value}).then((response) => {
            response.data.forEach(elem => users.value.push(elem));

        }, (error) => {
            console.log(error);
        });
    }

}

function remove(index, user) {
    let users = membersId.value.split(', ');

    finalUsers.value.splice(index, 1);
    users.splice(index, 1);

    membersId = users;
}

function checkForm(e) {
    errors.value = [];
    if(!membersId.length) {
        errors.value.push("Members is required.")
        e.preventDefault();
    }

    return true;
}

</script>

<template>
    <Head title="Create Deal"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create deal</h2>
        </template>

        <form method="POST" @submit="checkForm">
            <p v-if="errors.length">
                <span class="error" v-for="error in errors">{{ error }}</span>
            </p>
            <div>
                <InputLabel for="title" value="Title"/>

                <TextInput
                    id="title"
                    type="text"
                    name="title"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    placeholder="Title"
                />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Description"/>

                <TextArea
                    id="description"
                    type="text"
                    name="description"
                    class="mt-1 block w-full"
                    placeholder="Description"
                />
            </div>
            <div class="mt-4">
                <InputLabel for="value" value="Value"/>

                <div class="flex justify-between">
                    <TextInput
                        id="value"
                        type="number"
                        name="value"
                        class="mt-1 w-2/12"
                        required
                        placeholder="100"

                    />
                    <CurrencySelect
                        id="currency"
                        name="currency"
                        class="mt-1 w-2/12"
                        required
                    />
                </div>
            </div>
            <div class="mt-4">
                <InputLabel for="members_id" value="Members"/>
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
                <InputLabel for="guarantor_id" value="Guarantor"/>
                <select id="guarantor_id" name="guarantor_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option>Select guarantor</option>
                    <option v-for="guarantor in guarantors" :id="guarantor['id']">{{ guarantor['name'] }}</option>
                </select>
            </div>
            <div class="mt-4">
                <PrimaryButton>
                    Sent
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
