<!-- Carlson - 30.12.2022 / 0.1.1 -->
<template>
    <q-card 
        bordered
        :style="{
            width: '100%',
            maxWidth: cardWidth ? cardWidth : '100%', 
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
            
            <!-- Titile -->
            <div
                v-if="title" 
                class="flex items-center text-h6 _overflow-hidden"
            >
                
                <!-- Navigation: Go back -->
                <q-btn 
                    v-if="goBack"
                    @click="$router.go(-1)"
                    flat 
                    round 
                    text-color="purple" 
                    icon="arrow_left"
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

                <!-- Default -->
                <q-btn 
                    v-else
                    flat 
                    round 
                    text-color="purple" 
                    icon="arrow_right" 
                    label="" 
                />  

                <!-- Title -->
                {{ title }}
            </div>

            <!-- Subtitle -->
            <p v-if="subtitle" class="q-ml-sm q-mr-sm text-caption _text-break">{{ subtitle }}</p>
            
            <!-- Header -->
            <div class="w-100 text-center q-mb-md">
                <slot name="header" />
            </div>

            <!-- Body -->
            <q-separator class="q-mt-md q-mb-lg" />
            
            <!-- Main -->
            <slot />

            <!-- Bottom Slot -->
            <slot name="bottom_slot" /> 

        </q-card-section>
    </q-card>
</template>

<script>
export default {
    name: 'PageWrapper',
    props: {
        goBack: Boolean,
        title: String,
        subtitle: String,
        iconClass: String,
        iconColor: String,
        cardWidth: String,
        allowActions: Boolean,
    },
};
</script>