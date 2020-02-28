<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="project"
        :search="search"
        class="elevation-8"
      >
      <template v-slot:item.date="{ item }">
        {{ formatDate(item.date) }}
      </template>

      <template v-slot:item.nominal="{ item }">
        <v-layout>
          Rp.
          <v-spacer></v-spacer>
          {{ Number(item.nominal).toLocaleString('id-ID') }}
        </v-layout>
      </template>

        <template v-slot:top>
          <v-toolbar dark color="light-blue accent-3">
            <v-toolbar-title>Project</v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>

            <v-text-field
              v-model="search"
              append-icon="search"
              label="Search"
              single-line
              hide-details
              style="width: 5px"
            >
            </v-text-field>
          
            <div class="flex-grow-1"></div>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" @click="reset();getallItem()" v-on="on">New</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">New Project</span>
                </v-card-title>

              <v-form ref="form" lazy-validation v-model="valid">
                <v-card-text>
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Project.kode" 
                        label="ID Project"
                        readonly
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Project.project" 
                        label="Project"
                        :rules="nameRules"
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field
                        v-model="Project.address"
                        label="Address"
                        :rules="addressRules"
                        ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Project.owner" 
                        label="Owner"
                        :rules="ownerRules"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex xs12>
                      <v-menu 
                      ref="menu1"
                      v-model="menu1"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      max-width="290px"
                      min-width="290px"
                    >

                    <template v-slot:activator="{ on }">
                      <v-text-field
                        label="Date"
                        required
                        v-on="on"
                        :rules="dateRules"
                        :value="dateFormat"
                      ></v-text-field>
                    </template>
                      <v-date-picker v-model="Project.date" @input="menu1 = false"></v-date-picker>
                    </v-menu>
                    </v-flex>
                  </v-layout>
          
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Project.no_telp" 
                        label="Telp Number"
                        :rules="noRules"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Project.phone" 
                        label="Phone Number"
                        :rules="phoneRules"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field
                        v-model="Project.type"
                        label="Type"
                        :rules="typeRules"
                        ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field
                        v-model="Project.nominal"
                        label="Nominal"
                        :rules="nominalRules"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-card-text>
              </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" @click="addItem()">Save</v-btn>
                </v-card-actions>
              </v-card>

            </v-dialog>
          </v-toolbar>
        </template>

        <template v-slot:item.action="{ item }">
          <v-dialog v-model="dialog3" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-icon
                small
                class="mr-2"
                color="green"
                @click="itemHandler(item)"
                v-on="on"
              >
                edit
              </v-icon>
            </template>
              <v-card>
                <v-card-title>
                  <span class="headline">Edit Project</span>
                </v-card-title>
              
                <v-form ref="form" lazy-validation v-model="valid">
                  <v-card-text>
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.kode" 
                          label="ID Project"
                          readonly
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.project" 
                          label="Project"
                          :rules="nameRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="Project.address"
                          label="Address"
                          :rules="addressRules"
                          ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.owner" 
                          label="Owner"
                          :rules="ownerRules"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex xs12>
                        <v-menu 
                        ref="menu2"
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        max-width="290px"
                        min-width="290px"
                      >

                      <template v-slot:activator="{ on }">
                        <v-text-field
                          label="Date"
                          required
                          v-on="on"
                          :rules="dateRules"
                          :value="dateFormat"
                        ></v-text-field>
                      </template>
                        <v-date-picker v-model="Project.date" no-title @input="menu2 = false"></v-date-picker>
                      </v-menu>
                      </v-flex>
                    </v-layout>
            
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.no_telp" 
                          label="Telephone Number"
                          :rules="noRules"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.phone" 
                          label="Phone Number"
                          :rules="phoneRules"
                        >
                          </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="Project.type"
                          label="Type"
                          :rules="typeRules"
                          ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="Project.nominal"
                          label="Nominal"
                          :rules="nominalRules"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" @click="updateItem(Project.id_project)">Save</v-btn>
                </v-card-actions>
              </v-card>
          </v-dialog>

          <v-dialog v-model="dialog2" max-width="290px">
            <template v-slot:activator="{ on }">
              <v-icon
                small
                color="red"
                v-on="on"
                @click="itemHandler(item)"
              >
                delete
              </v-icon>
            </template>
                <v-card>
                  <v-card-title class="headline">Confirmation</v-card-title>
                    <v-card-text>Are you sure want to delete this project?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Project.id_project)">Yes</v-btn>
                    <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
                  </v-card-actions>
                </v-card>
          </v-dialog>
        </template>
      </v-data-table>
    </v-container>
  </v-app>
</template>

<script>
import Controller from './../service/Project'
import format from 'date-fns/format'
import parse from 'date-fns/parse'
import { parseISO } from 'date-fns'

  export default {
    data: () => ({
      valid: true,
      dialog: false,
      dialog2: false,
      dialog3: false,
      menu: false,
      menu1: false,
      menu2: false,
      search:'',
      
      project: [],
      Project: {
        id_project: '',
        project:'',
        address: '',
        owner: '',
        date: new Date().toISOString().substr(0, 10),
        no_telp: '',
        phone: '',
        type: '',
        nominal: 0,
        kode: ''
      },
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
          width: '7%'
        },
        {
          text: 'Project',
          align: 'left',
          sortable: false,
          value: 'project',
        },
        { 
          sortable: false,
          text: 'Address', 
          value: 'address'
        },
        { 
          sortable: false,
          text: 'Owner', 
          value: 'owner'
        },
        { 
          sortable: false,
          text: 'Date', 
          value: 'date',
          width: '12%'
        },
        { 
          sortable: false,
          text: 'Telp Number', 
          value: 'no_telp',
          align: 'left'
        },
        { 
          sortable: false,
          text: 'Phone Number', 
          value: 'phone',
          align: 'left'
        },
        { 
          sortable: false,
          text: 'Type', 
          value: 'type',
          align: 'center'
        },
        { 
          sortable: false,
          text: 'Nominal', 
          value: 'nominal',
          width: '15%'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      //validation
      nameRules: [
        v => !!v || 'Name is required',
      ],
      addressRules: [
        v => !!v || 'Address is required',
      ],
      ownerRules:[
        v => !!v || 'Owner is required'
      ],
      contactRules: [
        v => !!v || 'Contact is required'
      ],
      phoneRules: [
        v => !!v || 'Phone is required',
        v => (v && !v.numeric) || 'Phone number must be numeric'
      ],
      dateRules: [
        v => !!v || 'Date is required'
      ],
      noRules: [
        v => !!v || 'Telephone number is required',
        v => (v && !v.numeric) || 'Telp number must be numeric'
      ],
      typeRules: [
        v => !!v || 'Type is required'
      ],
      nominalRules: [
        v => !!v || 'Nominal is required',
        v => (v && !v.numeric) || 'Nominal number must be numeric'
      ],
    }),
    mounted(){
      this.getallItem()
    },
    computed: {
      dateFormat(){
        let date = parseISO(this.Project.date)
        return this.Project.date ? format(date, 'dd MMMM yyyy',) : ''
      },
    },
    methods: {
      formatDate(item)
      {
        let date = parseISO(item)
        return item ? format(date,'dd MMM yyyy') : ''
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
          this.Project.kode = 'Pr-0'+(this.project.length+1)
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            kode        : this.Project.kode,
            name        : this.Project.project,
            address     : this.Project.address,
            owner       : this.Project.owner,
            date        : this.Project.date,
            no_telp     : this.Project.no_telp,
            phone       : this.Project.phone,
            type        : this.Project.type,
            nominal     : this.Project.nominal
          }
          await Controller.addItem(payload)
          // showAlert
          this.close()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              name        : this.Project.project,
              address     : this.Project.address,
              owner       : this.Project.owner,
              date        : this.Project.date,
              no_telp     : this.Project.no_telp,
              phone       : this.Project.phone,
              type        : this.Project.type,
              nominal     : this.Project.nominal,
              kode        : this.Project.kode
            } 
            await Controller.updateItem(payload,id)
            this.close()
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await Controller.deleteItem(id).data
          this.getallItem()
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(item){
        this.Project = item
        console.log(this.Project)
      },
      reset(){
        this.resetForm()
        this.resetValidation()
      },
      resetForm(){
        this.$refs.form.reset()
      },
      resetValidation(){
        this.$refs.form.resetValidation()
      },
      close () {
        this.dialog = false
        this.dialog3 = false
        this.getallItem()
      },
    },
  }
</script>

<style>

</style>