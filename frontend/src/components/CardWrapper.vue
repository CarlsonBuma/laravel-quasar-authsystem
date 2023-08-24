<!-- Carlson - 30.12.2022 / 0.1.1 -->
<template>

    <q-card 
        bordered
        :style="{
            width: '100%',
            maxWidth: cardWidth ? cardWidth : '420px', 
        
        }" 
    >

        <!-- Actions -->
        <q-card-section v-if="allowActions" horizontal>
            <slot name="head" />
            <q-card-actions class="justify-around" vertical>
                <slot name="actions" />
            </q-card-actions>
        </q-card-section>
       

        <!-- Card Content -->
        <q-card-section v-if="title">
            <div class="flex items-center _overflow-hidden">
                
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
                    size="22px"
                    :color="iconColor"
                    class="q-ma-sm"
                >
                    <q-tooltip self="center left">
                        <slot name="tooltip" />
                    </q-tooltip>
                </q-icon>

                <!-- Title -->
               <p class="q-ma-none text-h6">{{ title }}</p>
            </div>

            <!-- Description -->
            <p v-if="subtitle" class="q-ml-sm q-mr-sm text-caption">{{ subtitle }}</p>
            
            <!-- Header Icon -->
            <q-separator v-if="iconHeader" class="q-mt-md q-mb-lg" />
            <div v-if="iconHeader" class="flex justify-center">
                <q-icon
                    :name="iconHeader"
                    color="primary" 
                    size="150px" 
                />
            </div>

            <div v-if="title">
                <!-- Body -->
                <q-separator class="q-mt-md q-mb-lg" />
                <slot />
                <slot name="bottom_slot" /> 

                <!-- Note -->
                <q-separator class="q-mt-md q-mb-md"/>
                <p class="text-caption q-ml-sm q-mr-sm"><em>{{ note }}</em></p>
            </div>
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