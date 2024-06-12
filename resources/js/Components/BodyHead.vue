<script setup>
defineProps({
    title: String
})
</script>

<template>
    <h1 class="mb-4 text-xl font-extrabold text-gray-900 dark:text-white md:text-xl lg:text-xl border-b-2 border-sky-200">
        <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
            {{ title }}
        </span>
    </h1>
</template>
