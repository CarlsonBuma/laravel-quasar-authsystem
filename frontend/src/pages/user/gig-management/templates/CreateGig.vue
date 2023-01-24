<template>
    
    <div>

        <q-input 
            v-model="name" 
            :label="name.length === 0 
                ? 'Name your gig here...'
                : name.length === 1
                    ? 'Name your gig here..'
                    :  name.length === 2
                        ? 'Name your gig here.'
                        : 'Your gig'"
        />
        
        <!-- Start -->
        <div class="fit row wrap justify-center items-start content-start">
            <div class="col-6"><!-- Start -->
                <q-input filled v-model="start" mask="date" class="q-ma-xs" hint="Go online:" :rules="['date']">
                    <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                        <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                            <q-date v-model="start">
                                <div class="row items-center justify-end">
                                    <q-btn v-close-popup label="Close" color="primary" flat />
                                </div>
                            </q-date>
                        </q-popup-proxy>
                        </q-icon>
                    </template>
                </q-input>
            </div>
            <div class="col-6">
                <!-- time -->
                <q-input
                    v-model.number="time"
                    :min="0"
                    type="number"
                    hint="Time we spend:"
                    class="q-ma-xs"
                    filled
                >
                    <template v-slot:prepend>
                        <q-icon name="schedule" color="green"/>
                    </template>

                    <template v-slot:append>hours</template>
                </q-input>
            </div>

            <div class="col-6"><!-- Start -->
                <!-- Deadline -->
                <q-input 
                    filled 
                    v-model="deadline" 
                    mask="date" 
                    class="q-ma-xs" 
                    hint="Deadline:" 
                    :rules="['date']"
                >
                    <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                        <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                            <q-date v-model="deadline">
                            <div class="row items-center justify-end">
                                <q-btn v-close-popup label="Close" color="primary" flat />
                            </div>
                            </q-date>
                        </q-popup-proxy>
                        </q-icon>
                    </template>
                </q-input>
            </div>
            <div class="col-6">
                <!-- time -->
                <q-input
                    v-model.number="collaborator"
                    :min="0"
                    type="number"
                    hint="Amount of collaborators:"
                    filled
                    class="q-ma-xs"
                >
                    <template v-slot:prepend>
                        <q-icon name="people" color="orange" />
                    </template>
                </q-input>
            </div>
        </div>

        <!-- Editor -->
        <q-separator class="q-mt-md"/>
        <div class="q-pa-md q-gutter-sm">
            <q-editor 
                v-model="editor" 
                min-height="15rem" 
                @update:editor="(value) => {
                    this.editor = '3423'
                }"
                placeholder="Summarize your vision! Be creative, be specific."
                
            />
        </div>

        <div class="flex justify-start">
            <div class="text-caption flex text-weight-light">Information points:&nbsp;
                <p :class="editor.length > 5000 ? 'text-red' : 'text-green'">{{ editor.length }}&nbsp;</p>
                of max. 5000
            </div>
        </div>

        <div class="flex justify-end">
            <q-btn 
                @click="createGig(editor)"
                icon="add" 
                flat 
                label="Create Gig"
            />
        </div>
    </div>
    

</template>

<script>
import { ref } from 'vue'

export default {
    name: 'CreateGig',
    components: {
        
    },

    props: {
        gig: Object
    },

    emits:[
        'create'
    ],

    setup() {
        return {
            name: ref(''),
            logo: ref(''),
            start: ref(''),
            deadline: ref(''),
            time: ref(0),
            collaborator: ref(0),
            editor: ref('')
        };
    },
    data() {
        return {
            // 
        };
    },
    methods: {
        createGig(editor) {
            console.log(editor, this.gig);
            this.$emit('create', this.gig);
        }
    }
};
</script>
