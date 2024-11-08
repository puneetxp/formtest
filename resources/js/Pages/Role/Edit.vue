<script setup lang="ts">

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    role: { name: string, id: number };
    mustVerifyEmail?: boolean;
    status?: string;
}>();

// onUpdated() => {
//     useForm.name = role.name
// }
const form = useForm({
    name: props.role?.name || '',
    id: ''
});

const submit = () => {
    form.patch(route('role.update', props.role.id), {
        onFinish: () => {
        },
    });
};
</script>

<template>

    <Head title="Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create Role
            </h2>
        </template>
        <div class="container m-auto w-96 mt-5">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <PrimaryButton class="ms-4 my-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
