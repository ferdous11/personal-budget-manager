<script setup>

import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: '',
    type: 'income',
});

const submit = () => {
    form.post(route('categories.store'), {
        onFinish: () => form.reset('name'),
    });
};


</script>

<template>
    <Head title="Add Category"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2>Add Category</h2>

<!--                        {{ form }}-->

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Name"/>
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>

                            <div class="mt-4">


                                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Select Type
                                </label>
                                <select id="type" v-model="form.type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.type"/>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Add Category
                                </PrimaryButton>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
