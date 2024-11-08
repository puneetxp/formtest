<script setup lang="ts">

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

import { reactive, ref } from 'vue';
const props = defineProps<{
    user: { name: string, id: number, email: string, phone: string, description: string, profile_image: string, role_id: string }[];
    roles?: { name: String, id: number }[];
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const form = useForm({
    id: props.user.id || '',
    name: props.user.name || '',
    email: props.user.email || '',
    phone: props.user.phone || '',
    password: 'p@sswor1d',
    description: props.user.description || '',
    role_id: props.user.role_id || '',
    profile_image: File,
});

const submit = () => {
    form.patch(route('user.update', props.user.id), {
        onFinish: () => {
        },
    });
};





const state = reactive({ preview: '' })

state.preview = "/storage/"+props.user.profile_image;
const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target && target.files) {
        //@ts-ignore
        form.profile_image = target.files[0];
        //@ts-ignore
        state.preview = URL.createObjectURL(form.profile_image);
    }
};
</script>


<template>

    <Head title="User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                User
            </h2>
        </template>
        <div class="container m-auto w-96 mt-5">
            <form @submit.prevent="submit">
                <div v-if="state.preview == ''" class="w-24 h-24 text-center dark:text-white border-1 m-auto"
                    v-on:click="$refs.x.click()">
                    Select Image
                </div>
                <div v-if="state.preview !== ''" class="w-24 h-24 text-center dark:text-white border-1 m-auto"
                    v-on:click="$refs.x.click()">
                    <img :src="state.preview" />
                </div>
                <InputError class="mt-2" :message="form.errors.profile_image" />

                <input ref="x" class="hidden" type="file" @input="handleFileUpload($event)" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mt-4 relative">
                    <InputLabel for="phone" value="Phone" />
                    <div class="absolute inset-y-0 start-0 top-6 flex items-center ps-3.5 pointer-events-none dark:text-white">
                        +91
                    </div>
                    <TextInput id="phone" class="mt-1 pl-16 block w-full" v-model="form.phone" required />

                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Description" />

                    <textarea id="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                        v-model="form.description" required />

                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="mt-4">
                    <InputLabel for="role_id" value="Role" />

                    <select v-model="form.role_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}
                        </option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <PrimaryButton class="ms-4 my-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
