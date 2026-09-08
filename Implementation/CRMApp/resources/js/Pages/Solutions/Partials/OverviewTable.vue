<script lang="ts" setup>
import {Link, router} from '@inertiajs/vue3';
import {FilterType} from "@/Pages/Customers/Partials/FilterType";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";

const filterOperators = {
    text: ['=', '!=', 'like', 'not like', 'ilike', 'not ilike'],
    boolean: ['=', '!='],
}

const props = defineProps<{
    solutions: any[]
    pagination: any
    search: string
    filterTypes: FilterType[]
    filters: {
        value: string
        type: FilterType
        operator: string
    }[]
}>()


const emits = defineEmits<{
    (event: 'update:search', value: string): true
    (event: 'update:filters', value: FilterType[]): true
}>()

function addFilter() {
    emits('update:filters', [...props.filters, {
        value: '',
    }])
}
</script>

<template>
    <div class="rounded-md bg-white dark:bg-gray-800 shadow">
        <!--        Action Header -->
        <div class="bg-white dark:bg-gray-800 relative">
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="text" id="simple-search" :value="search"
                                   @input="$emit('update:search', $event.target.value)"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Search" required="">
                        </div>
                    </form>
                </div>
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <Dropdown width="96">
                            <template #trigger>
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                        class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                        type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                         class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Filter
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <div id="filterDropdown" class="p-3">
                                    <h6 class="mb-3 text-lg font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Choose Filters</h6>
                                    <div class="flex flex-col gap-2">
                                        <div v-for="(filter, filterIndex) in filters" class="flex items-start gap-2">
                                            <Select class="w-40" v-model="filter.typeI"
                                                    @input="e => filter.type = filterTypes[filter.typeI]">
                                                <option v-for="(filterType, index) in filterTypes"
                                                        :key="index"
                                                        :value="index">
                                                    {{ filterType.label }}
                                                </option>
                                            </Select>
                                            <Select class="w-40" v-if="filter.type" placeholder="Operator"
                                                    v-model="filter.operator">
                                                <option v-for="operator in filterOperators[filter.type.type]"
                                                        :key="operator"
                                                        :value="operator">
                                                    {{ operator }}
                                                </option>
                                            </Select>
                                            <TextInput class="w-40" v-if="filter.type" v-model="filter.value"
                                                       placeholder="Value"/>
                                            <SecondaryButton class="self-stretch ml-auto"
                                                             @click="filters.splice(filterIndex, 1)">
                                                Remove
                                            </SecondaryButton>
                                        </div>
                                        <div>
                                            <PrimaryButton @click="addFilter">
                                                Add Filter
                                            </PrimaryButton>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
        <!--        Table -->
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Title
                            <a href="#">
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Number
                            <a href="#">
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Category
                            <a href="#">
                                <svg class="w-3 h-3 ml-1.5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(solution, index) in solutions" :key="solution.number"
                    class="dark:border-gray-700 hover:bg-gray-200 hover:dark:bg-gray-600 hover:cursor-pointer"
                    :class="{'bg-gray-100 dark:bg-gray-700': index % 2 === 1}"
                    @click="router.get(route('solutions.show', solution.number))">
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ solution.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ solution.number }}
                    </td>
                    <td class="px-6 py-4">
                        {{ solution.category }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--        Footer and Pagination -->
        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
             aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span
                        class="font-semibold text-gray-900 dark:text-white">{{ pagination.from }}-{{
                            pagination.to
                        }}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</span>
                </span>
            <ul class="inline-flex items-stretch -space-x-px">
                <li v-for="(link, index) in pagination.links">
                    <Link :href="link.url"
                          :class="{'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white text-gray-500': link.url !== null, 'cursor-not-allowed text-gray-400': link.url === null, 'rounded-l-lg': index === 0, 'rounded-r-lg': index === pagination.links.length - 1}"
                          class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span v-html="link.label"></span>
                    </Link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style scoped>

</style>
