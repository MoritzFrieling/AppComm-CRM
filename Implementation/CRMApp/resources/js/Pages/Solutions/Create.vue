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
import TextArea from "@/Components/TextArea.vue";

const form = useForm({
    one_time_payment: false,
    title: '',
    number: null,
    category: '',
    price_per_unit: 0.00,
    units: 0.00,
    vat_rate: 0.00,
    recurring_period: '',
    recurring_period_unit: '',
    description: '',
});

const submit = () => {

    form.recurring_period = form.one_time_payment===true ? "" : form.recurring_period;
    form.recurring_period_unit = form.one_time_payment===true ? "" : form.recurring_period_unit;
    delete form.one_time_payment;

    console.log(form.data())
    form.post(route('solutions.store'), {});

};
</script>

<template>
    <AppLayout title="Create Solution">
        <template #header>
            <h2>
                <span
                    class="text-gray-800 dark:text-gray-200 text-xl font-semibold leading-[25px]">Solution Overview</span>
                <span
                    class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-[25px]"> / Create Solution</span>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Create a new solution
                </template>

                <template #description>
                    Enter all general information about the solution.
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
                            autofocus
                            autocomplete="title"
                        />
                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="number" value="Number" required/>
                        <TextInput
                            id="number"
                            v-model="form.number"
                            type="number"
                            class="mt-1 block w-full"
                            required
                            autocomplete="number"
                            min="0"
                        />
                        <InputError class="mt-2" :message="form.errors.number"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                        <InputLabel for="category" value="Category" required/>
                        <TextInput
                            id="category"
                            v-model="form.category"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="category"
                        />
                        <InputError class="mt-2" :message="form.errors.category"/>
                    </div>

                    <div class="col-span-6 md:col-span-3">
                            <InputLabel for="price_per_unit" value="Price (per unit)" required/>
                            <TextInput
                                id="price_per_unit"
                                v-model="form.price_per_unit"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="price_per_unit"
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
                            <InputLabel for="vat_rate" value="VAT Rate" required/>
                            <TextInput
                                id="vat_rate"
                                v-model="form.vat_rate"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="vat_rate"
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

                        <InputLabel for="recurring_period" value="Recurring Period" required/>
                        <TextInput
                            id="recurring_period"
                            v-model="form.recurring_period"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                        />
                        <InputError class="mt-2" :message="form.errors.recurring_period"/>
                    </div>

                    <div class="col-span-6 md:col-span-3"  v-if="form.one_time_payment===false">
                        <InputLabel for="recurring_period_unit" value="Recurring Period Unit" required/>
                        <TextInput
                            id="recurring_period_unit"
                            v-model="form.recurring_period_unit"
                            type="text"
                            class="mt-1 block w-full"
                            :required="form.one_time_payment===false"
                        />
                        <InputError class="mt-2" :message="form.errors.recurring_period_unit"/>
                    </div>

                    <div class="col-span-6 md:col-span-6" style="height: 200px">
                        <InputLabel for="description" value="Description"/>
                        <TextArea
                            id="description"
                            v-model="form.description"
                            type="text"
                            class="mt-1 block w-full"
                            required
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
                                     @click="form.reset; router.get(route('solutions.index'))"
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
