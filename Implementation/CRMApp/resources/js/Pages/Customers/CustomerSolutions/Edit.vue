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
import TextArea from "@/Components/TextArea.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Select from "@/Components/Select.vue";

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    customer: Object,
    solutions: Array,
    customer_solution: Object,
})

/**
 * InertiaForm with values pre set according to the actual customer_solution
 * @type {InertiaForm<{recurring_period: string, end_date: string, recurring_period_unit: string, description: string, units: string, price_per_unit: string, solution_id: string, one_time_payment: boolean, vat_rate: string, start_date: string}>}
 */
const update_form = useForm({
    'solution_id': props.customer_solution.solution_id,
    'price_per_unit': props.customer_solution.price_per_unit,
    'units': props.customer_solution.units,
    'vat_rate': props.customer_solution.vat_rate,
    'one_time_payment': props.customer_solution.recurring_period === null &&
        props.customer_solution.recurring_period_unit === null &&
        props.customer_solution.end_date === null ,
    'recurring_period': props.customer_solution.recurring_period,
    'recurring_period_unit': props.customer_solution.recurring_period_unit,
    'start_date': props.customer_solution.start_date,
    'end_date': props.customer_solution.end_date,
    'description': props.customer_solution.description,
});

const confirmCustomerSolutionDeletion = ref(false);

/**
 * Submit the form to update a customerSolution
 */
const updateCustomerSolution = () => {
    update_form.recurring_period = update_form.one_time_payment===true ? "" : update_form.recurring_period;
    update_form.recurring_period_unit = update_form.one_time_payment===true ? "" : update_form.recurring_period_unit;
    update_form.start_date = update_form.one_time_payment===true ? "" : update_form.start_date;
    update_form.end_date = update_form.one_time_payment===true ? "" : update_form.end_date;
    delete update_form.one_time_payment;
    console.log("attempting to save'")
    update_form.put(route('customers.solutions.update', {
        customer: props.customer.registration_number,
        solution: props.customer_solution.id
    }), {});
};

/**
 * Cancel the update of a customerSolution and redirect back to the customer page
 */
const cancelUpdate = () => {
    router.get(route('customers.solutions.show', {
        customer: props.customer.registration_number,
        solution: props.customer_solution.id
    }), {}, {
        replace: true,
    });
}


/**
 * Open the modal to confirm the deletion of a customerSolution
 */
const openDeleteModal = () => {
    confirmCustomerSolutionDeletion.value = true;
}

/**
 * Close the modal to confirm the deletion of a customerSolution
 */
const closeDeleteModal = () => {
    confirmCustomerSolutionDeletion.value = false;
}

/**
 * Delete a customerSolution from the system
 */
const deleteCustomerSolution = () => {
    router.delete(route('customers.solutions.destroy', {
        customer: props.customer.registration_number,
        solution: props.customer_solution.id
    }), {});
}
</script>

<template>
    <AppLayout title="Update Customers Solution">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Update Customers Solution</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-col gap-10">
            <!--      Update Section      -->
            <FormSection @submitted="updateCustomerSolution">
                <template #title>
                    Update {{customer.customer_name}}'s Solution
                </template>

                <template #description>
                    Enter the details of the Solution
                </template>

                <template #form>
                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="solution_id" value="Solution" required/>
                        <Select
                            id="solution"
                            v-model="update_form.solution_id"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="sex"
                        >
                            <option v-for="solution in solutions" :value="solution.id">
                                {{solution.title}}
                            </option>
                        </Select>
                    </div>

                    <SectionTitle class="col-span-6 md:col-span-6">
                        <template #title>
                            Billing Information
                        </template>
                    </SectionTitle>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="price_per_unit" value="Price (per Unit)" required/>
                        <TextInput
                            id="price_per_unit"
                            v-model="update_form.price_per_unit"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="update_form.errors.price_per_unit"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="units" value="Units" required/>
                        <TextInput
                            id="units"
                            v-model="update_form.units"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="additional-name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.units"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="vat_rate" value="VAT-Rate" required/>
                        <TextInput
                            id="vat_rate"
                            v-model="update_form.vat_rate"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="family-name"
                        />
                        <InputError class="mt-2" :message="update_form.errors.vat_rate"/>
                    </div>

                    <br>

                    <div class="col-span-6 md:col-span-3" >
                        <InputLabel for="one_time_payment" value="One-Time-Payment"/>
                        <Checkbox
                            id="one_time_payment"
                            v-model:checked="update_form.one_time_payment"
                            type="checkbox"
                        />
                        <InputError class="mt-2" :message="update_form.errors.one_time_payment"/>
                    </div>

                    <br>

                    <div class="col-span-6 md:col-span-3" v-if="update_form.one_time_payment===false">
                        <InputLabel for="recurring_period" value="Recurring Period" :required="update_form.one_time_payment===false"/>
                        <TextInput
                            id="recurring_period"
                            v-model="update_form.recurring_period"
                            type="text"
                            class="mt-1 block w-full"
                            :required="update_form.one_time_payment===false"
                            :disabled="update_form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="update_form.errors.recurring_period"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="update_form.one_time_payment===false">
                        <InputLabel for="recurring_period_unit" value="Recurring Period Unit" :required="update_form.one_time_payment===false"/>
                        <TextInput
                            id="recurring_period_unit"
                            v-model="update_form.recurring_period_unit"
                            type="text"
                            class="mt-1 block w-full"
                            :required="update_form.one_time_payment===false"
                            :disabled="update_form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="update_form.errors.recurring_period_unit"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="update_form.one_time_payment===false">
                        <InputLabel for="start_date" value="Start Date" :required="update_form.one_time_payment===false"/>
                        <TextInput
                            id="start_date"
                            v-model="update_form.start_date"
                            type="text"
                            class="mt-1 block w-full"
                            :required="update_form.one_time_payment===false"
                            :disabled="update_form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="update_form.errors.start_date"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="update_form.one_time_payment===false">
                        <InputLabel for="end_date" value="End Date" :required="update_form.one_time_payment===false"/>
                        <TextInput
                            id="end_date"
                            v-model="update_form.end_date"
                            type="text"
                            class="mt-1 block w-full"
                            :required="update_form.one_time_payment===false"
                            :disabled="update_form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="update_form.errors.end_date"/>
                    </div>



                    <SectionTitle class="col-span-6 md:col-span-6">
                        <template #title>
                            Additional Information
                        </template>
                    </SectionTitle>

                    <div class="col-span-6 md:col-span-6" style="height: 200px">
                        <InputLabel for="description" value="Description"/>
                        <TextArea
                            id="description"
                            v-model="update_form.description"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="description"
                        />
                        <InputError class="mt-2" :message="update_form.errors.description"/>
                    </div>

                </template>

                <template #actions>
                    <ActionMessage :on="update_form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>
                    <SecondaryButton class="mr-3" :class="{ 'opacity-25': update_form.processing }"
                                     :disabled="update_form.processing" @click="cancelUpdate">
                        Abort
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': update_form.processing }" :disabled="update_form.processing">
                        Update Customers Solution
                    </PrimaryButton>
                </template>
            </FormSection>

            <!--      Delete Section      -->
            <ActionSection>
                <template #title>
                    Delete Customers Solution
                </template>
                <template #description>
                    Permanently delete the customers solution
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            Deleting a Customers Solution will permanently remove the relationship between this customer
                            and the solution, and the attributes linked to this relationship. It will not remove the Solution itself.
                        </div>
                    </div>

                    <DangerButton class="mt-5" @click="openDeleteModal">
                        Delete Customers Solution
                    </DangerButton>

                    <DialogModal :show="confirmCustomerSolutionDeletion" @close="closeDeleteModal">
                        <template #title>
                            Delete Customers Solution
                        </template>

                        <template #content>
                            Are you sure you want to delete this customers Solution? This action cannot be undone!
                            Deleting a Customers Solution will permanently remove the relationship between this customer
                            and the solution, and the attributes linked to this relationship. It will not remove the Solution itself.
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeleteModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deleteCustomerSolution"
                            >
                                Delete Customers Solution
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
