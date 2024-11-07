<script setup lang="ts">

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { nextTick, reactive, ref } from 'vue';
defineProps<{
    users?: { name: string, id: number, email: string, phone: string, description: string, profile_image: string, role_id: string }[];
    roles?: { name: String, id: number }[];
}>();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    description: '',
    role_id: '',
    profile_image: File,
});

const submit = () => {
    form.post(route('user.store'), {
        onFinish: () => {
        },
    });
};


const errors = ref<string[]>([]);
const userTable = ref<any[]>([]);
let preview: string | null = null;


const state = reactive({ preview: '' })
const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target && target.files) {
        form.profile_image = target.files[0];
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
        <div>

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
                    <input ref="x" class="hidden" type="file" @input="handleFileUpload($event)" />
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            autofocus />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />

                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="phone" value="Phone" />

                        <TextInput id="phone" class="mt-1 block w-full" v-model="form.phone" required />

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

                        <select v-model="form.role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" >
                            <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}
                            </option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>
                    <PrimaryButton class="ms-4 my-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </form>
            </div>
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div v-if="users && users.length">
                <table>
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Role ID</th>
                            <th>Profile Image</th>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.description }}</td>
                            <td>{{ user.role_id }}</td>
                            <td><img :src="`/storage/${user.profile_image}`" alt="Profile Image" /></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
