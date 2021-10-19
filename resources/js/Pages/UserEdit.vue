<template>
    <Head title="Edit User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User: {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white px-6 py-6">
                        <div v-if="userUpdatedSuccessfully" class="mb-6 px-3 py-2 rounded bg-green-200 text-green-800">User updated successfully</div>

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
                                <button type="submit" class="bg-indigo-500 duration-150 ease-in-out focus:bg-indigo-600 hover:bg-indigo-600 px-3 py-2 rounded text-white transition" @click.prevent="addNewUser()">Update User</button>

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

    props: ['user'],

    data() {
        return {
            name: this.user.name,
            email: this.user.email,
            formErrors: [],
            userUpdatedSuccessfully: false,
            hasErrors: false,
            errorInputClass: "border border-red-500"
        }
    },

    methods: {
        addNewUser() {
            let patchUrl = route('users.update', this.user.id);
            let form = {
                name: this.name,
                email: this.email,
            };

            axios.patch(patchUrl, form)
                .then(response => {
                    if (response.data.status == 'success') {
                        this.userUpdatedSuccessfully = true;
                        this.hasErrors = false;
                        this.formErrors = [];
                    }
                }).catch(err => {
                    this.hasErrors = true;
                    this.formErrors = err.response.data.errors;
                });
        }
    }
}
</script>
