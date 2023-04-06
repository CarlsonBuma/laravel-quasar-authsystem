<template>
    
    <PageWrapper 
        title="Create a Gig" 
        :directory="directory"
    >

        <!-- Delete Account -->
        <CardWrapper
            class="q-ma-sm"
        >
          
                
                    <q-stepper
                        v-model="step"
                        ref="stepper"
                        color="primary"
                        animated
                        class="q-mt-md"
                        >
                        <q-step
                            :name="1"
                            title="Create your gig"
                            caption="Define a goal."
                            icon="settings"
                            :done="step > 1"
                            :disable="step > 1"
                        >
                            <CreateGig
                                @create="(gig) => createGig(gig)" 
                            />
                        </q-step>

                        <q-step
                            :name="2"
                            title="Define your features"
                            caption="Roadmap to success."
                            icon="create_new_folder"
                            :done="step > 2"
                            :disable="step > 2"
                        >
                            <AddFeatures
                                :gig="gig"
                                @save="(gig) => createGig(gig)" 
                            />
                        </q-step>

                        <q-step
                            :name="3"
                            title="Connect tasks"
                            caption="Keep controll."
                            icon="assignment"
                            :disable="step > 3"

                        >
                            This step won't show up because it is disabled.
                        </q-step>

                        <q-step
                            :name="4"
                            title="Create Backlog"
                            caption="Process data."
                            icon="add_comment"
                        >
                            Try out different ad text to see what brings in the most customers, and learn how to
                            enhance your ads using features like ad extensions. If you run into any problems with
                            your ads, find out how to tell if they're running and how to resolve approval issues.
                        </q-step>

                        <!-- <template v-slot:navigation>
                            <q-stepper-navigation>
                            <q-btn @click="$refs.stepper.next()" color="primary" :label="step === 4 ? 'Finish' : 'Continue'" />
                            <q-btn v-if="step > 1" flat color="primary" @click="$refs.stepper.previous()" label="Back" class="q-ml-sm" />
                            </q-stepper-navigation>
                        </template> -->
                    </q-stepper>
              
    
            
            <!-- <q-card class="q-ma-sm">
                <q-list bordered>
                    
                    <q-item-label header>Feature 1</q-item-label>
                    <q-separator />

                    <q-item v-for="contact in contacts" :key="contact.id" class="q-my-sm" clickable v-ripple>
                        <q-item-section avatar>
                        <q-avatar color="primary" text-color="white">
                            {{ contact.letter }}
                        </q-avatar>
                        </q-item-section>

                        <q-item-section>
                        <q-item-label>{{ contact.name }}</q-item-label>
                        <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
                        </q-item-section>

                        <q-item-section side>
                        <q-icon name="chat_bubble" color="green" />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card>

            <q-card class="q-ma-sm">

                <q-list bordered>
                    
                    <q-item-label header>Feature 1</q-item-label>
                    <q-separator />

                    <q-item v-for="contact in contacts" :key="contact.id" class="q-my-sm" clickable v-ripple>
                        <q-item-section avatar>
                        <q-avatar color="primary" text-color="white">
                            {{ contact.letter }}
                        </q-avatar>
                        </q-item-section>

                        <q-item-section>
                        <q-item-label>{{ contact.name }}</q-item-label>
                        <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
                        </q-item-section>

                        <q-item-section side>
                        <q-icon name="chat_bubble" color="green" />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card> -->

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue'
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import CreateGig from 'pages/user/gig-management/templates/CreateGig.vue';
import AddFeatures from 'pages/user/gig-management/templates/AddFeatures.vue';
import { contacts } from 'src/apis/user.js';

export default {
    name: 'AddNewGig',
    components: {
        PageWrapper, CardWrapper, CreateGig, AddFeatures
    },

    setup() {
        return {
            // Basics
            step: ref(2),

            // Head
            contacts,
            directory: [{
                label: 'Dashboard',
                redirect: '/dashboard'
            }, {
                label: 'My Gigs',
                redirect: '/my-gigs'
            }, {
                label: 'Add new Gig',
                redirect: '/add-new-gig'
            }],
        };
    },
    data() {
        return {
            gig: {} 
        };
    },
    methods: {
        createGig(gig) {
            console.log(gig);
            this.step++;
            console.log(this.step)
        }
    }
};
</script>
