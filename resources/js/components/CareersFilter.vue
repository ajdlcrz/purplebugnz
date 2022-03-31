<template>
    <div class="career-filters">
        <input
            class="job-search"
            type="text"
            placeholder="Search for job title or position"
            v-model="$parent.filter"
            @keyup.enter="$parent.searchData"
        />

        <div class="dropdown">
            <button
                class="btn btn-link dropdown-toggle job-filter"
                type="button"
                id="filterMenu"
                data-toggle="dropdown"
            >
                <span>Sort By</span>
            </button>

            <div
                class="dropdown-menu dropdown-menu-right"
                aria-labelledby="filterMenu"
            >
                <button
                    :class="`dropdown-item d-flex justify-content-between ${
                        $parent.column == 'title' ? 'active' : ''
                    }`"
                    type="button"
                    @click="$parent.filterData('title')"
                >
                    Title
                    <span class="ml-3" v-if="$parent.column == 'title'">{{
                        sortIcon
                    }}</span>
                </button>

                <button
                    :class="`dropdown-item d-flex justify-content-between ${
                        $parent.column == 'department' ? 'active' : ''
                    }`"
                    type="button"
                    @click="$parent.filterData('department')"
                >
                    Department
                    <span class="ml-3" v-if="$parent.column == 'department'">{{
                        sortIcon
                    }}</span>
                </button>

                <button
                    :class="`dropdown-item d-flex justify-content-between ${
                        $parent.column == 'experience' ? 'active' : ''
                    }`"
                    type="button"
                    @click="$parent.filterData('experience')"
                >
                    Experience
                    <span class="ml-3" v-if="$parent.column == 'experience'">{{
                        sortIcon
                    }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            //
        };
    },

    computed: {
        sortIcon() {
            return this.$parent.order == "asc" ? "⤵" : "⤴";
        },
    },
};
</script>

<style scoped>
/*  */
</style>