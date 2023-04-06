<template>

    <div>

        <!-- Splitter -->
        <q-splitter
            v-model="splitterModel"
            class=""
        >
            <template v-slot:before>

                <!-- Splitter Content -->
                <p class="flex align-center justify-center text-h6">Features</p>
                <q-separator />
                <q-list class="q-ma-md">

                    <!-- Draggable -->
                    <Draggable v-model="features">
                        <template v-slot:item="{item}">
                            
                            <!-- Content -->
                            <q-expansion-item header-class="glossy"
                                expand-icon-class="text-white" 
                                popup icon="mail" 
                                :label="item.title" 
                                caption="5 unread emails" 
                                class="rounded-boarders"
                            >
                                 <template v-slot:header>
                                        <q-item-section>
                                            <q-chip square icon="hourglass_top" class="bg-orange">
                                                50.4 hours
                                            </q-chip>
                                        </q-item-section>
                                        <q-item-section class="">
                                            <p class="text-h6">{{ item.title }}</p>
                                        </q-item-section>
                                    </template>
                                <q-separator />
                            </q-expansion-item>
                        </template>
                    </Draggable>
                </q-list>
            </template>

            <template v-slot:after>

                <!-- Splitter - Content -->
                <p class="flex justify-center adjust-center text-h6">Tasks</p>
                <q-separator />
                <q-list class="q-ma-md">
                    <!-- Draggable -->
                    <Draggable 
                        v-model="features"
                    >
                        <template v-slot:item="{item}">

                            <!-- Content -->
                            <q-expansion-item  popup default-opened icon="success" :label="item.title" caption="500 hours">

                                <template v-slot:header>

                                    <q-item-section>
                                        Task 1
                                    </q-item-section>
                                    <q-item-section >
                                        <q-chip color="purple" square text-color="white" class="glossy q-pa-md" icon="hourglass_top">
                                            50.4 hours
                                        </q-chip>
                                    </q-item-section>

                                    <q-item-section>
                                        <q-chip color="primary" square text-color="white" class="glossy q-pa-md" icon="hourglass_top">
                                            Task 1
                                        </q-chip>
                                    </q-item-section>
                                </template>
                            
                                <q-card>
                                    <q-card-section>
                                        {{ item.title }}
                                    </q-card-section>
                                </q-card>
                            </q-expansion-item>

                        </template>
                    </Draggable>
                </q-list>
            </template>

        </q-splitter>

        <div class="flex justify-end">
            <q-btn 
                @click="createFeatures(features)"
                icon="add" 
                flat 
                label="Create Gig"
            />
        </div>
    </div>


</template>

<script>
import { ref } from 'vue'
import Draggable from "vue3-draggable";

export default {
    name: 'AddFeatures',
    components: {
        Draggable,
    },

    props: {
        gig: Object
    },

    emits:[
        'save'
    ],

    setup() {
        return {
            splitterModel: ref(50), // start at 50%
            insideModel: ref(50)
        };
    },
    data() {
        return {
            features: [{
                title: 'Im Title'
            }, {
                title: 'Im Title2'
            }, {
                title: 'Im Title3'
            }]
        };
    },
    methods: {
        createFeatures(features) {
            console.log(features);
            // this.$emit('save');
        }
    }
};
</script>
