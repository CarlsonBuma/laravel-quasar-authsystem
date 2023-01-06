<style scoped>
.search-width {
    width: 270px;
}
</style>

<template>

    <PageWrapper title="Businessbox" subtitle="Finden Sie ihren Partner.">

        <!-- Overview -->
        <template #actions>
            <q-btn flat round color="red" icon="favorite" class="q-pa-sm">
                {{ reviews }}
                <q-tooltip class="bg-indigo">
                    Reviews
                </q-tooltip>
            </q-btn>
            <q-btn flat round color="teal" icon="bookmark" class="q-pa-sm">
                {{ ops }}
                <q-tooltip class="bg-indigo">
                    Operational Specialists
                </q-tooltip>
            </q-btn>
            <q-btn flat round color="primary" icon="share" class="q-pa-sm">
                {{ partners }}
                <q-tooltip class="bg-indigo">
                    Active Entities
                </q-tooltip>
            </q-btn>
        </template>

        <!-- Services --> 
        <div class="w-100 q-pl-sm q-pr-sm">
            <q-table
                title="Businessbox"
                row-key="key"
                :rows="rows"
                :columns="columns"
                :pagination="pagination"
                :loading="loading"
                :filter="searchFilter"
                no-data-label="May the first be you!"
            >
                <!-- Filters -->
                <template v-slot:top-right>
                    <!-- Search -->
                    <q-input 
                        v-model="searchFilter"
                        dense 
                        class="search-width"
                        debounce="300" 
                        placeholder="Search"
                    >
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </template>

                <!-- Custom: Cols -->
                <template v-slot:header="props">
                    <q-tr :props="props">
                        <!-- Expand -->
                        <q-th auto-width />
                        <!-- Default -->
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            <!-- Custom here -->
                            <q-icon
                                v-if="col.name === 'reviews'" 
                                name="favorite" 
                                color="red" 
                                size="1.5em" 
                            />
                            <span 
                                v-else
                                :class="{
                                    'text-teal': col.name === 'ops'
                                }"
                            >
                                {{ col.label }}    
                            </span>
                        </q-th>
                    </q-tr>
                </template>

                <!-- Filters -->
                <template v-slot:top-row="props">
                    <q-tr :props="props">
                        <q-td />
                        <q-td
                            v-for="col in props.cols"
                            :key="col.name"
                        >
                            {{test(col, props)}}
                            {{col.filter}}
                        </q-td>
                    </q-tr>
                </template>

                <!-- Custom: RowCells -->
                <template v-slot:body="props">
                    <!-- Data -->
                    <q-tr :props="props">
                        <!-- Expand -->
                        <q-td auto-width>
                            <q-btn 
                                size="xs" 
                                :color="props.row.available ? 'primary' : 'red'" 
                                round 
                                dense 
                                @click="props.expand = !props.expand" 
                                :icon="props.expand ? 'remove' : 'add'"
                                :disable="!props.row.available" 
                            />
                        </q-td>
                        <!-- Default -->
                        <q-td
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            <!-- Custom here -->
                            <!-- Businessline -->
                            <div v-if="col.name === 'line'">
                                <q-badge :label="col.value" color="orange" />
                            </div>
                            <!-- Skills -->
                            <div
                                v-else-if="col.name === 'skills'" 
                                class="row"
                            >
                                <div 
                                    v-for="(tag, index) in col.value"
                                    :key="index"
                                >
                                    <q-badge 
                                        color="purple" 
                                        :label="tag.label"
                                        class="q-ma-xs"
                                    />
                                </div>
                            </div>
                            <!-- Default -->
                            <span v-else>{{ col.value }}</span>
                        </q-td>
                    </q-tr>

                    <!-- Expanded Area -->
                    <q-tr v-show="props.expand" :props="props">
                        <q-td colspan="100%">
                            <div class="text-left">This is expand slot for row above: {{ props.row.name }}.</div>
                        </q-td>
                    </q-tr>
                </template>
            </q-table>
        </div>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { date } from 'quasar';
import { teamsAPI } from 'src/apis/visitor.js';
import PageWrapper from 'components/PageWrapper.vue';

export default {
    name: 'AgileTeams',
    components: {
        PageWrapper
    },
    setup () {
        const pagination = {
            // sortBy: 'desc',
            // descending: false,
            // page: 2,
            rowsPerPage: 25
            // rowsNumber: xx if getting data from a server
        };

        // Table Columns
        const textBreakClass = 'word-break: break-all; overflow: auto;white-space: pre-wrap;';
        const rows = teamsAPI();
        const columns = [
            { 
                name: 'line',  
                label: 'Line', 
                align: 'left',
                field: 'line',
                sortable: true,
                filter: 'option'          // Filter Types: text, number, tags, option, range, date
            },
            { 
                name: 'skills',  
                label: 'Skillset',
                align: 'left', 
                style: 'width: 20vw; min-width: 240px;' + textBreakClass,
                field: 'skills',
                filter: 'tags'
            },
            { 
                name: 'about',  
                label: 'About',
                style: 'min-width: 380px;' + textBreakClass,
                align: 'left',
                field: 'about',
                format: val => `${val}`, 
                filter: 'text'
            },
            { 
                name: 'available', 
                label: 'Available',
                align: 'left', 
                field: 'available', 
                format: val => {
                    const currentDate = date.formatDate(new Date(), 'YYYY-MM-DD');
                    const availableDate = date.formatDate(val, 'YYYY-MM-DD')
                    console.log(currentDate < availableDate)
                    return (date.getDateDiff(currentDate, availableDate, 'days'))// ? '' : date.formatDate(val, 'DD-MM-YYYY');
                },
                sortable: true, 
                filter: 'date'
            },
            { 
                name: 'name',  
                label: 'Entity', 
                align: 'left',
                field: 'name',
                format: val => `${val}`,
                sortable: true,
                filter: 'text'          // Filter Types: text, number, tags, option, range, date
            },
            { 
                name: 'ops', 
                label: 'Ops.',
                align: 'center', 
                field: 'ops', 
                sortable: true, 
                sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
                filter: 'number'
            },
            // { 
            //     name: 'pricerange', 
            //     label: 'Pricerange',
            //     align: 'left', 
            //     field: 'pricerange',
            //     sortable: true, 
            //     sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
            //     filter: 'range'
            // },
            { 
                name: 'reviews', 
                label: 'Reviews',
                align: 'center', 
                field: 'reviews', 
                sortable: true, 
                sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
                filter: 'number'
            },
        ];
        
        return {
            reviews: ref(59),
            ops: ref(249),
            partners: ref(17),
            // Filter
            searchFilter: ref(''),
            // Table
            loading: ref(false),
            pagination,
            columns,
            rows
        }
    },
    methods: {
        exportTable() {
            console.log('export table')
        },
        test(props, col) {
            console.log(props, col)
        }
    },
};
</script>
