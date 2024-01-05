<template>

    <q-scroll-area class="fit">
        <q-list padding >

            <!-- Dashboard -->
            <q-item 
                @click="$router.push('/backpanel')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="dashboard" />
                </q-item-section>
                <q-item-section>
                    Dashboard
                </q-item-section>
            </q-item>
            <q-item 
                @click="$router.push('/releasemanagement')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="new_releases" />
                </q-item-section>
                <q-item-section>
                    Releasemanagement
                </q-item-section>
            </q-item>
        </q-list>
    </q-scroll-area>

</template>

<script>
export default {
    name: 'NavigationAdmin',
};
</script>
