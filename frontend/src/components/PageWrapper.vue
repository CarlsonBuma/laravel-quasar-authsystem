<template>
    
    <q-page id="page-wrapper">

        <!-- Left Navigation -->
        <q-drawer
            v-if="leftDrawer"
            v-model="$drawerLeft.value"
            show-if-above
            bordered
        >
            <slot name="leftDrawer"/>
        </q-drawer>
        
        <!-- Refresher -->
        <q-pull-to-refresh 
            :disable="!allowRefresh"
            @refresh="(done) => refresh(done)"
            class="w-100"
        >
            <!-- Header -->
            <div v-if="title">
                <div class="row">
                    <div class="col">
                        <p class="text-subtitle1 q-ma-md">
                            <q-btn 
                                v-if="goBack"
                                @click="$router.go(-1)"
                                flat 
                                round 
                                size="sm"
                                text-color="primary" 
                                icon="arrow_left"
                            />
                            <span class="q-ml-xs">{{ title }}</span>
                        </p>
                    </div>
                    <div class="col-auto flex justify-end items-center q-mr-md q-pb-sm">
                        <slot name="actions"/>
                    </div>
                </div>
                <q-separator class="q-mb-md" />
            </div>
            
            <!-- Content -->
            <div v-if="rendering" class="flex justify-center q-mt-md">
                <q-spinner-bars size="74px" color="purple" />
            </div>
            <div v-else class="flex justify-center w-100 q-pt-md q-pl-xs q-pl-md-md q-pr-xs q-pr-md-md q-pb-xl" >
                <slot />
            </div> 
        </q-pull-to-refresh>
    </q-page>

</template>

<script>
    import { QSpinnerGears } from 'quasar'
    export default {
        name: 'PageWrapper',

        props: {
            leftDrawer: Boolean,
            title: String,
            subtitle: String,
            goBack: Boolean,
            allowRefresh: Boolean,
            rendering: Boolean,         // Navigation allowed
            loading: Boolean,           // Navigation forbidden
            overflow: Boolean,
        },

        watch: {
            loading(value) {
                value ?  this.startRendering() : this.stopRendering();
            },
        },

        emits: [
            'refresh'
        ],

        methods: {
            refresh(done) {
                this.$emit('refresh');
                done();
            },

            startRendering() {
                this.$q.loading.show({
                    boxClass: 'page-loading-block',
                    spinner: QSpinnerGears,
                    message: 'Loading data. Please wait...',
                })
            },

            stopRendering() {
                this.$q.loading.hide()
            }
        }
    };
</script>
