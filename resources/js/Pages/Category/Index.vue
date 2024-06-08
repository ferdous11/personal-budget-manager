<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import {Head, usePage, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const categories = usePage().props.categories;
const form = useForm({
    id: '',
});
const deleteCategory = (id) => {
    if(confirm('Are you sure you want to delete this category?')) {
        // console.log(id);
        form.delete(route('categories.destroy', {id: id}), {
        });
    }
};


</script>

<template>
    <Head title="Category List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2>Category List</h2>


                        <div class="relative overflow-x-auto">
                            <Link :href="route('categories.create')"
                                  class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4
                            focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600
                            dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Add Category
                            </Link>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category, index) in categories" :key="index"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index+1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ category.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ category.type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link :href="route('categories.edit', {category: category.id})">
                                            Edit
                                        </Link>
                                        |
                                        <button type="button" @click="deleteCategory(category.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
