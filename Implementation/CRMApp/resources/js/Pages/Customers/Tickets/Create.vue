<script setup>

import {Link, router, useForm} from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import FormSection from "@/Components/FormSection.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    customer: Object,
    projects: Array,
})

const form = useForm({
    'title': '',
    'description': '',
    'category': '',
    'project_id': '',
});

const submit = () => {
    console.log(form.data())
    form.post(route('customers.tickets.store', {customer: props.customer.registration_number}), {});
};
</script>

<template>
    <AppLayout title="Create Customer">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Create Ticket</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Create a Ticket for Customer {{ customer.customer_name }}
                </template>

                <template #description>
                    Enter the details of the ticket. It will then be created in GitLab.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="title" value="Title" required/>
                        <TextInput
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="project" value="Gitlab Project" required/>
                        <Select
                            id="project"
                            v-model="form.project_id"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        >
                            <option v-for="project in projects" :value="project.gitlab_project_id">{{ project.name }}</option>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.category"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="category" value="Category" required/>
                        <Select
                            id="category"
                            v-model="form.category"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        >
                            <option value="issue">
                                Issue
                            </option>
                            <option value="incident">
                                Incident
                            </option>
                            <option value="test_case">
                                Test Case
                            </option>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.category"/>
                    </div>

                    <!--                    TODO needs changing to textarea -->
                    <div class="col-span-6">
                        <InputLabel for="description" value="Description" required/>
                        <TextInput
                            id="description"
                            v-model="form.description"
                            type="text"
                            class="mt-1 block w-full"
                            textarea
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.description"/>
                    </div>

                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>
                    <SecondaryButton class="mr-3" :class="{ 'opacity-25': form.processing }"
                                     @click="form.reset; router.get(route('customers.show', {customer: props.customer.registration_number}))"
                                     :disabled="form.processing">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
