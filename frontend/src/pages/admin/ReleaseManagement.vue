<template>

    <PageWrapper 
        title="Releasemanagement" 
        :rendering="rendering"
        leftDrawer
    >
        <template #leftDrawer>
            <NavigationAdmin />
        </template>

        <!-- Add Entries -->
        <div class="row w-100">
            <div class="col-12 q-mb-sm">
                <q-markup-table class="w-100">
                    <thead>
                        <tr>
                            <th class="text-left">Version</th>
                            <th class="text-left">Title</th>
                            <th class="text-left">Description</th>
                            <th class="text-left">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <q-input v-model="newEntry.version" />
                            </td>
                            <td>
                                <q-input v-model="newEntry.title" />
                            </td>
                            <td>
                                <q-input v-model="newEntry.description" autogrow />
                            </td>
                            <td>
                                <q-select v-model="newEntry.type" :options="releaseOptions"/>
                            </td>
                        </tr>
                    </tbody>
                </q-markup-table>
            </div>
            <div class="col-12 flex justify-end q-mb-sm">
                <q-btn label="Publish new release" color="primary" @click="createNewRelease(newEntry)"/>
            </div>
        </div>
        
        <!-- Read, Update, Delete Entries -->
        <q-separator class="w-100 q-ma-md" />
        <q-table
            title="Published releases"
            :rows="releases"
            :columns="columns"
            row-key="id"
            class="w-100 q-mt-sm"
        >
            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="id" :props="props">
                        {{ props.rowIndex + 1 }}
                    </q-td>
                    <q-td key="version" :props="props">
                        {{ props.row.version }}
                        <q-popup-edit v-model="props.row.version" v-slot="scope">
                            <q-input v-model="scope.value" dense autofocus counter @keyup.enter="scope.set" />
                        </q-popup-edit>
                    </q-td>
                    <q-td key="title" :props="props">
                        {{ props.row.title }}
                        <q-popup-edit v-model="props.row.title" v-slot="scope">
                            <q-input v-model="scope.value" dense autofocus counter @keyup.enter="scope.set" />
                        </q-popup-edit>
                    </q-td>
                    <q-td key="description" :props="props">
                        <span class="_text-break">{{ props.row.description }}</span>
                        <q-popup-edit v-model="props.row.description" v-slot="scope">
                            <q-input v-model="scope.value" autogrow dense autofocus counter>
                                <template v-slot:append>
                                    <q-icon name="check" @click="scope.set" class="cursor-pointer" />
                                </template>
                            </q-input>
                        </q-popup-edit>
                    </q-td>
                    <q-td key="type" :props="props">
                        {{ props.row.type }}
                        <q-popup-edit v-model="props.row.type" v-slot="scope">
                            <q-select v-model="scope.value" :options="releaseOptions" @keyup.enter="scope.set"/>
                        </q-popup-edit>
                    </q-td>
                    <q-td key="date" :props="props">
                        {{ props.row.created_at }}
                    </q-td>
                    <q-td key="edit" :props="props">
                        <div class="flex justify-end">
                            <q-btn round dense color="green" class="q-mr-sm" icon="check" size="xs" @click="updateEntry(props.row)"/>
                            <q-btn round dense color="red" icon="delete" size="xs" @click="confirmDelete(props.row)"/>
                        </div>
                    </q-td>
                </q-tr>
            </template>
        </q-table>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { getReleaseEntries, createReleaseEntry, updateReleaseEntry, deleteReleaseEntry } from 'src/apis/admin.js';
import PageWrapper from 'components/PageWrapper.vue';
import NavigationAdmin from 'src/pages/layout/NavigationAdmin.vue';

export default {
    name: 'ReleaseManagement',
    components: {
        PageWrapper, NavigationAdmin
    },

    setup() {
        const releaseOptions = ['Bugfix', 'Info', 'Change'];
        const columns = [
            {
                name: 'id',
                required: true,
                label: 'ID',
                sortable: true,
                field: 'id',
                style: 'width: 50px',
            }, {
                name: 'version',
                required: true,
                label: 'Version',
                sortable: true,
                field: 'version',
                style: 'width: 70px',
            }, {
                name: 'title',
                required: true,
                label: 'Title',
                field: 'title',
                align: 'left',
            }, {
                name: 'description',
                required: true,
                label: 'Description',
                field: 'description',
                align: 'left',
            }, {
                name: 'type',
                label: 'Type',
                sortable: true,
                field: 'type',
                align: 'left',
                style: 'width: 90px',
            }, {
                name: 'date',
                required: true,
                sortable: true,
                label: 'Date',
                field: 'date',
                align: 'left',
                style: 'width: 90px',
            }, {
                name: 'edit',
                label: 'Edit',
                field: 'edit',
                style: 'width: 120px',
            },
        ];

        return {
            rendering: ref(false),
            releaseOptions,
            columns,
        };
    },

    data() {
        return {
            newEntry: {
                title: '',
                version: '',
                description: '',
                type: ''
            },
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

        async createNewRelease(newEntry) {
            try {
                if(!newEntry.title) throw 'Please enter titel.'
                this.$toast.load();
                const response = await createReleaseEntry(newEntry);
                this.$toast.success(response.data.message)
                this.releases.unshift({
                    id: response.data.entry_id,
                    title: newEntry.title,
                    version: newEntry.version,
                    description: newEntry.description,
                    type: newEntry.type,
                    created_at: 'now',
                })

                this.newEntry = {
                    title: '',
                    description: '',
                    version: '',
                    type: '',
                }
            } catch (error) {
                this.$toast.error(error.response ? error.response : error)
            } finally {
                this.$toast.done();
            }
        },

        async updateEntry(entry) {
            try {
                this.$toast.load();
                const response = await updateReleaseEntry(entry);
                this.$toast.success(response.data.message)
            } catch (error) {
                this.$toast.error(error.response)
            } finally {
                this.$toast.done();
            }
        },

        confirmDelete(entry) {
            this.$q.dialog({
                title: 'Confirm',
                message: 'Would you like to remove this entry?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.deleteEntry(entry)
            })
        },

        async deleteEntry(entry) {
            try {
                this.$toast.load();
                const response = await deleteReleaseEntry(entry);
                this.$toast.success(response.data.message)
                this.releases.forEach((release, index) => {
                    if(release.id === entry.id) this.releases.splice(index, 1)
                })
            } catch (error) {
                this.$toast.error(error.response)
            } finally {
                this.$toast.done();
            }
        }
    },
};
</script>
