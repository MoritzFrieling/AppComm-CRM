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
import TextArea from "@/Components/TextArea.vue";

const props = defineProps({
    customer: Object,
    gitlab_projects : Array,
})

const form = useForm({
    'id': '',
});

const submit = () => {


    console.log(form.data())
    form.post(route('customers.gitlab_projects.store', {customer: props.customer.registration_number}), {});
};
</script>

<template>
    <AppLayout title="Create Gitlab Project">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Assign Gitlab Project</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Assign a Gitlab Project to Customer {{ customer.customer_name }}
                </template>

                <template #description>
                    Enter the details of the Gitlab Project
                </template>

                <template #form>
                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="gitlab_project_id" value="Gitlab Project" required/>
                        <Select
                            id="gitlab_project_id"
                            v-model="form.id"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        >
                            <option v-for="gitlab_project in gitlab_projects" :value="gitlab_project.id">
                                {{gitlab_project.name}}
                            </option>
                        </Select>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>
                    <SecondaryButton class="mr-3" :class="{ 'opacity-25': form.processing }"
                                     @click="form.reset; router.get(route('customers.show', {customer: props.customer.registration_number}))"
                                     :disabled="form.processing">
                        Abort
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Assign To Customer
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
