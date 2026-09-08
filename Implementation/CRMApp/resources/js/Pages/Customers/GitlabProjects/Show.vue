<script setup>

import {Link} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionSection from "@/Components/ActionSection.vue";
import {computed} from "vue";
import ChevronRight from "@/Components/ChevronRight.vue";

const props = defineProps({
    customer: Object,
    gitlab_project: Object,
})




const information = computed(() => {
    return [
        {
            title: "Ticket Information",
            description: "Information about the Ticket",
            content: [
                {
                    label: 'ID',
                    value: props.gitlab_project.gitlab_project_id,
                },
                {
                    label: 'Name',
                    value: props.gitlab_project.name,
                },
]
        }
    ]
})
</script>

<template>
    <AppLayout title="Gitlab Project">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / View Gitlab Project</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('customers.gitlab_projects.edit', {customer: customer.registration_number, gitlab_project: gitlab_project.id})">
                Update Customers Gitlab Project
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
