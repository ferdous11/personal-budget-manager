<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import BodyHead from "@/Components/BodyHead.vue";

const data = usePage().props.data;

const tp =  `${data.total_progress}%`
const cp =  `${data.current_progress}%`

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
                    Dashboard
                </span>
            </h2>
        </template>

<!--        <section class="bg-gray-100 dark:bg-gray-900">-->
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 ">
                <div class="bg-white p-4 grid gap-8  md:grid-cols-4">

                    <div class="bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <BodyHead title="Total Income"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white mb-5">
                                {{ data.total_income}}
                            </h3>
                            <BodyHead title="Total Expense"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ data.total_expense}}
                            </h3>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <BodyHead title="Total Ratio"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ data.total_progress }}%
                            </h3>
                            <div class="w-full bg-green-200 rounded-full dark:bg-green-700 mb-5">
                                <div class="bg-pink-500 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full"
                                     :style="{ width: tp }">
                                </div>
                            </div>

                            <BodyHead title="Current Month Ratio"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ data.current_progress }}%
                            </h3>
                            <div class="w-full bg-green-200 rounded-full dark:bg-green-700 mb-5">
                                <div class="bg-pink-500 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full"
                                     :style="{ width: cp }">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <BodyHead title="Current Month Income"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white mb-5">
                                {{ data.current_month_income_expense.income ?? 0}}
                            </h3>

                            <BodyHead title="Current Month Expense"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ data.current_month_income_expense.expense ?? 0}}
                            </h3>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <BodyHead title="Previous Month Income"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white mb-5">
                                {{ data.previous_month_income_expense.income ?? 0}}
                            </h3>

                            <BodyHead title="Previous Month Expense"/>
                            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ data.previous_month_income_expense.expense ?? 0}}
                            </h3>
                        </div>
                    </div>

                </div>

            </div>

<!--        </section>-->

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <BodyHead title="Recent 10 Transactions"/>

                        <div v-if="data.recent_10_transactions">
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
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in data.recent_10_transactions" :key="index"
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
