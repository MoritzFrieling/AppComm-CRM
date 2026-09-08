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

const props = defineProps({
    customer: Object,
    gitlab_project: Object,
})


const confirmGitlabProjectDeletion = ref(false);


/**
 * Open the modal to confirm the deletion of a customerSolution
 */
const openDeleteModal = () => {
    confirmGitlabProjectDeletion.value = true;
}

/**
 * Close the modal to confirm the deletion of a customerSolution
 */
const closeDeleteModal = () => {
    confirmGitlabProjectDeletion.value = false;
}

/**
 * Delete a customerSolution from the system
 */
const deleteGitlabProject = () => {
    router.delete(route('customers.gitlab_projects.destroy', {
        customer: props.customer.registration_number,
        gitlab_project: props.gitlab_project.gitlab_project_id,
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


            <!--      Delete Section      -->
            <ActionSection>
                <template #title>
                    Delete Gitlab Project
                </template>
                <template #description>
                    Permanently delete the gitlab project
                </template>
                <template #content>
                    <div class="justify-center items-center inline-flex">
                        <div class="text-gray-700 dark:text-gray-300 font-normal leading-tight tracking-tight">
                            Deleting a Gitlab project will remove it from the customer. It won't delete the actual
                            Gitlab project. You can reassign the Gitlab project at any time.
                        </div>
                    </div>

                    <DangerButton class="mt-5" @click="openDeleteModal">
                        Delete Gitlab Project
                    </DangerButton>

                    <DialogModal :show="confirmGitlabProjectDeletion" @close="closeDeleteModal">
                        <template #title>
                            Delete Gitlab Project
                        </template>

                        <template #content>
                            Are you sure you want to delete this Gitlab project? This action cannot be undone!
                        </template>

                        <template #footer>
                            <SecondaryButton @click="closeDeleteModal">
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                class="ml-3"
                                @click="deleteGitlabProject"
                            >
                                Delete Gitlab Project
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
