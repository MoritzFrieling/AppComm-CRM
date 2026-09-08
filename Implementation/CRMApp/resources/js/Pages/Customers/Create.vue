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

const form = useForm({
    customer_name: '',
    email: '',
    website: '',
    registration_number: '',
    vat_number: '',
    address_street: '',
    address_house_number: '',
    address_postal_code: '',
    address_city: '',
    address_country: '',
    address_additional_information: '',
});

const submit = () => {
    console.log(form.data())
    form
        // .transform(data => ({
        //     ...data,
        // }))
        .post(route('customers.store'), {});
};
</script>

<template>
    <AppLayout title="Create Customer">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Create Customer</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Create a new Customer
                </template>

                <template #description>
                    Enter all general information about the customer.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="customer_name" value="Name" required/>
                        <TextInput
                            id="customer_name"
                            v-model="form.customer_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.customer_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="registration_number" value="Registration Number" required/>
                        <TextInput
                            id="registration_number"
                            v-model="form.registration_number"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="registration_number"
                        />
                        <InputError class="mt-2" :message="form.errors.registration_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="vat_number" value="VAT Number" required/>
                        <TextInput
                            id="vat_number"
                            v-model="form.vat_number"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="vat_number"
                        />
                        <InputError class="mt-2" :message="form.errors.vat_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="email" value="Email"/>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="website" value="Website"/>
                        <TextInput
                            id="website"
                            v-model="form.website"
                            type="url"
                            class="mt-1 block w-full"
                            autocomplete="website"
                        />
                        <InputError class="mt-2" :message="form.errors.website"/>
                    </div>

                    <SectionTitle class="col-span-6 md:col-span-6">
                        <template #title>
                            Address Information
                        </template>
                    </SectionTitle>

                    <div class="col-span-6 md:col-span-4">
                        <InputLabel for="street" value="Street" required/>
                        <TextInput
                            id="street"
                            v-model="form.address_street"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="street"
                        />
                        <InputError class="mt-2" :message="form.errors.address_street"/>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <InputLabel for="house_number" value="House number" required/>
                        <TextInput
                            id="house_number"
                            v-model="form.address_house_number"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="house_number"
                        />
                        <InputError class="mt-2" :message="form.errors.address_house_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="zip_code" value="Postal Code" required/>
                        <TextInput
                            id="zip_code"
                            v-model="form.address_postal_code"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="postal_code"
                        />
                        <InputError class="mt-2" :message="form.errors.address_postal_code"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="city" value="City" required/>
                        <TextInput
                            id="city"
                            v-model="form.address_city"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="city"
                        />
                        <InputError class="mt-2" :message="form.errors.address_city"/>
                    </div>

                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="country" value="Country" required/>
                        <TextInput
                            id="country"
                            v-model="form.address_country"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="country"
                        />
                        <InputError class="mt-2" :message="form.errors.address_country"/>
                    </div>

                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="additional_information" value="Additional Information"/>
                        <TextInput
                            id="additional_information"
                            v-model="form.address_additional_information"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete=""
                        />
                        <InputError class="mt-2" :message="form.errors.address_additional_information"/>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>
                    <SecondaryButton class="mr-3" :class="{ 'opacity-25': form.processing }"
                                     @click="form.reset; router.get(route('customers.index'))"
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
