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
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    solution: Object,
})

const update_form = useForm({
    title: props.solution.title,
    category: props.solution.category,
    price_per_unit: props.solution.price_per_unit,
    units: props.solution.units,
    vat_rate: props.solution.vat_rate,
    one_time_payment: props.solution.recurring_period === null &&
        props.solution.recurring_period_unit === null,
    recurring_period: props.solution.recurring_period,
    recurring_period_unit: props.solution.recurring_period_unit,
    description: props.solution.description,
});

//const confirmSolutionDeactivation = ref(false);
const confirmSolutionDeletion = ref(false);

/**
 * Submit the form to update a solution
 */
const updateSolution = () => {
    update_form.recurring_period = update_form.one_time_payment===true ? "" : update_form.recurring_period;
    update_form.recurring_period_unit = update_form.one_time_payment===true ? "" : update_form.recurring_period_unit;
    update_form.put(route('solutions.update', props.solution.number), {});
};

/**
 * Cancel the update of a solution and redirect back to the solution page
 */
const cancelUpdate = () => {
    router.get(route('solutions.show', props.solution.number), {}, {
        replace: true,
    });
}

/**
 * Open the modal to confirm the deactivation of a solution
 */
/*const openDeactivateModal = () => {
    confirmSolutionDeactivation.value = true;
}*/

/**
 * Close the modal to confirm the deactivation of a solution
 */
/*const closeDeactivateModal = () => {
    confirmSolutionDeletion.value = false;
}*/

/**
 * Deactivate a customer
 */
/*const deactivateSolution = () => {
    router.put(route('solutions.active', {solution_number: props.solution.solution_number, active: false}), {});
}*/

/**
 * Activate a customer
 */
/*const activateSolution = () => {
    router.put(route('solutions.active', {solution_number: props.solution.solution_number, active: true}), {});
}*/

/**
 * Open the modal to confirm the deletion of a customer
 */
const openDeleteModal = () => {
    confirmSolutionDeletion.value = true;
}

/**
 * Close the modal to confirm the deletion of a solution
 */
const closeDeleteModal = () => {
    confirmSolutionDeletion.value = false;
}

/**
 * Delete a customer from the system
 */
const deleteSolution = () => {
    router.delete(route('solutions.destroy', props.solution.number), {});
}
</script>

<template>
    <AppLayout title="Update Solution">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Solution Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Update Solution</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex flex-col gap-10">
            <!--      Update Section      -->
            <FormSection @submitted="updateSolution">
                <template #title>
                    Update an existing solution
                </template>

                <template #description>
                    Enter all general information about the solution.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="title" value="Title" required/>
                        <TextInput
                            id="title"
                            v-model="update_form.title"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="title"
                        />
                        <InputError class="mt-2" :message="update_form.errors.title"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="number" value="Number" required/>
                        <TextInput
                            id="number"
                            :model-value="solution.number"
                            type="number"
                            class="mt-1 block w-full cursor-not-allowed"
                            autocomplete="number"
                            aria-disabled="true"
                            disabled
                        />
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="category" value="Category" required/>
                        <TextInput
                            id="category"
                            v-model="update_form.category"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="category"
                        />
                        <InputError class="mt-2" :message="update_form.errors.category"/>
                    </div>

                    <div class="col-span-3">
                        <InputLabel for="price_per_unit" value="Price (per unit)" required/>
                        <TextInput
                            id="price_per_unit"
                            v-model="update_form.price_per_unit"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="price_per_unit"
                        />
                        <InputError class="mt-2" :message="update_form.errors.price"/>
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

                    <div class="col-span-6 md:col-span-3" >
                        <InputLabel for="vat_rate" value="Vat rate" required/>
                        <TextInput
                            id="vat_rate"
                            v-model="update_form.vat_rate"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="vat_rate"
                        />
                        <InputError class="mt-2" :message="update_form.errors.vat_rate"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" >
                        <InputLabel for="one_time_payment" value="One-Time-Payment"/>
                        <Checkbox
                            id="one_time_payment"
                            v-model:checked="update_form.one_time_payment"
                            type="checkbox"
                        />
                        <InputError class="mt-2" :message="update_form.errors.one_time_payment"/>
                    </div>

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

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="description" value="Description"/>
                        <TextInput
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
                    Delete Solution
                </template>
                <template #description>
                    Permanently delete a solution
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            Deleting a solution is only possible if not assigned to any customers.
                            This action is permanent, it can't be undone! <br>
                        </div>
                    </div>

                    <DangerButton class="mt-5" @click="openDeleteModal">
                        Delete Solution
                    </DangerButton>

                    <DialogModal :show="confirmSolutionDeletion" @close="closeDeleteModal">
                        <template #title>
                            Delete Solution
                        </template>

                        <template #content>
                            Are you sure you want to delete this solution? This action cannot be undone!
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeleteModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deleteSolution"
                            >
                                Delete Solution
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
