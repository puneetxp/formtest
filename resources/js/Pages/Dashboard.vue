<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden flex bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="flex justify-around flex-wrap my-5 sm:text-xl md:text-2xl">
                        <Link :href="route('user.index')"
                            class="p-10 m-3 lg:m-10 rounded bg-gray-800 dark:bg-gray-400 dark:text-black text-white hover:text-black hover:bg-white dark:hover:bg-gray-700 dark:hover:text-white w-28 h-28 sm:w-44 sm:h-44 md:w-52 lg:w-60 lg:h-60 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-110">
                            Users
                        </Link>
                        <Link :href="route('role.index')"
                            class="p-10 m-3 lg:m-10 rounded bg-gray-800 dark:bg-gray-400 dark:text-black text-white hover:text-black hover:bg-white dark:hover:bg-gray-700 dark:hover:text-white w-28 h-28 sm:w-44 sm:h-44 md:w-52 lg:w-60 lg:h-60 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-110">
                        Roles
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
