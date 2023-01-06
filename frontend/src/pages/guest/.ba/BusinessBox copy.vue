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
                    Partnerships
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
                :csv_download="true" 
                :global_search="true"
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

                <!-- Custom: RowCells -->
                <template v-slot:body="props">
                    <q-tr :props="props">
                        <!-- Expand -->
                        <q-td auto-width>
                            <q-btn 
                                size="xs" 
                                color="primary" 
                                round 
                                dense 
                                @click="props.expand = !props.expand" 
                                :icon="props.expand ? 'remove' : 'add'" 
                            />
                        </q-td>
                        <!-- Default -->
                        <q-td
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            <!-- Custom here -->
                            <div
                                v-if="col.name === 'skills'" 
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
import PageWrapper from 'components/PageWrapper.vue';

export default {
    name: 'BusinessBox',
    components: {
        PageWrapper
    },
    setup () {
        const textBreakClass = 'word-break: break-all; overflow: auto;white-space: pre-wrap;';
        const pagination = {
            // sortBy: 'desc',
            // descending: false,
            // page: 2,
            rowsPerPage: 25
            // rowsNumber: xx if getting data from a server
        };
        const columns = [
            { 
                name: 'name',  
                label: 'Entity', 
                align: 'left',
                field: 'name',
                format: val => `${val}`,
                sortable: true 
            },
            { 
                name: 'about',  
                label: 'Unser Angebot',
                style: 'min-width: 380px;' + textBreakClass,
                align: 'left',
                field: 'about',
                format: val => `${val}`, 
            },
            { 
                name: 'skills',  
                label: 'Skills',
                align: 'left', 
                style: 'width: 20vw; min-width: 240px;' + textBreakClass,
                field: 'skills',
                //format: val => JSON.stringify(val),
            },
            { 
                name: 'ops', 
                label: 'Ops.',
                align: 'center', 
                field: 'ops', 
                sortable: true, 
                sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) 
            },
            { 
                name: 'pricerange', 
                label: 'Pricerange',
                align: 'left', 
                field: 'pricerange',
                sortable: true, 
                sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) 
            },
            { 
                name: 'reviews', 
                label: 'Reviews',
                align: 'center', 
                field: 'reviews', 
                sortable: true, 
                sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) 
            }
        ];
        const rows = [
            {
                key: 0,
                name: 'bumaEnitity',
                about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
                skills: [
                    {
                        key: 0,
                        label: 'asdf'
                    },
                    {
                        key: 1,
                        label: 'fffff'
                    },
                    {
                        key: 2,
                        label: 'ggf'
                    },
                    {
                        key: 3,
                        label: '44234'
                    },{
                        key: 3,
                        label: 'ggdr'
                    },{
                        key: 3,
                        label: '234gg'
                    },{
                        key: 3,
                        label: '6345'
                    },{
                        key: 3,
                        label: 'sfccf'
                    }
                ],
                ops: 4,
                pricerange: 10000.20,
                reviews: 34,
            },{
                key: 1,
                name: 'bumaEnitity2',
                about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
                skills: [
                    {
                        key: 0,
                        label: 'asdf'
                    },
                    {
                        key: 1,
                        label: 'fffff'
                    },
                    {
                        key: 2,
                        label: 'ggf'
                    },
                    {
                        key: 3,
                        label: '444kkg'
                    },{
                        key: 3,
                        label: '64'
                    },{
                        key: 3,
                        label: 'vssdf'
                    },{
                        key: 3,
                        label: '64kk'
                    },{
                        key: 3,
                        label: 'vxcv'
                    }
                ],
                ops: 1,
                pricerange: 190.20,
                reviews: 12,
            },{
                key: 2,
                name: 'Company2',
                about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
                skills: [
                    {
                        key: 0,
                        label: '6456'
                    },
                    {
                        key: 1,
                        label: 'fffff'
                    },
                    {
                        key: 2,
                        label: 'ggf'
                    },
                    {
                        key: 3,
                        label: '534555345'
                    },{
                        key: 3,
                        label: '64kk'
                    },{
                        key: 3,
                        label: 'swer'
                    },{
                        key: 3,
                        label: 'vxcv'
                    },{
                        key: 3,
                        label: 'ljljkljkl'
                    }
                ],
                ops: 2,
                pricerange: 500,
                reviews: 134,
            },
        ]

        console.log(rows)
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
