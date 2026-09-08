<script setup>

import {Link} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionSection from "@/Components/ActionSection.vue";
import {computed} from "vue";
import ChevronRight from "@/Components/ChevronRight.vue";

const props = defineProps({
    customer: Object,
    customer_solutions: Array
})

const information = computed(() => {
    return [
        {
            title: "General Information",
            description: "All the basic information about the customer.",
            content: [
                {
                    label: 'Company name',
                    value: props.customer.customer_name,
                },
                {
                    label: 'Registration number',
                    value: props.customer.registration_number,
                },
                {
                    label: 'VAT number',
                    value: props.customer.vat_number,
                },
                {
                    label: 'Email',
                    value: props.customer.email,
                },
                {
                    label: 'Website',
                    value: props.customer.website,
                },
                {
                    label: 'Active',
                    value: props.customer.active ? 'Yes' : 'No',
                }
            ]
        },
        {
            title: "Address",
            description: "The address of the customer.",
            content: [
                {
                    label: 'Street',
                    value: props.customer.address_street,
                },
                {
                    label: 'Number',
                    value: props.customer.address_house_number,
                },
                {
                    label: 'Postal code',
                    value: props.customer.address_postal_code,
                },
                {
                    label: 'City',
                    value: props.customer.address_city,
                },
                {
                    label: 'Country',
                    value: props.customer.address_country,
                },
                {
                    label: 'Additional information',
                    value: props.customer.address_additional_information,
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
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / View Customer</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('customers.edit', customer.registration_number)">
                Update Customer
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
                            <div class="justify-end items-center inline-flex">
                                <div
                                    class="text-right text-gray-700 dark:text-gray-400 text-xs font-semibold uppercase whitespace-nowrap mt-0.5">
                                    {{ info.label }}
                                </div>
                            </div>
                            <div class="justify-start items-center inline-flex overflow-hidden text-ellipsis">
                                <div
                                    class="text-left text-gray-800 dark:text-gray-100 text-md font-normal whitespace-nowrap text-ellipsis max-w-full overflow-hidden">
                                    {{ info.value || 'n/A' }}
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </ActionSection>

            <ActionSection>
                <template #title>
                    Contact Persons
                </template>
                <template #description>
                    All the contact persons of the customer.
                </template>
                <template #content>
                    <div class="flex flex-col gap-y-2 text-gray-500 dark:text-gray-400">
                        <Link v-for="(contact_person, index) in props.customer.contact_persons" :key="contact_person.id"
                              class="text-gray-500 dark:text-gray-400 bg-gray-50 hover:bg-gray-200 dark:bg-gray-700 hover:dark:bg-gray-600 hover:cursor-pointer flex flex-nowrap gap-4 items-center rounded-lg bg-opacity-10 dark:bg-opacity-30 py-3 px-6"
                              :href="route('customers.contact_persons.show', {customer: customer.registration_number, contact_person: contact_person.id})">
                            <div
                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{
                                    [contact_person.first_name, contact_person.middle_name, contact_person.last_name].filter(Boolean).join(' ')
                                }}
                            </div>
                            <div class="">
                                {{
                                    contact_person.email
                                }}
                            </div>
                            <div class="ml-auto">
                                <ChevronRight class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                            </div>
                        </Link>
                        <PrimaryButtonLink
                            class="self-end mt-4"
                            :href="route('customers.contact_persons.create', {customer: customer.registration_number})">
                            Add Contact Person
                        </PrimaryButtonLink>
                    </div>
                </template>
            </ActionSection>


            <!--todo Fetch Actual Solution Name etc.-->
            <ActionSection>
                <template #title>
                    Solutions
                </template>
                <template #description>
                    All the solutions assigned to the customer.
                </template>
                <template #content>
                    <div class="flex flex-col gap-y-2 text-gray-500 dark:text-gray-400">
                        <Link v-for="(solution, index) in props.customer_solutions" :key="solution.solution_id"
                              class="text-gray-500 dark:text-gray-400 bg-gray-50 hover:bg-gray-200 dark:bg-gray-700 hover:dark:bg-gray-600 hover:cursor-pointer flex flex-nowrap gap-4 items-center rounded-lg bg-opacity-10 dark:bg-opacity-30 py-3 px-6"
                              :href="route('customers.solutions.show', {customer: customer.registration_number, solution: solution.id})">
                            <div
                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                {{
                                    solution.solution.title
                                                                    }}
                            </div>
                            <div class="">
                                {{
                                    solution.description
                                }}
                            </div>
                            <div class="ml-auto">
                                <ChevronRight class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                            </div>
                        </Link>
                        <PrimaryButtonLink
                            class="self-end mt-4"
                            :href="route('customers.solutions.create', {customer: customer.registration_number})">
                            Assign Solution

                        </PrimaryButtonLink>
                    </div>
                </template>
            </ActionSection>
            

            <ActionSection>
                <template #title>
                    Gitlab Projects
                </template>
                <template #description>
                    All the gitlab projects of the customer.
                </template>
                <template #content>
                    <div class="flex flex-col gap-y-2 text-gray-500 dark:text-gray-400">
                        <Link v-for="(project, index) in props.customer.gitlab_projects" :key="project.id"
                              class="text-gray-500 dark:text-gray-400 bg-gray-50 hover:bg-gray-200 dark:bg-gray-700 hover:dark:bg-gray-600 hover:cursor-pointer flex flex-nowrap gap-4 items-center rounded-lg bg-opacity-10 dark:bg-opacity-30 py-3 px-6"
                              :href="route('customers.gitlab_projects.show', {customer: customer.registration_number, gitlab_project: project.id})">
                            <div
                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{
                                    project.name
                                }}
                            </div>
                            <div class="">
                                {{
                                    project.gitlab_project_id
                                }}
                            </div>
                            <div class="ml-auto">
                                <ChevronRight class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                            </div>
                        </Link>
                        <PrimaryButtonLink
                            class="self-end mt-4"
                            :href="route('customers.gitlab_projects.create', {customer: customer.registration_number})">
                            Add Project
                        </PrimaryButtonLink>
                    </div>
                </template>
            </ActionSection>

            <ActionSection>
                <template #title>
                    Gitlab Tickets
                </template>
                <template #description>
                    All the gitlab tickets of the customer.
                </template>
                <template #content>
                    <div class="flex flex-col gap-y-2 text-gray-500 dark:text-gray-400">
                        <Link v-for="(ticket, index) in customer.tickets" :key="ticket.id"
                              class="text-gray-500 dark:text-gray-400 bg-gray-50 hover:bg-gray-200 dark:bg-gray-700 hover:dark:bg-gray-600 hover:cursor-pointer flex flex-nowrap gap-4 items-center rounded-lg bg-opacity-10 dark:bg-opacity-30 py-3 px-6">
<!--                              :href="route('customers.gitlab_projects.show', {customer: customer.registration_number, gitlab_project: project.id})"-->
                            <div
                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{
                                    ticket.title
                                }}
                            </div>
                            <div class="">
                                {{
                                    ticket.issue_id
                                }}
                            </div>
                            <div class="ml-auto">
                                <ChevronRight class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                            </div>
                        </Link>
                        <PrimaryButtonLink
                            class="self-end mt-4"
                            :href="route('customers.tickets.create', {customer: customer.registration_number})">
                            Create Ticket
                        </PrimaryButtonLink>
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
