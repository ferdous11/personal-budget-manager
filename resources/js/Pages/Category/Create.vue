<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import BodyHead from "@/Components/BodyHead.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    page_title: String
})

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
                                    <Link :href="route('categories.index')"
                                          class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                    >
                                        Go Category
                                    </Link>
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
        </div>
    </AuthenticatedLayout>
</template>

