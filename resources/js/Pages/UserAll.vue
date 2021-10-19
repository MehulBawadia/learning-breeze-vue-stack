<template>
    <Head title="Users List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    List of all Users
                </h2>

                <Link :href="route('users.create')" class="bg-indigo-500 duration-150 ease-in-out hover:bg-indigo-600 px-3 py-2 rounded text-white transition">Add New User</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-white border overflow-hidden px-6 py-6 space-y-2" v-for="user in users" :key="user.id">
                            <div>
                                <span class="text-gray-500">Id:</span>
                                <span class="ml-3 text-gray-800" v-text="user.id"></span>
                            </div>
                            <div>
                                <span class="text-gray-500">Name:</span>
                                <span class="ml-3 text-gray-800" v-text="user.name"></span>
                            </div>
                            <div>
                                <span class="text-gray-500">E-Mail:</span>
                                <span class="ml-3 text-gray-800" v-text="user.email"></span>
                            </div>
                            <div>
                                <Link :href="route('users.edit', user.id)" class="inline-block mt-3 bg-indigo-500 duration-150 ease-in-out hover:bg-indigo-600 px-3 py-1 rounded text-white transition">Edit User</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },

    props: ['users'],
}
</script>
