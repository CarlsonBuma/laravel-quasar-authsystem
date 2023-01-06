<template>

    <q-toolbar class="q-pa-md">
        
        <!-- Left-Drawer: Responsive - md -->
        <q-btn 
            v-if="allowLeftDrawer"
            @click="$emit('expandDrawerLeft')" 
            class="gt-sm"
            flat 
            round 
            dense 
            icon="menu" 
        />
        <q-btn 
            v-if="allowLeftDrawer"
            @click="$emit('showDrawerLeft')" 
            class="lt-md"
            flat 
            round 
            dense 
            icon="menu" 
        />
        
        <!-- Features -->
        <q-space></q-space>
        <q-btn flat round dense icon="search" class="q-mr-xs" />
        <q-btn flat round dense icon="group_add" />

    </q-toolbar>

    <!-- Progressbar -->
    <q-linear-progress id="progressBar" indeterminate hidden />
    
</template>

<script>
export default {
    name: 'NavTopGuest',
    props: {
        allowLeftDrawer: Boolean,
    },
    emits: [
        'showDrawerLeft',
        'expandDrawerLeft',
    ],
    setup () {
        return {
            // Code
        }
    }
};
</script>
