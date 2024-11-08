<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
defineProps<{
    roles?: { name: String, id: number }[];
    mustVerifyEmail?: boolean;
    status?: string;
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
    form.post(route('role.store'), {
        onFinish: () => {
        },
    });
};


const errors = ref<string[]>([]);
const delForm = useForm({});

const deleteRole = (id: number) => {
    form.delete(`role/${id}`);
};
</script>

<template>

    <Head title="Add Role" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Role
                </h2>
                <Link :href="route('role.create')" class="text-xl font-bold dark:text-white">
                +
                </Link>
            </div>
        </template>
        <div class="dark:text-white overflow-x-auto">
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div v-if="roles && roles.length">
                <table class="border-collapse table-auto w-full text-sm p-4 mt-3">
                    <thead>
                        <tr>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Name
                            </th>
                            <th
                                class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in roles" :key="role.id">
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                {{ role.name }}</td>
                            <td
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                <Link :href="route('role.edit', role.id)" class="text-2xl font-bold p-2">&#9998;</Link>
                                <button @click="deleteRole(role.id)"
                                    class="text-2xl font-bold p-2 rotate-45 text-red-700">+</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
