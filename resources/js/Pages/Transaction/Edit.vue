<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import BodyHead from "@/Components/BodyHead.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const page_title = usePage().props.page_title;
const transaction = usePage().props.transaction;
const categories = usePage().props.categories;


const form = useForm({
    description: transaction.description,
    amount: transaction.amount,
    transaction_date: transaction.transaction_date,
    category_id: transaction.category_id
});
// const form = useForm({
//     description: '',
//     amount: '',
//     transaction_date: '',
//     category_id: '',
// });
const submit = () => {
    form.put(route('transactions.update', transaction.id), {
        onFinish: () => form.reset('description', 'amount', 'transaction_date', 'category_id'),
    });
};

</script>

<template>
    <Head :title="page_title"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
                    {{ page_title }}
                </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <BodyHead :title="page_title"/>

                        <div class="max-w-lg mx-auto border border-sky-200 p-5 rounded-lg">
                            <form @submit.prevent="submit">

                                <div>
                                    <InputLabel for="description" value="Description"/>
                                    <TextInput
                                        id="description"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.description"
                                        required
                                        autofocus
                                    />

                                    <InputError class="mt-2" :message="form.errors.description"/>
                                </div>

                                <div class="mt-4">
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

                                <div class="mt-4">
                                    <InputLabel for="category_id" value="Category"/>
                                    <select
                                        id="category_id"
                                        v-model="form.category_id"
                                        required
                                        autofocus
                                        class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option
                                            v-for="(cetagory, index) in categories"
                                            :key="index"
                                            :value="cetagory.id"
                                        >
                                            {{ cetagory.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category_id"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="transaction_date" value="Transaction Date"/>
                                    <TextInput
                                        id="transaction_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.transaction_date"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.transaction_date"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <Link :href="route('transactions.index')"
                                          class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                    >
                                        Go Transation
                                    </Link>
                                    <PrimaryButton class="ms-4"
                                                   :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Update Transation
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

