<style scoped>
.search-width {
    width: 270px;
}
.my-card {
    max-width: 420px;
    min-width: 270px;
}
</style>

<template>

    <PageWrapper title="GIGs Management" :directory="directory">

        <template #actions>
            <q-btn @click="$router.push('add-new-gig')" icon="add" flat label="Create Gig" />
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
                    <q-btn flat round color="primary" icon="history" @click="{
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
                <div><b>About Gig:</b></div>

                
                <div> {{ gig.about }}</div>

                

                <q-separator class="q-ma-sm"></q-separator>
                <div><b>Deails:</b></div>
                <div>Start: {{ gig.start }}</div>
                <div>Deadline: {{ gig.duration }}</div>
                
                <q-separator class="q-ma-sm"></q-separator>
                <div><b>Feature Progress:</b></div>
                
                <div class="q-pa-md">
                    Complete:
                    <q-linear-progress rounded size="15px" color="teal" value="0.25"/>
                </div>
                
                <div>
                    <q-chip 
                        v-for="tag in gig.skills"
                        :key="tag.key"
                        square 
                        class="glossy"
                        :icon="tag.status === 'done' 
                            ? 'check' 
                            : tag.status === 'pending'
                                ? 'flag'
                                : 'pending'"
                        :color="tag.status === 'done' 
                            ? 'teal' 
                            : tag.status === 'pending'
                                ? 'orange' 
                                : ''"
                    >
                        {{ tag.label }}
                    </q-chip>
                </div>




                <q-separator class="q-ma-sm"></q-separator>
                <div><b>Current Tasks:</b> [Laravel &amp; SQL]</div>
                <div>
                    <q-chip 
                        v-for="tag in gig.skills"
                        :key="tag.key"
                        square 
                        class="glossy"
                        icon="pending"
                    >
                        {{ tag.label }}
                    </q-chip>
                </div>
                
                
                <q-separator class="q-ma-sm"></q-separator>
                <div class="flex justify-end">
                    <div class="w-100 flex justify-center">
                        <q-avatar
                            v-for="n in 15"
                            :key="n"
                            size="40px"
                            class="q-ma-xs"
                        >
                            <img :src="`https://cdn.quasar.dev/img/avatar${n + 1}.jpg`">
                        </q-avatar>
                    </div>
                    
                    <q-btn @click="$router.push('manage-team')" icon="group" flat label="Manage Team" />
                </div>
            </q-card-section>
        </q-card>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { getGigs } from 'src/apis/user.js';
import PageWrapper from 'components/PageWrapper.vue';

export default {
    name: 'GigsManagement',
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
        const gigRequests = getGigs();

        return {
            directory: [{
                label: 'Dashboard',
                redirect: '/dashboard'
            }, {
                label: 'My Gigs',
                redirect: '/my-gigs'
            }],

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
            gigRequests,

            
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
