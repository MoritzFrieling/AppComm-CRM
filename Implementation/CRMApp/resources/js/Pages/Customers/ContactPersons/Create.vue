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

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    customer: Object
})

/**
 * InertiaForm with default values set to empty
 * @type {InertiaForm<{gender: string, function: string, last_name: string, phone_number: string, middle_name: string, first_name: string, email: string}>}
 */
const form = useForm({
    'gender': '',
    'first_name': '',
    'middle_name': '',
    'last_name': '',
    'email': '',
    'phone_number': '',
    'function': ''
});

/**
 * Function to submit the form via POST to backend
 */
const submit = () => {
    console.log(form.data())
    form.post(route('customers.contact_persons.store', {customer: props.customer.registration_number}), {});
};
</script>

<template>
    <AppLayout title="Create Customer">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Create Contact Person</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Create a new Contact Person to Customer {{ customer.customer_name }}
                </template>

                <template #description>
                    Enter the Details of the Contact Person
                </template>

                <template #form>
                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="gender" value="Gender" required/>
                        <Select
                            id="gender"
                            v-model="form.gender"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="sex"
                        >
                            <option value="m">
                                Male
                            </option>
                            <option value="f">
                                Female
                            </option>
                            <option value="d">
                                Diverse
                            </option>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.gender"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="first_name" value="First Name" required/>
                        <TextInput
                            id="first_name"
                            v-model="form.first_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="given-name"
                        />
                        <InputError class="mt-2" :message="form.errors.first_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="middle_name" value="Middle Name"/>
                        <TextInput
                            id="middle_name"
                            v-model="form.middle_name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="additional-name"
                        />
                        <InputError class="mt-2" :message="form.errors.middle_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="last_name" value="Last Name" required/>
                        <TextInput
                            id="last_name"
                            v-model="form.last_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="family-name"
                        />
                        <InputError class="mt-2" :message="form.errors.last_name"/>
                    </div>

                    <SectionTitle class="col-span-6 md:col-span-6">
                        <template #title>
                            Contact Information
                        </template>
                    </SectionTitle>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="email" value="Email" required/>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autocomplete="email"
                        />
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="phone_number" value="Phone number"/>
                        <TextInput
                            id="phone_number"
                            v-model="form.phone_number"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="phone_number"
                        />
                        <InputError class="mt-2" :message="form.errors.phone_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="function" value="Function"/>
                        <TextInput
                            id="function"
                            v-model="form.function"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="function"
                        />
                        <InputError class="mt-2" :message="form.errors.function"/>
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
