<template>
    <Head title="Add New User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white px-6 py-6">
                        <div v-if="userAddedSuccessfully" class="mb-6 px-3 py-2 rounded bg-green-200 text-green-800">User added successfully</div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-500">Name:</label>
                                <input type="text" id="name"  class="w-full rounded pl-3" :class="[hasErrors ? errorInputClass : '']" v-model="name">
                                <span v-if="formErrors.name" class="text-red-500 text-sm">{{ formErrors.name[0] }}</span>
                            </div>
                            <div>
                                <label for="email" class="block text-gray-500">E-Mail:</label>
                                <input type="email" id="email" class="w-full rounded pl-3" :class="[hasErrors ? errorInputClass : '']" v-model="email">
                                <span v-if="formErrors.email" class="text-red-500 text-sm">{{ formErrors.email[0] }}</span>
                            </div>
                            <div>
                                <label for="password" class="block text-gray-500">Password:</label>
                                <input type="password" id="password"  class="w-full rounded pl-3" :class="[hasErrors ? errorInputClass : '']" v-model="password">
                                <span v-if="formErrors.password" class="text-red-500 text-sm">{{ formErrors.password[0] }}</span>
                            </div>
                            <div>
                                <label for="confirm_password" class="block text-gray-500">Confirm Password:</label>
                                <input type="password" id="confirm_password" class="w-full rounded pl-3" :class="[hasErrors ? errorInputClass : '']" v-model="confirm_password">
                                <span v-if="formErrors.confirm_password" class="text-red-500 text-sm">{{ formErrors.confirm_password[0] }}</span>
                            </div>
                            <div>
                                <button type="submit" class="bg-indigo-500 duration-150 ease-in-out focus:bg-indigo-600 hover:bg-indigo-600 px-3 py-2 rounded text-white transition" @click.prevent="addNewUser()">Add User</button>

                                <Link :href="route('users')" class="ml-6 text-gray-500 border border-gray-500 rounded px-3 py-2 hover:border-gray-800 hover:text-gray-800">Cancel</Link>
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

    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirm_password: "",
            formErrors: [],
            userAddedSuccessfully: false,
            hasErrors: false,
            errorInputClass: "border border-red-500"
        }
    },

    methods: {
        addNewUser() {
            let postUrl = route('users.store');
            let form = {
                name: this.name,
                email: this.email,
                password: this.password,
                confirm_password: this.confirm_password,
            };

            axios.post(postUrl, form)
                .then(response => {
                    if (response.data.status == 'success') {
                        this.name = "";
                        this.email = "";
                        this.password = "";
                        this.confirm_password = "";

                        this.userAddedSuccessfully = true;
                        this.hasErrors = false;
                        this.formErrors = [];
                    }
                }).catch(err => {
                    this.password = "";
                    this.confirm_password = "";
                    this.hasErrors = true;
                    this.formErrors = err.response.data.errors;
                });
        }
    }
}
</script>
