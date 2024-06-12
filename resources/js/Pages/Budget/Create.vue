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
    amount: '',
    start_date: '',
    end_date: '',
});
const submit = () => {
    form.post(route('budgets.store'), {
        onFinish: () => form.reset('amount', 'start_date', 'end_date'),
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
                                    <InputLabel for="start_date" value="Start Date"/>
                                    <TextInput
                                        id="start_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.start_date"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.start_date"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="end_date" value="End Date"/>
                                    <TextInput
                                        id="end_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.end_date"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.end_date"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <Link :href="route('budgets.index')"
                                          class="text-xs px-3 py-2 text-center mr-2
                                              text-white bg-gradient-to-r from-sky-500 via-sky-600 to-sky-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-800 font-medium rounded-lg"
                                    >
                                        Go Budget
                                    </Link>
                                    <PrimaryButton class="ms-4"
                                                   :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Add Budget
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

