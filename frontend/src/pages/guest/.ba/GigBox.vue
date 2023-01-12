<style scoped>
.search-width {
    width: 270px;
}
.my-card {
    max-width: 25%;
    min-width: 270px;
}
</style>

<template>

    <PageWrapper title="EventBox" subtitle="Meet &amp; Greet.">

        <!-- Entity Drawer -->
        <q-drawer
            side="right"
            v-model="drawerRightEntity"
            bordered
            overlay
            :width="250"
            :breakpoint="500"
            elevated
        >
            <q-scroll-area class="fit">
                <q-btn color="orange" class="shadow w-100" square icon="close" @click="{
                    drawerRightEntity = false;
                    drawerRightRequirements = false;    
                }" />
                <div class="q-pa-sm">
                    <div class="text-h6 q-ma-md">Entity details</div>
                    <q-separator class="q-mt-md q-mb-md"/>

                    <!-- Entity Details -->

                </div>
            </q-scroll-area>
        </q-drawer>

        <!-- Entity Drawer -->
        <q-drawer
            side="right"
            v-model="drawerRightRequirements"
            bordered
            overlay
            :width="250"
            :breakpoint="500"
            elevated
        >
            <q-scroll-area class="fit">
                <q-btn color="orange" class="shadow w-100" icon="close" @click="{
                    drawerRightEntity = false;
                    drawerRightRequirements = false;    
                }"
            />
                <div class="q-pa-sm">
                    <div class="text-h6 q-ma-md">Progress details</div>
                    <q-separator class="q-mt-md q-mb-md"/>

                    <!-- Gig Details -->
                    <div><b>Progress:</b></div>
                    <div>Here comes Progress</div>
                    <q-separator class="q-ma-sm"></q-separator>
                    <div><b>Requirements:</b></div>
                    <div>Requirements by Progress</div>
                </div>
            </q-scroll-area>
        </q-drawer>

        <!-- Overview -->
        <template #actions>
            Search / Filter
        </template>
        
        <q-card
            v-for="(gig) in gigRequests"
            :key="gig.gigKey"
            class="my-card q-ma-md shadow-7"
            flat 
            bordered
        >
            <q-card-section horizontal>
                <q-img
                    class="col"
                    src="https://cdn.quasar.dev/img/parallax2.jpg"
                    @click="{
                        drawerRightEntity = false;
                        drawerRightRequirements = false;
                    }"
                >
                    <div class="absolute-bottom text-h6">
                        {{ gig.title }}
                    </div>  
                </q-img>

                <q-card-actions vertical class="justify-around q-px-md">
                    <q-btn flat round color="primary" icon="share" @click="{
                        drawerRightRequirements = false;
                        drawerRightEntity = !drawerRightEntity;
                    }" />
                    <q-btn flat round color="grey" icon="add_task"  @click="{
                        drawerRightEntity = false;
                        drawerRightRequirements = !drawerRightRequirements;
                    }" />
                </q-card-actions>
            </q-card-section>

            <q-card-section>
                <div><b>About Projecti:</b></div>
                <div> {{ gig.about }}</div>

                <q-separator class="q-ma-sm"></q-separator>
                <div><b>Deails:</b></div>
                <div>Start: {{ gig.start }}</div>
                <div>Duration: {{ gig.duration }}</div>
                <div>Compensation: {{ gig.pricerange[0] + ' - ' + gig.pricerange[1] + 'CHF'}}</div>
                
                <q-separator class="q-ma-sm"></q-separator>
                <div><b>Requirements:</b></div>
                <div>
                    <q-chip 
                        v-for="tag in gig.skills"
                        :key="tag.key"
                        square 
                        class="glossy"
                        :icon="tag.available ? 'close' : 'check'"
                        :color="tag.available ? 'orange' : 'teal'"
                    >
                        {{ tag.label }}
                    </q-chip>
                </div>
                <q-separator class="q-ma-sm"></q-separator>
                <div>Amount of Specialists: {{ gig.ops }}</div>
            </q-card-section>
        </q-card>
        
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { gigsAPI } from 'src/apis/visitor.js';
import PageWrapper from 'components/PageWrapper.vue';

export default {
    name: 'GigBox',
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

        // Table
        const gigRequests = gigsAPI();

        return {
            drawerRightEntity: ref(false),
            drawerRightRequirements: ref(false),
            reviews: ref(69),
            gigs: ref(13),
            entities: ref(17),
            // Filter
            searchFilter: ref(''),
            // Table
            loading: ref(false),
            pagination,
            gigRequests
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
