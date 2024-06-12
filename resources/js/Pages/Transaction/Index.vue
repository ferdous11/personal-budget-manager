<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import BodyHead from "@/Components/BodyHead.vue";
import {computed} from "vue";


defineProps({
    page_title: String,
    transactions: Object,
})

const form = useForm({
    id: '',
});
const deleteItem = (id) => {
    if (confirm('Are you sure you want to delete this transaction?')) {
        form.delete(route('transactions.destroy', {id: id}), {});
    }
};

const total_progress = usePage().props.total_progress;
const current_progress = usePage().props.current_progress;
const tp =  `${total_progress}%`
const cp =  `${current_progress}%`
</script>

<template>
    <Head :title="page_title"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
                    {{ page_title }}
                </span>
                </h2>
                <Link :href="route('transactions.create')"
                      class="text-xs px-3 py-2 text-center mr-2
                             text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                >
                    Add Transaction
                </Link>
            </div>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <BodyHead :title="page_title"/>

<!--                        <div class="w-full bg-green-200 rounded-full dark:bg-green-700 mb-5">-->
<!--                            <div class="bg-pink-500 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full" style="width: 85%"> 85%</div>-->
<!--                        </div>-->

                        <div class="mb-5">
                            <div class="flex justify-between mb-1">
                                <span class="text-base font-medium text-blue-500 dark:text-white">In Total</span>
                                <span class="text-sm font-medium text-blue-500 dark:text-white">{{total_progress}}%</span>
                            </div>

                            <div class="w-full bg-green-200 rounded-full h-2.5 dark:bg-green-700">
                                <div class="bg-pink-400 h-2.5 rounded-full" :style="{ width: tp }"></div>
                            </div>

                            <div class="flex justify-between mb-1 mt-4">
                                <span class="text-base font-medium text-green-500 dark:text-white">Current Month</span>
                                <span class="text-sm font-medium text-green-500 dark:text-white">{{current_progress}}%</span>
                            </div>

                            <div class="w-full bg-green-200 rounded-full h-2.5 dark:bg-green-700">
                                <div class="bg-pink-400 h-2.5 rounded-full" :style="{ width: cp }"></div>
                            </div>
                        </div>


                        <div v-if="transactions">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-sky-50 dark:bg-sky-700 dark:text-sky-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Transaction Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category Type
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in transactions" :key="index"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ item.description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.amount }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.transaction_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.category.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            :class="[item.category.type === 'income' ? 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300':'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300']">
                                            {{ item.category.type }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4">
                                        <Link :href="route('transactions.edit', item.id)"
                                              class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                        >
                                            Edit
                                        </Link>

                                        <Link :href="route('transactions.show', item.id)"
                                              class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg"
                                        >
                                            Details
                                        </Link>

                                        <button type="button"
                                                @click="deleteItem(item.id)"
                                                class="text-xs px-3 py-2 text-center
                                              text-white bg-gradient-to-r from-pink-500 via-pink-600 to-pink-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 font-medium rounded-lg"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-else class="max-w-sm mx-auto border border-sky-200 p-5 rounded-lg">
                            <div
                                class="p-4 mb-4 text-center text-sm text-sky-700 rounded-lg bg-sky-100 dark:bg-gray-800 dark:text-sky-400"
                                role="alert">
                                <p class="mb-5"><span class="font-medium">Transaction</span> does not exists.</p>
                                <Link :href="route('transactions.create')"
                                      class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                >
                                    Add Transaction
                                </Link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

