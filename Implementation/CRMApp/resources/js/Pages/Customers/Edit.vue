<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButtonLink from "@/Components/PrimaryButtonLink.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import TextInput from "@/Components/TextInput.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import {router, useForm} from "@inertiajs/vue3";
import ActionSection from "@/Components/ActionSection.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import {ref} from "vue";

const props = defineProps({
    customer: Object,
})

const update_form = useForm({
    customer_name: props.customer.customer_name,
    email: props.customer.email,
    website: props.customer.website,
    vat_number: props.customer.vat_number,
    address_street: props.customer.address_street,
    address_house_number: props.customer.address_house_number,
    address_postal_code: props.customer.address_postal_code,
    address_city: props.customer.address_city,
    address_country: props.customer.address_country,
    address_additional_information: props.customer.address_additional_information,
});

const confirmCustomerDeactivation = ref(false);
const confirmCustomerDeletion = ref(false);

/**
 * Submit the form to update a customer
 */
const updateCustomer = () => {
    update_form.put(route('customers.update', props.customer.registration_number), {});
};

/**
 * Cancel the update of a customer and redirect back to the customer page
 */
const cancelUpdate = () => {
    router.get(route('customers.show', props.customer.registration_number), {}, {
        replace: true,
    });
}

/**
 * Open the modal to confirm the deactivation of a customer
 */
const openDeactivateModal = () => {
    confirmCustomerDeactivation.value = true;
}

/**
 * Close the modal to confirm the deactivation of a customer
 */
const closeDeactivateModal = () => {
    confirmCustomerDeactivation.value = false;
}

/**
 * Deactivate a customer
 */
const deactivateCustomer = () => {
    router.put(route('customers.active', {registration_number: props.customer.registration_number, active: false}), {});
}

/**
 * Activate a customer
 */
const activateCustomer = () => {
    router.put(route('customers.active', {registration_number: props.customer.registration_number, active: true}), {});
}

/**
 * Open the modal to confirm the deletion of a customer
 */
const openDeleteModal = () => {
    confirmCustomerDeletion.value = true;
}

/**
 * Close the modal to confirm the deletion of a customer
 */
const closeDeleteModal = () => {
    confirmCustomerDeletion.value = false;
}

/**
 * Delete a customer from the system
 */
const deleteCustomer = () => {
    router.delete(route('customers.destroy', props.customer.registration_number), {});
}
</script>

<template>
    <AppLayout title="Update Customer">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Update Customer</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-col gap-10">
            <!--      Update Section      -->
            <FormSection @submitted="updateCustomer">
                <template #title>
                    Update an existing Customer
                </template>

                <template #description>
                    Enter all general information about the customer.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="customer_name" value="Name" required/>
                        <TextInput
                            id="customer_name"
                            v-model="update_form.customer_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.customer_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="registration_number" value="Registration Number" required/>
                        <TextInput
                            id="registration_number"
                            :model-value="customer.registration_number"
                            type="text"
                            class="mt-1 block w-full cursor-not-allowed"
                            autocomplete="registration_number"
                            aria-disabled="true"
                            disabled
                        />
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="vat_number" value="VAT Number" required/>
                        <TextInput
                            id="vat_number"
                            v-model="update_form.vat_number"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="vat_number"
                        />
                        <InputError class="mt-2" :message="update_form.errors.vat_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="email" value="Email"/>
                        <TextInput
                            id="email"
                            v-model="update_form.email"
                            type="email"
                            class="mt-1 block w-full"
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="update_form.errors.email"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="website" value="Website"/>
                        <TextInput
                            id="website"
                            v-model="update_form.website"
                            type="url"
                            class="mt-1 block w-full"
                            autocomplete="website"
                        />
                        <InputError class="mt-2" :message="update_form.errors.website"/>
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
                            v-model="update_form.address_street"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="street"
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_street"/>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <InputLabel for="house_number" value="House number" required/>
                        <TextInput
                            id="house_number"
                            v-model="update_form.address_house_number"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="house_number"
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_house_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="zip_code" value="Postal Code" required/>
                        <TextInput
                            id="zip_code"
                            v-model="update_form.address_postal_code"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="postal_code"
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_postal_code"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="city" value="City" required/>
                        <TextInput
                            id="city"
                            v-model="update_form.address_city"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="city"
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_city"/>
                    </div>

                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="country" value="Country" required/>
                        <TextInput
                            id="country"
                            v-model="update_form.address_country"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="country"
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_country"/>
                    </div>

                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="additional_information" value="Additional Information"/>
                        <TextInput
                            id="additional_information"
                            v-model="update_form.address_additional_information"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete=""
                        />
                        <InputError class="mt-2" :message="update_form.errors.address_additional_information"/>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="update_form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>
                    <SecondaryButton class="mr-3" :class="{ 'opacity-25': update_form.processing }"
                                     :disabled="update_form.processing" @click="cancelUpdate">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': update_form.processing }" :disabled="update_form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
            <!--      (De-)activate Section      -->
            <ActionSection>
                <template #title>
                    (De-)Activate Customer
                </template>
                <template #description>
                    Disable or restore access for the customer
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            When a customer is deactivate they can then no longer login to the system and all
                            information related to inactive customers is only displayed when explicitly searching for
                            them. This action can easily be undone by activating the customer again. No data will be
                            deleted.
                        </div>
                    </div>

                    <DangerButton class="mt-5" v-if="customer.active" @click="openDeactivateModal">
                        Deactivate Customer
                    </DangerButton>
                    <PrimaryButton class="mt-5" v-else @click="openDeactivateModal">
                        Activate Customer
                    </PrimaryButton>

                    <DialogModal :show="confirmCustomerDeactivation" @close="closeDeactivateModal">
                        <template #title v-if="customer.active">
                            Deactivate Customer
                        </template>
                        <template #title v-else>
                            Activate Customer
                        </template>

                        <template #content v-if="customer.active">
                            Are you sure you want to deactivate this customer? When a customer is deactivate they can
                            then no longer login to the system and all information related to inactive customers is only
                            displayed when explicitly searching for them. This action can easily be undone by activating
                            the customer again. No data will be deleted.
                        </template>
                        <template #content v-else>
                            Are you sure you want to reactivate this customer? When a customer is reactivate they can
                            again access the system. This action can easily be undone by deactivating the customer
                            again.
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeactivateModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deactivateCustomer"
                                v-if="customer.active"
                            >
                                Deactivate Customer
                            </DangerButton>
                            <PrimaryButton
                                class="ml-3"
                                @click="activateCustomer"
                                v-else
                            >
                                Activate Customer
                            </PrimaryButton>
                        </template>
                    </DialogModal>
                </template>
            </ActionSection>
            <!--      Delete Section      -->
            <ActionSection>
                <template #title>
                    Delete Customer
                </template>
                <template #description>
                    Permanently delete a customer
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            Deleting a Customer will also remove all projects, services, domain names etc that are
                            related to the customer from the system. Instead of deleting a customer permanently you can
                            also deactivate them removing their access to the system while keeping all data.
                        </div>
                    </div>

                    <DangerButton class="mt-5" @click="openDeleteModal">
                        Delete Customer
                    </DangerButton>

                    <DialogModal :show="confirmCustomerDeletion" @close="closeDeleteModal">
                        <template #title>
                            Delete Customer
                        </template>

                        <template #content>
                            Are you sure you want to delete this customer? This action cannot be undone! Deleting a
                            Customer will also remove all projects, services, domain names etc that are related to the
                            customer from the system. Instead of deleting a customer permanently you can also deactivate
                            them removing their access to the system while keeping all data.
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeleteModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deleteCustomer"
                            >
                                Delete Customer
                            </DangerButton>
                        </template>
                    </DialogModal>
                </template>
            </ActionSection>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
