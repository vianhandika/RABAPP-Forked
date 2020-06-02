<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="job"
        :search="search"
        sort-by="date"
        class="elevation-8"
      >
        <template v-slot:top>
          <v-toolbar dark color="light-blue accent-3">
            <v-toolbar-title>Task</v-toolbar-title>
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
                  <span class="headline" v-if="!edit">New Task</span>
                  <span class="headline" v-if="edit">Edit Task</span>
                </v-card-title>
                
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-text>
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.kode" 
                        label="ID Task"
                        readonly
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.name" 
                        label="Name"
                        :rules="nameRules"
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                    <v-select row
                      v-model="Job.id_satuan"
                      :items="satuan"
                      item-text="name"
                      item-value="id_satuan"
                      label="Unit"
                      :rules="satuanRules"
                      append-icon="expand_more"
                    ></v-select>
                      
                    <v-select row
                      v-model="Job.status"
                      :items="items"
                      label="Status"
                      :rules="statusRules"
                      append-icon="expand_more"
                    ></v-select>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Job.details" 
                          label="Spesification"
                          :rules="specRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>
                </v-card-text>
              </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="addItem()">Save</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(Job.id_job)">Save</v-btn>
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
            @click="itemHandler(item);edit=true;dialog=true"
          >
            edit
          </v-icon>

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
                    <v-card-text>Are you sure want to delete this task?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Job.id_job)">Yes</v-btn>
                    <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
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
import Controller from './../service/Job'

  export default {
    data: () => ({
      snack: false,
      snackColor: '',
      snackText: '',
      y: 'top',
      search:'',
      valid: true,
      dialog: false,
      dialog2: false,
      edit: false,
      items : [
        'Volume',
        'Price'
      ],
      job: [],
      satuan: [],
      Job: {
        kode:'',
        name:'',
        id_satuan: '',
        details: '',
        id_job: '',
        status: ''
      },
      JobDefault: {
        kode:'',
        name:'',
        id_satuan: '',
        details: '',
        id_job: '',
        status: ''
      },
      headers: [
        {
          text : 'ID',
          sortable: false,
          value : 'kode'
        },
        {
          text: 'Item',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Unit', 
          value: 'satuan'
        },
        {
          sortable: false,
          text: 'Status',
          value: 'status'
        },
        { 
          sortable: false,
          text: 'Spesification', 
          value: 'details'
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
      satuanRules: [
        v => !!v || 'Unit is required',
      ],
      statusRules:[
        v => !!v || 'Status is required'
      ],
      specRules: [
        v => !!v || 'Spesification is required'
      ],
    }),
    mounted(){
      this.getallItem()
      this.getSatuan()
      this.getKode()
    },
    computed: {
      
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
      async getSatuan()
      {
        try{
          this.satuan = (await Controller.getSatuan()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.job = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getKode()
      {
        try{
          this.Job.kode = (await Controller.getKode())
          console.log(this.Job.kode)
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        console.log('satuan',this.Job.id_satuan)
        try{
          const payload = {
            kode        : this.Job.kode,
            name        : this.Job.name,
            satuan      : this.Job.id_satuan,
            status      : this.Job.status,
            details     : this.Job.details,
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
        console.log(this.Job.id_satuan)
        try{
          const payload = {
            kode        : this.Job.kode,
            name        : this.Job.name,
            satuan      : this.Job.id_satuan,
            status      : this.Job.status,
            details     : this.Job.details,
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
        this.Job = item
        console.log(this.Job)
      },
      reset(){
        this.getallItem()
        this.$refs.form.resetValidation()
        this.Job = Object.assign({},this.JobDefault)
      },
      close () {
        this.getallItem()
        this.dialog = false
        this.edit = false
      },
    },
  }
</script>