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
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" @click="reset();getKode()" v-on="on">New</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline" v-if="!edit">New Project</span>
                  <span class="headline" v-if="edit">Edit Project</span>
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
                        ref="menu"
                        v-model="menu"
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
                        <v-date-picker v-model="Project.date" @input="menu = false"></v-date-picker>
                      </v-menu>
                      </v-flex>
                    </v-layout>
            
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.no_telp" 
                          label="Telp Number"
                          :rules="noRules"
                          type="number"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Project.phone" 
                          label="Phone Number"
                          :rules="phoneRules"
                          type="number"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-select
                          v-model="Project.type"
                          label="Type"
                          :rules="typeRules"
                          :items="typeProject"
                          append-icon="expand_more"
                        >
                        </v-select>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="Project.nominal"
                          label="Nominal"
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" dark :disabled="!valid" @click="addItem()">Save</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" dark :disabled="!valid" @click="updateItem(Project.id_project)">Save</v-btn>
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
            @click="itemHandler(item);dialog=true;edit=true"
          >
            edit
          </v-icon>

          <v-dialog v-model="dialogDelete" max-width="290px">
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
                  <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(Project.id_project)">Yes</v-btn>
                  <v-btn color="red darken-1" text @click="dialogDelete = false">No</v-btn>
                </v-card-actions>
              </v-card>
          </v-dialog>
        </template>
      </v-data-table>
    </v-container>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
      <v-icon dark>done</v-icon>
      {{ snackText }}
    </v-snackbar>
  </v-app>
</template>

<script>
import Controller from './../service/Project'
import format from 'date-fns/format'
import parse from 'date-fns/parse'
import { parseISO } from 'date-fns'

  export default {
    data: () => ({
      snack: false,
      snackColor: '',
      snackText: '',
      y: 'top',
      
      valid: true,
      dialog: false,
      dialogDelete: false,
      menu: false,
      edit: false,
      search:'',
      typeProject:[
        'Rumah Tinggal',
        'Rumah Sakit',
        'Sekolah',
        'Kantor',
        'Hotel',
        'Mall',
        'Landscape',
        'Lain-lain'
      ],
      project: [],
      Project: {
        id_project: '',
        kode: '',
        project:'',
        address: '',
        owner: '',
        date: new Date().toISOString().substr(0, 10),
        no_telp: '',
        phone: '',
        type: '',
        nominal: 0
      },
      ProjectDefault: {
        id_project: '',
        kode: '',
        project:'',
        address: '',
        owner: '',
        date: new Date().toISOString().substr(0, 10),
        no_telp: '',
        phone: '',
        type: '',
        nominal: 0
      },
      headers: [
        {text: 'ID',align: 'left',sortable: false,value: 'kode',width: '8%'},
        {text: 'Project',align: 'left',sortable: false,value: 'project'},
        {text: 'Address',sortable: false,value: 'address'},
        {text: 'Owner',sortable: false,value: 'owner'},
        {text: 'Date', sortable: false,value: 'date',width: '12%'},
        {text: 'Telp Number', sortable: false,value: 'no_telp',align: 'left'},
        {sortable: false,text: 'Phone Number',value: 'phone',align: 'left'},
        {sortable: false,text: 'Type',value: 'type',align: 'center'},
        {sortable: false,text: 'Nominal',value: 'nominal',width: '15%'},
        {text: 'Actions',value: 'action',sortable: false,width: '8%' },
      ],
      //validation
      nameRules: [
        v => !!v || 'Name is required',
        v => v && v.length < 30 || 'Name must be at most 30 characters long'
      ],
      addressRules: [
        v => !!v || 'Address is required',
        v => v && v.length < 45 || 'Address must be at most 44 characters long'
      ],
      ownerRules:[
        v => !!v || 'Owner is required',
        v => v && v.length <= 35 || 'Owner must be at most 35 characters long'
      ],
      phoneRules: [
        v => !!v || 'Phone is required',
        v => v && v.length <= 15 || 'Phone must be at most 15 characters long',
      ],
      dateRules: [
        v => !!v || 'Date is required'
      ],
      noRules: [
        v => !!v || 'Telephone number is required',
        v => v && v.length <= 15 || 'Telephone number must be at most 15 characters long',
        // v => (v && !v.numeric) || 'Telp number must be numeric'
      ],
      typeRules: [
        v => !!v || 'Type is required',
      ],
    }),
    mounted(){
      this.getallItem()
      this.getKode()
    },
    computed: {
      dateFormat(){
        let date = parseISO(this.Project.date)
        return this.Project.date ? format(date, 'dd MMMM yyyy',) : ''
      },
    },
    methods: {
      save(){
        this.snack = true
        this.snackColor = 'green darken-1'
        this.snackText = 'Data Save Successfully'
      },
      update(){
        this.snack = true
        this.snackColor = 'teal darken-1'
        this.snackText = 'Data Update Successfully'
      },
      delete(){
        this.snack = true
        this.snackColor = 'red darken-1'
        this.snackText = 'Data Delete Successfully'
      },
      formatDate(item)
      {
        let date = parseISO(item)
        return item ? format(date,'dd MMM yyyy') : ''
      },
      async getKode()
      {
        try{
          this.Project.kode = await Controller.getKode()
          console.log(this.Project.kode) 
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
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
          await Controller.addItem(payload).then(()=>{
            this.close()
            this.save()
          })
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
          await Controller.updateItem(payload,id).then(()=>{
            this.close()
            this.update()
          })
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          (await Controller.deleteItem(id).data).then(()=>{
            this.getallItem()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(item){
        this.Project = item
      },
      reset(){
        this.getallItem()
        this.$refs.form.resetValidation()
        this.Project = Object.assign({},this.ProjectDefault)
      },
      close () {
        this.getallItem()
        this.dialog = false
        this.edit = false
      },
    },
  }
</script>

<style>
</style>