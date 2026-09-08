<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import {computed, ref, watch} from "vue";
import OverviewTable from "@/Pages/Customers/Partials/OverviewTable.vue";
import {router, useForm} from "@inertiajs/vue3";
import {FilterType} from "@/Pages/Customers/Partials/FilterType";

const props = defineProps({
    customers: Object,
    filters: Object,
})
const data = computed(() => {
    return props.customers.data
})
const pagination = computed(() => {
    let data = {...props.customers};
    delete data.data
    return data
})
const availableFilters: FilterType[] = [
    {
        property: 'customer_name',
        type: 'text',
        label: 'Customer Name',
        nullable: false
    },
    {
        property: 'registration_number',
        type: 'text',
        label: 'Registration Number',
        nullable: false
    },
    {
        property: 'vat_number',
        type: 'text',
        label: 'VAT Number',
        nullable: false
    },
    {
        property: 'email',
        type: 'text',
        label: 'Email',
        nullable: true
    },
    {
        property: 'website',
        type: 'text',
        label: 'Website',
        nullable: true
    },
    {
        property: 'active',
        type: 'boolean',
        label: 'Active',
        nullable: false
    },
    {
        property: 'address_street',
        type: 'text',
        label: 'Street',
        nullable: false
    },
    {
        property: 'address_city',
        type: 'text',
        label: 'City',
        nullable: false
    },
    {
        property: 'address_postal_code',
        type: 'text',
        label: 'Zip Code',
        nullable: false
    },
    {
        property: 'address_country',
        type: 'text',
        label: 'Country',
        nullable: false
    },
    {
        property: 'address_additional_information',
        type: 'text',
        label: 'Additional Address Information',
        nullable: true
    }
]
const search = ref(props.filters.search ?? '')
const filters = ref(props.filters.filters ?? [])
watch([search, filters], ([value, value2]) => {
    router.get(route('customers.index', {search: value, filters: value2}), {}, {
        preserveState: true,
        replace: true,
    })
}, {
    deep: true
})
</script>

<template>
    <AppLayout title="Customers">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('customers.create')">
                Create Customer
            </PrimaryButtonLink>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
            <OverviewTable :customers="data" :pagination="pagination" v-model:search="search"
                           v-model:filters="filters" :filterTypes="availableFilters" />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
