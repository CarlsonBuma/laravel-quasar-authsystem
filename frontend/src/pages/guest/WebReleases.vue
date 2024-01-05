<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 420px
</style>

<template>

    <PageWrapper 
        title="Latest releases"
        :rendering="rendering"
    >
        <CardSimple class="q-mt-sm my-card">
            <q-card-section>

                <!-- If no Releases -->
                <q-timeline v-if="releases.length === 0" color="primary">
                    <q-timeline-entry
                        title="Releasemanagement"
                        :subtitle="'Info, ' + currentDate"
                    >
                        <div class="_text-break">No releases has been announced yet.</div>
                    </q-timeline-entry>
                </q-timeline>

                <!-- All Releases -->
                <q-timeline color="primary">
                    <q-timeline-entry
                        v-for="(entry, index) in releases"
                        :key="index"
                        :title="entry.title"
                        :subtitle="entry.type + ', ' + entry.created_at"
                    >
                        <div class="_text-break">{{ entry.description }}</div>
                    </q-timeline-entry>
                </q-timeline>
            </q-card-section>
        </CardSimple>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { date } from 'quasar';
import { getReleaseEntries } from 'src/apis/admin.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardSimple from 'components/CardSimple.vue';

export default {
    name: 'VisitorReleases',
    components: {
        PageWrapper, CardSimple
    },

    setup() {
        return {
            rendering: ref(false),
            currentDate: date.formatDate(new Date(), 'DD-MM-YYYY')
        }
    },

    data() {
        return {
            releases: []
        }
    },

    mounted() {
        this.getReleases();
    },

    methods: {
        async getReleases() {
            try {
                this.rendering = true;
                const response = await getReleaseEntries();
                this.releases = response.data.releases
                console.log(this.releases)
            } catch (error) {
                this.$toast.error(error.response)
            } finally {
                this.rendering = false;
            }
        },
    }
};
</script>
