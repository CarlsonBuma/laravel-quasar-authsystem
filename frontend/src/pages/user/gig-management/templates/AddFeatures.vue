<template>
    
    <div>
        Features
    </div>

</template>

<script>

export default {
    name: 'AddFeatures',
    components: {
        //
    },

    props: {
        gig: Object
    },

    emits:[
        'save'
    ],

    setup() {
        return {
            
        };
    },
    data() {
        return {
            // 
        };
    },
    methods: {
        createGig(gig) {
            console.log(gig);
            this.$emit('save');
        }
    }
};
</script>
