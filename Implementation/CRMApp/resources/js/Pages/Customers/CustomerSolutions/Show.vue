<script setup>

import {Link} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionSection from "@/Components/ActionSection.vue";
import {computed} from "vue";
import ChevronRight from "@/Components/ChevronRight.vue";

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    customer: Object,
    customer_solution: Object,
    solution: Object
})

//logic to determine if it is a one time payment
const oneTimePayment = props.customer_solution.recurring_period === null &&
props.customer_solution.recurring_period_unit === null &&
props.customer_solution.start_date === null &&
props.customer_solution.end_date === null;

//create object with all details, to use a loop to create sections automatically
const information = computed(() => {
    return [
        {
            title: "Solution Information",
            description: "Information about the Solution",
            content: [
                {
                    label: 'Title',
                    value: props.solution.title,
                },
                {
                    label: 'Number',
                    value: props.solution.number,
                },
                {
                    label: 'Category',
                    value: props.solution.category,
                },
                {
                    label: 'Description',
                    value: props.solution.description,
                }
            ]
        },
        {
            title: "Billing Information",
            description: "Information about the Billing for the Solution",
            content: [
                {
                    label: 'Units',
                    value: props.customer_solution.units,
                },
                {
                    label: 'Price Per Unit',
                    value: props.customer_solution.price_per_unit,
                },
                {
                    label: 'VAT-Rate',
                    value: props.customer_solution.vat_rate,
                },
                {
                    label: 'One-Time-Payment',
                    value: oneTimePayment === true ? 'Yes':'No'
                    ,
                },
                {
                    label: 'Recurring',
                    value: oneTimePayment === true ? undefined : props.customer_solution.recurring_period+" "+props.customer_solution.recurring_period_unit,
                },
                {
                    label: 'Time Period',
                    value: oneTimePayment === true ? undefined : props.customer_solution.start_date+" - "+props.customer_solution.end_date,
                }
            ]
        },
        {
            title: "Additional Information",
            description: "Additional Information about the assigned Solution. E.g. domain names.",
            content: [
                {
                    value: props.customer_solution.description === null ? ' ':props.customer_solution.description,
                }
            ]
        }
    ]
})
</script>

<template>
    <AppLayout title="Customers">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / View Solution</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('customers.solutions.edit', {customer: customer.registration_number, solution: customer_solution.id})">
                Update Customers Solution
            </PrimaryButtonLink>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5 flex flex-col gap-10">
            <ActionSection v-for="section in information">
                <template #title>
                    {{ section.title }}
                </template>
                <template #description>
                    {{ section.description }}
                </template>
                <template #content>
                    <div class="grid gap-x-4 gap-y-2">
                        <template v-for="info in section.content">
                            <div class="justify-end items-center inline-flex" v-if="info.value !== undefined">
                                <div
                                    class="text-right text-gray-700 dark:text-gray-400 text-xs font-semibold uppercase whitespace-nowrap mt-0.5">
                                    {{ info.label }}
                                </div>
                            </div>
                            <div class="justify-start items-center inline-flex overflow-hidden text-ellipsis" v-if="info.value !== undefined">
                                <div
                                    class="text-left text-gray-800 dark:text-gray-100 text-md font-normal whitespace-nowrap text-ellipsis max-w-full overflow-hidden">
                                    {{ info.value || 'n/A' }}
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </ActionSection>

        </div>
    </AppLayout>
</template>

<style scoped>
.grid {
    display: grid;
    grid-template-columns: min-content 1fr;
}
</style>
