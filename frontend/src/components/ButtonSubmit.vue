<template>

    <q-btn 
        class="q-ma-sm q-mt-md"
        :disable="loading || disabled"
        :label="buttonText ? buttonText : 'Submit'" 
        :color="buttonColor ? buttonColor : 'primary'"
        :icon="buttonIcon ? buttonIcon : 'send'"
        :loading="loading"
        type="submit" 
        @click="$emit('submit')"
    >
        <template #loading>
            <q-spinner-gears class="on-left" />{{buttonText}}
        </template>
    </q-btn>

</template>

<script>
export default {
    name: 'ButtonSubmit',
    emits: [
        'submit'
    ],
    props: {
        loading: Boolean,
        buttonText: String,
        buttonColor: String,
        buttonIcon: String,
        disabled: Boolean,
    },
};
</script>