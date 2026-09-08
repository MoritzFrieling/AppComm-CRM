<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import {computed, ref, watch} from "vue";
import OverviewTable from "@/Pages/Solutions/Partials/OverviewTable.vue";
import {router} from "@inertiajs/vue3";
import {FilterType} from "@/Pages/Customers/Partials/FilterType";

const props = defineProps({
    solutions: Object,
    filters: Object,
})
const data = computed(() => {
    return props.solutions.data
})
const pagination = computed(() => {
    let data = {...props.solutions};
    delete data.data
    return data
})
const availableFilters: FilterType[] = [
    {
        property: 'title',
        type: 'text',
        label: 'Title',
        nullable: false
    },
    {
        property: 'number',
        type: 'text',
        label: 'Number',
        nullable: false
    },
    {
        property: 'category',
        type: 'text',
        label: 'Category',
        nullable: false
    },
    {
        property: 'description',
        type: 'text',
        label: 'Description',
        nullable: true
    },
]
const search = ref(props.filters.search ?? '')
const filters = ref(props.filters.filters ?? [])
watch([search, filters], ([value, value2]) => {
    router.get(route('solutions.index', {search: value, filters: value2}), {}, {
        preserveState: true,
        replace: true,
    })
}, {
    deep: true
})
</script>

<template>
    <AppLayout title="Solutions">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Solution Overview</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('solutions.create')">
                Create Solution
            </PrimaryButtonLink>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
            <OverviewTable :solutions="data" :pagination="pagination" v-model:search="search"
                           v-model:filters="filters" :filterTypes="availableFilters"/>
        </div>
        <!--        <p class="text-gray-900 dark:text-white">{{pagination}}</p>-->
    </AppLayout>
</template>

<style scoped>

</style>
