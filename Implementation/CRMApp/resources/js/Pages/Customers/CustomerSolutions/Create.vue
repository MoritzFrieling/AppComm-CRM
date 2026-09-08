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

/**
 * Properties Required to render all required information
 */
const props = defineProps({
    customer: Object,
    solutions: Array
})

/**
 * InertiaForm with default values set to empty
 * @type {InertiaForm<{recurring_period: string, end_date: string, recurring_period_unit: string, description: string, units: string, price_per_unit: string, solution_id: string, one_time_payment: boolean, vat_rate: string, start_date: string}>}
 */
const form = useForm({
    'one_time_payment': false,
    'solution_id': '',
    'price_per_unit': '',
    'units': '',
    'vat_rate': '',
    'recurring_period': '',
    'recurring_period_unit': '',
    'start_date': '',
    'end_date': '',
    'description': ''
});

/**
 * Function to submit the form and perform data transformation for the payment model
 */
const submit = () => {
    form.recurring_period = form.one_time_payment===true ? "" : form.recurring_period;
    form.recurring_period_unit = form.one_time_payment===true ? "" : form.recurring_period_unit;
    form.start_date = form.one_time_payment===true ? "" : form.start_date;
    form.end_date = form.one_time_payment===true ? "" : form.end_date;
    delete form.one_time_payment;

    console.log(form.data())
    form.post(route('customers.solutions.store', {customer: props.customer.registration_number}), {});
};

const onSelectSolution = (event) => {
    const selected_solution = props.solutions.find(solution => solution.id == form.solution_id);
    form.one_time_payment = selected_solution.recurring_period == null
    form.price_per_unit = selected_solution.price_per_unit;
    form.units = selected_solution.units;
    form.vat_rate = selected_solution.vat_rate;
    form.recurring_period = selected_solution.recurring_period == null ? '' : selected_solution.recurring_period
    form.recurring_period_unit = selected_solution.recurring_period_unit == null ? '' : selected_solution.recurring_period_unit
}
</script>

<template>
    <AppLayout title="Create Customer">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Customer Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Assign Solution</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Assign a Solution to Customer {{ customer.customer_name }}
                </template>

                <template #description>
                    Enter the details of the Solution
                </template>

                <template #form>
                    <div class="col-span-6 md:col-span-6">
                        <InputLabel for="solution_id" value="Solution" required/>
                        <Select
                            id="solution"
                            v-model="form.solution_id"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            @change="onSelectSolution($event)"

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
                            v-model="form.price_per_unit"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.price_per_unit"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="units" value="Units" required/>
                        <TextInput
                            id="units"
                            v-model="form.units"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="additional-name"
                        />
                        <InputError class="mt-2" :message="form.errors.units"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="vat_rate" value="VAT-Rate" required/>
                        <TextInput
                            id="vat_rate"
                            v-model="form.vat_rate"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="family-name"
                        />
                        <InputError class="mt-2" :message="form.errors.vat_rate"/>
                    </div>

                    <br>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="one_time_payment" value="One-Time-Payment" />
                        <Checkbox
                            id="one_time_payment"
                            v-model:checked="form.one_time_payment"
                            type="checkbox"
                        />
                        <InputError class="mt-2" :message="form.errors.one_time_payment"/>
                    </div>

                    <br>

                    <div class="col-span-6 md:col-span-3" v-if="form.one_time_payment===false">
                        <InputLabel for="recurring_period" value="Recurring Period" :required="form.one_time_payment===false"/>
                        <TextInput
                            id="recurring_period"
                            v-model="form.recurring_period"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                            :disabled="form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="form.errors.recurring_period"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="form.one_time_payment===false">
                        <InputLabel for="recurring_period_unit" value="Recurring Period Unit" :required="form.one_time_payment===false"/>
                        <TextInput
                            id="recurring_period_unit"
                            v-model="form.recurring_period_unit"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                            :disabled="form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="form.errors.recurring_period_unit"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="form.one_time_payment===false">
                        <InputLabel for="start_date" value="Start Date" :required="form.one_time_payment===false"/>
                        <TextInput
                            id="start_date"
                            v-model="form.start_date"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                            :disabled="form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="form.errors.start_date"/>
                    </div>

                    <div class="col-span-6 md:col-span-3" v-if="form.one_time_payment===false">
                        <InputLabel for="end_date" value="End Date" :required="form.one_time_payment===false"/>
                        <TextInput
                            id="end_date"
                            v-model="form.end_date"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                            :disabled="form.one_time_payment===true"
                        />
                        <InputError class="mt-2" :message="form.errors.end_date"/>
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
                            v-model="form.description"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="description"
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
