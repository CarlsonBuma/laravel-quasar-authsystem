<!-- Carlson - 30.12.2022 / 0.1.1 -->
<template>

    <q-card 
        bordered
        :style="{
            width: '100%',
            maxWidth: cardWidth ? cardWidth : '420px', 
            minWidth: '320px'
        }" 
    >
        <!-- Actions -->
        <q-card-section v-if="allowActions" horizontal>
            <slot name="head" />
            <q-card-actions 
                class="justify-around"
                vertical
            >
                <slot name="actions" />
            </q-card-actions>
        </q-card-section>
        <q-separator v-if="allowActions" />

        <!-- Card Body -->
        <q-card-section>

            <!-- Title -->
            <div
                v-if="title" 
                class="flex items-center text-h5 _overflow-hidden"
            >
                
                <!-- Navigation: Go back -->
                <q-btn 
                    v-if="goBack"
                    @click="goBack ? $router.go(-1) : ''"
                    flat 
                    round 
                    text-color="primary" 
                    :icon="goBack ? 'arrow_left' : 'arrow_right'"
                />

                <!-- Tooltip -->
                <q-icon
                    v-else-if="iconClass" 
                    :name="iconClass"
                    :color="iconColor"
                    class="q-ma-sm"
                >
                    <q-tooltip self="center left">
                        <slot name="tooltip" />
                    </q-tooltip>
                </q-icon>

                <!-- Title -->
               {{ title }}
            </div>

            <!-- Description -->
            <p v-if="subtitle" class="q-ml-sm q-mr-sm text-caption">{{ subtitle }}</p>
            
            <!-- Header Icon -->
            <q-separator v-if="iconHeader" class="q-mt-md q-mb-lg" />
            <div 
                v-if="iconHeader" 
                class="flex justify-center"
            >
                <q-icon
                    :name="iconHeader"
                    color="primary" 
                    size="170px" 
                />
            </div>

            <!-- Header -->
            <!-- <div class="w-100 text-center q-mb-md">
                <slot name="header" />
            </div> -->

            <!-- Body -->
            <q-separator class="q-mt-md q-mb-lg" />
            <slot />
            <slot name="bottom_slot" /> 

            <q-separator class="q-mt-md q-mb-md"/>
            <p class="text-caption q-ml-sm q-mr-sm"><em>{{ note }}</em></p>
        </q-card-section>
    </q-card>
    
</template>

<script>
export default {
    name: 'PageWrapper',
    props: {
        goBack: Boolean,
        iconHeader: String,
        title: String,
        note: String,
        subtitle: String,
        iconClass: String,
        iconColor: String,
        cardWidth: String,
        allowActions: Boolean,
    },
};
</script>