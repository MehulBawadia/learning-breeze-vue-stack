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
                <div v-if="userDeletedSuccessfully" v-text="responseMessage" class="mb-6 px-3 py-2 bg-green-200 rounded-lg text-green-800"></div>

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
                                <Link :href="route('users.edit', user.id)" class="font-semibold inline-block mt-3 bg-indigo-500 duration-150 ease-in-out hover:bg-indigo-600 px-4 py-2 rounded-md text-white text-xs tracking-widest transition uppercase">Edit User</Link>

                                <BreezeButton type="submit" class="ml-3" @click.prevent="deleteUser(user.id)">Delete User</BreezeButton>
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
import BreezeButton from '@/Components/Button.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        BreezeButton
    },

    props: ['users'],

    data() {
        return {
            responseMessage: "",
            userDeletedSuccessfully: false,
        }
    },

    methods: {
        deleteUser(id) {
            axios.delete(route('users.delete', id))
                .then(response => {
                    if (response.data.status == 'failed') {
                        alert(response.data.message);
                    }
                    if (response.data.status == 'success') {
                        this.responseMessage = response.data.message;
                        this.userDeletedSuccessfully = true;

                        let i = this.users.map(user => user.id).indexOf(id);
                        this.users.splice(i, 1);
                    }
                });
        }
    }
}
</script>
