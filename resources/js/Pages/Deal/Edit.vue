<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import CurrencySelect from '@/Components/CurrencySelect.vue';
import StatusSelect from '@/Components/StatusSelect.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    deal: Object,
})

const form = useForm({
    title: '',
    description: '',
    value: '',
    currency: '',
    members_id: '',

});


function findUser(event) {
    $('.dropdown > ul').html("");
    if (event.target.value.length >= 1) {
        axios.get('/users/find', {
            params: {
                name: event.target.value,
            }
        })
            .then(function (response) {
                // handle success
                console.log(response);
                response.data.forEach(element => {
                    console.log(element);
                    $('.dropdown > ul').append('<li class="user-list" v-on:click="appendUser">' + element.name + '</li>')
                })

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }
}

function appendUser(event) {
    if (event.target.matches(".user-list")) {
        $("input#members_id")[0].value = event.target.innerText;
    }
}

const submit = () => {
    form.post(route('deal/' + this.deal.id + '/edit'), {
        onFinish: () => form.reset('title'),
    });
};

</script>

<template>
    <Head title="Create Deal"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit deal: {{ deal.title }}</h2>
        </template>

        <form method="POST">
            <div>
                <InputLabel for="status" value="Status"/>

                <StatusSelect
                    id="status"
                    name="status"
                    class="mt-1 block w-full  rounded-md shadow-sm"
                    required
                    autofocus
                    :value="deal.status"
                />

            </div>
            <div class="mt-4">
                <InputLabel for="title" value="Title"/>

                <TextInput
                    id="title"
                    type="text"
                    name="title"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    placeholder="Title"
                    :value="deal.title"
                />

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Description"/>

                <TextArea
                    id="description"
                    type="text"
                    name="description"
                    class="mt-1 block w-full"
                    placeholder="Descripton"
                    :value="deal.description"
                />

                <InputError class="mt-2" :message="form.errors.description"/>
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
                        :value="deal.value"

                    />
                    <CurrencySelect
                        id="currency"
                        name="currency"
                        class="mt-1 w-2/12"
                        required
                        disabled
                        :value="deal.currency"
                    />
                </div>

                <InputError class="mt-2" :message="form.errors.value"/>
                <InputError class="mt-2" :message="form.errors.currency"/>
            </div>
            <div class="mt-4">
                <InputLabel for="members_id" value="Members"/>
                <TextInput
                    id="members_id"
                    type="text"
                    name="members_id"
                    class="mt-1 w-full"
                    required
                    @input="findUser"
                    :value="deal.members_id"
                />
                <div class="dropdown" @click="appendUser"> <!--TODO realize-->
                    <ul>

                    </ul>
                </div>

                <InputError class="mt-2" :message="form.errors.members_id"/>
            </div>


            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </PrimaryButton>
            </div>
            <input type="hidden" name="_token" :value="csrf">
        </form>


    </AuthenticatedLayout>
</template>
