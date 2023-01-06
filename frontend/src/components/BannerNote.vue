<template>
    
    <q-separator class="q-mt-md q-mb-md"/>
    <q-banner 
        v-if="bannerType && text"
        inline-actions 
        rounded 
        class="text-white q-mt-sm"
        :class="{
            'bg-primary': bannerType === 'loading' ? true : false,
            'bg-green': bannerType === 'success' ? true : false,
            'bg-red': bannerType === 'error' ? true : false
        }"
    >
        <div class="flex items-center justify-center">
            <q-spinner-gears
                v-if="bannerType === 'loading'"
                class="on-left"
            />
            <q-icon 
                v-else 
                :name="bannerType === 'success' ? 'check_circle_outline' : 'cancel'"
            />
            &nbsp;{{ text }}
        </div>
    </q-banner>

    <p v-else class="text-caption q-ml-sm q-mr-sm"><em>{{ note }}</em></p>

</template>

<script>
export default {
    name: 'BannerNote',
    props: {
        bannerType: String,
        text: String,
        note: String
    },
};
</script>
