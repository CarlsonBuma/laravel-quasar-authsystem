<template>
    
    <q-page>
        <!-- Refresher -->
        <q-pull-to-refresh 
            :disable="!allowRefresh"
            @refresh="(done) => refresh(done)"
        >
            <!-- Header -->  
            <q-card
                v-if="title" 
                class="q-ma-md q-mt-lg"
                bordered
            >
                <q-card-section class="row">
                    <!-- Head -->
                    <div class="col flex items-center">
                        <div>
                            <div class="text-h6">{{title}}</div>
                            <div class="text-caption">{{subtitle}}</div>
                            <q-breadcrumbs>
                                <q-breadcrumbs-el
                                    v-for="(dir, index) in directory" 
                                    :key="index"
                                    :label="dir.label" 
                                    :to="dir.redirect"
                                />
                            </q-breadcrumbs>
                        </div>
                    </div>
                    
                    <!-- Actions --> 
                    <div class="col-auto">
                        <slot name="actions"/>
                    </div>
                </q-card-section>
            </q-card>

            <!-- Content -->
            <div 
                class="flex justify-center q-pa-lg q-mb-lg"
                :class="{
                    'q-pt-xl': !title,   
                }"
            >
                <slot />
            </div>
        </q-pull-to-refresh>
    </q-page>

</template>

<script>
export default {
    name: 'PageWrapper',
    props: {
        title: String,
        subtitle: String,
        directory: Array,
        allowRefresh: Boolean,
    },
    emits: [
        'refresh'
    ],
    methods: {
        refresh(done) {
            this.$emit('refresh');
            done();
        },
    }
};
</script>
