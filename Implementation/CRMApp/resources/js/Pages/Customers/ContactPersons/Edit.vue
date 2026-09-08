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
import Select from "@/Components/Select.vue";

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    contact_person: Object,
})

/**
 * InertiaForm with values pre set according to the actual contact_person
 * @type {InertiaForm<{gender: (string|*), function: (string|*), last_name: (string|*), phone_number: (string|*), middle_name: (string|*), first_name: (string|*), email}>}
 */
const update_form = useForm({
    'gender': props.contact_person.gender,
    'first_name': props.contact_person.first_name,
    'middle_name': props.contact_person.middle_name,
    'last_name': props.contact_person.last_name,
    'email': props.contact_person.email,
    'phone_number': props.contact_person.phone_number,
    'function': props.contact_person.function,
});

const confirmContactPersonDeletion = ref(false);

/**
 * Submit the form to update a customer
 */
const updateContactPerson = () => {
    update_form.put(route('customers.contact_persons.update', {
        customer: props.contact_person.customer.registration_number,
        contact_person: props.contact_person.id
    }), {});
};

/**
 * Cancel the update of a contact person and redirect back to the contact person page
 */
const cancelUpdate = () => {
    router.get(route('customers.contact_persons.show', {
        customer: props.contact_person.customer.registration_number,
        contact_person: props.contact_person.id
    }), {}, {
        replace: true,
    });
}

/**
 * Open the modal to confirm the deletion of a contact person
 */
const openDeleteModal = () => {
    confirmContactPersonDeletion.value = true;
}

/**
 * Close the modal to confirm the deletion of a contact person
 */
const closeDeleteModal = () => {
    confirmContactPersonDeletion.value = false;
}

/**
 * Delete a contact person from the system
 */
const deleteContactPerson = () => {
    router.delete(route('customers.contact_persons.destroy', {
        customer: props.contact_person.customer.registration_number,
        contact_person: props.contact_person.id
    }), {});
}
</script>

<template>
    <AppLayout title="Update Contact Person">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / {{ contact_person.customer.customer_name }} / Update Contact Person</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-col gap-10">
            <!--      Update Section      -->
            <FormSection @submitted="updateContactPerson">
                <template #title>
                    Update an existing Contact Person for Customer {{ contact_person.customer.customer_name }}
                </template>

                <template #description>
                    Enter all general information about the Contact Person.
                </template>

                <template #form>
                    <div class="col-span-6 md:col-span-2 ">
                        <InputLabel for="gender" value="Gender" required/>
                        <Select
                            id="gender"
                            v-model="update_form.gender"
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
                        <InputError class="mt-2" :message="update_form.errors.gender"/>
                    </div>

                    <div class="col-span-6 md:col-span-2 md:col-start-1">
                        <InputLabel for="first_name" value="First Name" required/>
                        <TextInput
                            id="first_name"
                            v-model="update_form.first_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="given-name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.first_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <InputLabel for="middle_name" value="Middle Name"/>
                        <TextInput
                            id="middle_name"
                            v-model="update_form.middle_name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="additional-name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.middle_name"/>
                    </div>

                    <div class="col-span-6 md:col-span-2">
                        <InputLabel for="last_name" value="Last Name" required/>
                        <TextInput
                            id="last_name"
                            v-model="update_form.last_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="family-name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.last_name"/>
                    </div>

                    <SectionTitle class="col-span-6 md:col-span-6">
                        <template #title>
                            Address Information
                        </template>
                    </SectionTitle>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="email" value="Email" required/>
                        <TextInput
                            id="email"
                            v-model="update_form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autocomplete="email"
                        />
                        <InputError class="mt-2" :message="update_form.errors.email"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="phone_number" value="Phone number"/>
                        <TextInput
                            id="phone_number"
                            v-model="update_form.phone_number"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="phone_number"
                        />
                        <InputError class="mt-2" :message="update_form.errors.phone_number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="function" value="Function"/>
                        <TextInput
                            id="function"
                            v-model="update_form.function"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="function"
                        />
                        <InputError class="mt-2" :message="update_form.errors.function"/>
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

            <!--      Delete Section      -->
            <ActionSection>
                <template #title>
                    Delete Contact Person
                </template>
                <template #description>
                    Permanently delete a contact person
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            Deleting a Contact Person permanently removes it from the system and cannot be undone.
                            However no other data will be affected.
                        </div>
                    </div>

                    <DangerButton class="mt-5" @click="openDeleteModal">
                        Delete Contact Person
                    </DangerButton>

                    <DialogModal :show="confirmContactPersonDeletion" @close="closeDeleteModal">
                        <template #title>
                            Delete Contact Person
                        </template>

                        <template #content>
                            Are you sure you want to delete this Contact Person? This action cannot be undone!
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeleteModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deleteContactPerson"
                            >
                                Delete Contact Person
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
