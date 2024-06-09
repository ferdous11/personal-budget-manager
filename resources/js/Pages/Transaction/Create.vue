<script setup>

import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    amount: '',
    date: '',
    category_id: '',
    description: '',

});

const submit = () => {
    form.post(route('transactions.store'), {
        onFinish: () => form.reset('amount'),
    });
};


</script>

<template>
    <Head title="Add Transaction"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Transaction</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2>Add Transaction</h2>

<!--                        {{ form }}-->

                        <form @submit.prevent="submit">
                            
                            <div>
                                <InputLabel for="amount" value="Amount"/>
                                <TextInput
                                    id="amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.amount"
                                    required
                                    autofocus
                                    autocomplete="Amount"
                                />

                                <InputError class="mt-2" :message="form.errors.amount"/>
                            </div>

                            <div  class="mt-4">
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Select Category
                                </label>
                                <select id="category" v-model="form.category_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">salary</option>
                                    <option value="2">web-dev</option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.category_id"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="date" value="Date"/>
                                <TextInput
                                    id="date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.date"
                                    required
                                    autofocus
                                    autocomplete="<?=date('Y-m-d');?>"
                                />

                                <InputError class="mt-2" :message="form.errors.date"/>
                            </div>
                        
                            <div class="mt-4">
                                <InputLabel for="description" value="Description"/>
                                <TextInput
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    required
                                    autofocus
                                    autocomplete="description"
                                />

                                <InputError class="mt-2" :message="form.errors.description"/>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Add Transaction
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
