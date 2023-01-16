<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {ref} from "vue";

let users = ref([]);
let finalUsers = [];

function find(event) {
    users.value = [];
    if(event.target.value.length >= 1) {
        axios.post('', {name: event.target.value}).then((response) => {
            response.data.forEach(elem => users.value.push(elem));

        }, (error) => {
            console.log(error);
        });
    }

}

function update(user) {
    finalUsers.push(user);
    console.log(finalUsers);
}

</script>

<template>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create deal</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST">
                    <div>
                        <TextInput
                            id="name"
                            type="text"
                            name="name"
                            class="block mt-1 w-24"
                            required
                            autofocus
                            placeholder="Username"
                            @input="find"
                        />
                        <ul>
                            <li v-for="user in users" :id="user['id']"  @click="update(user)" >User: {{ user['name'] }}</li>
                        </ul>
                    </div>

                    <PrimaryButton class="mt-2">
                        Sent
                    </PrimaryButton>
                    <input type="hidden" name="_token" :value="csrf">
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
