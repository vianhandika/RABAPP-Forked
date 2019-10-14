<template>
  <v-data-table
    :headers="headers"
    :items="project"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Project</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" max-width="450px">
          <template v-slot:activator="{ on }">
            <v-btn color="blue" dark class="mb-2" v-on="on">New</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="project.name" 
                    label="Name">
                  </v-text-field>
                </v-flex>
              </v-layout>
              
              <!-- <v-row justify="center">
                <v-date-picker v-model="picker"></v-date-picker>
              </v-row> -->

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="project.date" 
                    label="Transaction Date">
                    </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="project.address" 
                    label="Address">
                    </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="project.contact" 
                    label="Contact">
                    </v-text-field>
                </v-flex>
              </v-layout>
            </v-card-text>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>

        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.action="{ item }">
      <v-icon
        small
        class="mr-2"
        color="green"
        @click="editItem(item)"
      >
        edit
      </v-icon>
      <v-icon
        small
        color="red"
        @click="deleteItem(item)"
      >
        delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      headers: [
        {
          text: 'Name',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { text: 'Date', value: 'date' },
        { text: 'Address', value: 'address' },
        { text: 'Contact', value: 'contact' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      project: [],
      editedIndex: -1,
      editedItem: {
        name: '',
        date: '',
        address: '',
        contact: '',
      },
      defaultItem: {
        name: '',
        date: '',
        address: '',
        contact: 0,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Project' : 'Edit Project'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.project = [
          {
            name: 'Frozen Yogurt',
            date: 159,
            address: 6.0,
            contact: 24,
          },
          {
            name: 'Ice cream sandwich',
            date: 237,
            address: 9.0,
            contact: 37,
          },
          {
            name: 'Eclair',
            date: 262,
            address: 16.0,
            contact: 23,
          },
          {
            name: 'Eclair',
            date: 262,
            address: 16.0,
            contact: 23,
          },
          {
            name: 'Eclair',
            date: 262,
            address: 16.0,
            contact: 23,
          },
        ]
      },

      editItem (item) {
        this.editedIndex = this.project.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.project.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.project.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.project[this.editedIndex], this.editedItem)
        } else {
          this.project.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>



