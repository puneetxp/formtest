<script setup lang="ts">

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
defineProps<{
    users?: { name: string, id: number, email: string, phone: string, description: string, profile_image: string, role_id: string }[];
    roles?: { name: String, id: number }[];
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const form = useForm({
    id: '',
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
        //@ts-ignore
        form.profile_image = target.files[0];
        //@ts-ignore
        state.preview = URL.createObjectURL(form.profile_image);
    }
};
const delForm = useForm({});

const deletePost = (id: number) => {
    form.delete(`posts/${id}`);
};
</script>

<template>

    <Head title="Add User" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    User
                </h2>
                <Link :href="route('user.create')" class="text-xl font-bold dark:text-white">
                +
                </Link>
            </div>
        </template>
        <div class="dark:text-white">
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div v-if="users && users.length">
                <table class="border-collapse table-auto w-full text-sm p-4 mt-3">
                    <thead>
                        <tr>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Name
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Email
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Phone
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Description
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Role ID
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Profile Image
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ user.name }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ user.email }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ user.phone }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ user.description }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ user.role_id }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                <img :src="`/storage/${user.profile_image}`" alt="Profile Image" />
                            </td>

                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                <Link :href="route('user.edit', user.id)" class="text-2xl font-bold p-2">&#9998;</Link>
                                <button @click="deletePost(user.id)"
                                    class="text-2xl font-bold p-2 rotate-45 text-red-700">+</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
