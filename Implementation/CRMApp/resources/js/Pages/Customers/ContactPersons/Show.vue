<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionSection from "@/Components/ActionSection.vue";
import {computed} from "vue";

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    customer: Object,
    contact_person: Object,
})

//Object to render Sections automatically using a loop
const information = computed(() => {
    return [
        {
            title: "General Information",
            description: "Information about the contact person.",
            content: [
                {
                    label: 'Company Name',
                    value: props.customer.customer_name,
                },
                {
                    label: 'Name',
                    value: [props.contact_person.first_name, props.contact_person.middle_name, props.contact_person.last_name].filter(Boolean).join(' ')
                        +" ("+
                        (props.contact_person.gender === "m" ? "Male" : props.contact_person.gender === "f" ? "Female" : props.contact_person.gender === "d" ? "Diverse" : "")
                        +")",
                },
                {
                    label: 'Function',
                    value: props.contact_person.function,
                },
                {
                    label: 'E-Mail',
                    value: props.contact_person.email,
                },
                {
                    label: 'Telephone',
                    value: props.contact_person.phone_number !== "" ? props.contact_person.phone_number : 'n/a',
                }
            ]
        },
    ]
})
</script>

<template>
    <AppLayout title="Customers > Contact Person">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> /{{customer.customer_name}}</span>
            </h2>
        </template>
        <template #actions>
            <PrimaryButtonLink :href="route('customers.contact_persons.edit', {customer:customer.registration_number, contact_person:contact_person.id})">
                Update Contact Person
            </PrimaryButtonLink>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5 flex flex-col gap-10">
            <ActionSection v-for="section in information">
                <template #title>
                    {{section.title}}
                </template>
                <template #description>
                    {{section.description}}
                </template>
                <template #content>
                    <div class="grid gap-x-4 gap-y-2">
                        <template v-for="info in section.content">
                            <div class="justify-end items-center inline-flex">
                                <div class="text-right text-gray-700 dark:text-gray-400 text-xs font-semibold uppercase whitespace-nowrap mt-0.5">{{info.label}}</div>
                            </div>
                            <div class="justify-start items-center inline-flex overflow-hidden text-ellipsis">
                                <div class="text-left text-gray-800 dark:text-gray-100 text-md font-normal whitespace-nowrap text-ellipsis max-w-full overflow-hidden">{{info.value || 'n/A'}}</div>
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
