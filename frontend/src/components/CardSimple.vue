<style lang="sass" scoped>
.my-card
    width: 100%
.tooltip-width
    max-width: 220px !important
</style>

<template>

    <q-card :flat="flat" :bordered="bordered" class="q-mb-sm" :class="custom ? '' : 'my-card'">
        <q-item-label v-if="title" header>
            <div class="row flex items-center align-center">
                <div class="flex items-center align-center">
                    <q-icon
                        v-if="tooltip"
                        name="info"
                        :color="tooltipIconColor ? tooltipIconColor : 'red'"
                        class="q-mr-sm q-mb-xs"
                        size="xs"
                    >
                        <q-tooltip>
                            <p class="q-pa-none q-ma-none text-caption tooltip-width ">{{ tooltip }}</p>
                        </q-tooltip>
                    </q-icon>
                    <span>{{ title }}</span>
                </div>
                <q-space />
                <div class="flex justify-end items-center">
                    <slot name="actions"/>
                </div>
            </div>
        </q-item-label>
        <q-separator />
        <slot />
        <q-separator v-if="note" />
        <q-card-section v-if="note">
            <p class="text-caption q-mb-none"><em>{{ note }}</em></p>
        </q-card-section>
    </q-card>
    
</template>

<script>
export default {
    name: 'CardSimple',
    props: {
        title: String,
        tooltip: String,
        tooltipIconColor: String,
        note: String,
        flat: Boolean,
        bordered: Boolean,
        custom: Boolean
    },
};
</script>
