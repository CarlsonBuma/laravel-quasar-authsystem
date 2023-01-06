<template>

    <q-form
        @submit="$emit('submit')"
        class="q-gutter-md q-mt-lg q-mb-lg"
    >
        <!-- Content -->
        <slot />

        <!-- Submit -->
        <div v-if="!noSubmit" class="row justify-end">
            <q-btn 
                :label="buttonText ? buttonText : 'Submit'" 
                :color="buttonColor ? buttonColor : 'primary'"
                :icon="buttonIcon ? buttonIcon : 'send'"
                :loading="loading"
                :disable="loading || buttonDisabled"
                type="submit" 
            >
                <template #loading>
                    <q-spinner-gears class="on-left" />{{buttonText}}
                </template>
            </q-btn>
        </div>
    </q-form>
    
</template>

<script>
export default {
    name: 'FormWrapper',
    emits: [
        'submit'
    ],
    props: {
        noSubmit: Boolean,
        buttonText: String,
        buttonColor: String,
        buttonIcon: String,
        loading: Boolean,
        buttonDisabled: Boolean,
    },
};
</script>
