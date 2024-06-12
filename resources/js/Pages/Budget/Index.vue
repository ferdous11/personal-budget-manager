<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import BodyHead from "@/Components/BodyHead.vue";


defineProps({
    page_title: String,
    budgets: Object,
})

const form = useForm({
    id: '',
});
const deleteItem = (id) => {
    if (confirm('Are you sure you want to delete this category?')) {
        form.delete(route('budgets.destroy', {id: id}), {});
    }
};

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
                <Link :href="route('budgets.create')"
                      class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                >
                    Add Budget
                </Link>
            </div>

        </template>

        <div class="py-12">
<!--            {{ $page.props.message }}-->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <BodyHead :title="page_title"/>

                        <div v-if="budgets.length > 0"
                             class="max-w-screen-md mx-auto border border-sky-200 p-5 rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-sky-50 dark:bg-sky-700 dark:text-sky-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Start Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        End Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in budgets" :key="index"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ item.amount }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.start_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.end_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link :href="route('budgets.edit', item.id)"
                                              class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                        >
                                            Edit
                                        </Link>

                                        <Link :href="route('budgets.show', item.id)"
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
                                <p class="mb-5"><span class="font-medium">Budget</span> does not exists.</p>
                                <Link :href="route('budgets.create')"
                                      class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                >
                                    Add Budget
                                </Link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

