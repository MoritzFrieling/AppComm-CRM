<script setup>

import {Link} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionSection from "@/Components/ActionSection.vue";
import {computed} from "vue";
import ChevronRight from "@/Components/ChevronRight.vue";

const props = defineProps({
    solution: Object,
})

const oneTimePayment = props.solution.recurring_period === null &&
    props.solution.recurring_period_unit === null;

const information = computed(() => {
    return [
        {
            title: "General Information",
            description: "All the basic information about the solution.",
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
                    label: 'Price per unit',
                    value: props.solution.price_per_unit,
                },
                {
                    label: 'Units',
                    value: props.solution.units,
                },
                {
                    label: 'VAT Rate',
                    value: props.solution.vat_rate,
                },
                {
                    label: 'One-Time-Payment',
                    value: oneTimePayment === true ? 'Yes':'No',
                },
                {
                    label: 'Recurring',
                    value: oneTimePayment === true ? undefined : props.solution.recurring_period+" "+props.solution.recurring_period_unit,
                },
                {
                    label: 'Description',
                    value: props.solution.description,
                }
            ]
        }
    ]
})
</script>

<template>
    <AppLayout title="Solutions">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Solution Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / View Solution</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('solutions.edit', solution.number)">
                Update Solution
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
                            <div class="justify-end items-start inline-flex">
                                <div
                                    class="text-right text-gray-700 dark:text-gray-400 text-xs font-semibold uppercase whitespace-nowrap mt-1">
                                    {{ info.label }}
                                </div>
                            </div>
                            <div class="justify-start items-center inline-flex overflow-hidden">
                                <p
                                    class="text-left text-gray-800 dark:text-gray-100 text-md font-normal max-w-full">
                                    {{ info.value || 'n/A' }}
                                </p>
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
