<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import BodyHead from "@/Components/BodyHead.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const page_title = usePage().props.page_title;
const category = usePage().props.category;


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

                        <div class="max-w-sm mx-auto border border-sky-200 p-5 rounded-lg">
                            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="#">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ category.name.toUpperCase()}}
                                    </h5>
                                </a>
                                <p class="mb-3 font-normal" :class="category.type === 'income' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400'">
                                    {{ category.type.toUpperCase() }}
                                </p>
                                <Link :href="route('categories.index')"
                                      class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                >
                                    Go Category
                                </Link>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

