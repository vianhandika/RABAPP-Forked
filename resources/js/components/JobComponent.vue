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
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" @click="reset" v-on="on">New</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">New Task</span>
                </v-card-title>
                
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-text>
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.kode" 
                        label="ID Task"
                        :rules="idRules"
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

                    <v-container row>
                      <v-select row
                        v-model="Job.satuan"
                        :items="satuan"
                        item-text="name"
                        item-value="name"
                        label="Satuan"
                        :rules="satuanRules"
                      ></v-select>
                      <v-btn 
                        width="50px" 
                        color="blue" 
                        @click="dialog4=true"
                      > 
                      Add
                      </v-btn>
                    </v-container>

                    <template>
                    <v-dialog v-model="dialog4" width="300px" style="color: blue">
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            label="Satuan"
                            v-model="name"
                          >
                          </v-text-field>
                        </v-layout>
                        <div class="flex-grow-1"></div>
                          <v-btn class="ma-2" rounded color="green" dark @click="dialog4=false">Cancel</v-btn>
                          <v-btn class="ma-2" rounded color="orange" dark @click="addSatuan()">Save</v-btn>                  
                      </v-card-text>
                    </v-dialog>
                    </template>

                    <v-select row
                        v-model="Job.status"
                        :items="items"
                        label="Status"
                        :rules="statusRules"
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
                  <v-btn class="ma-2" rounded color="orange" :disabled="!valid" dark @click="addItem()">Save</v-btn>
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
                  <span class="headline">Edit Task</span>
                </v-card-title>
              
                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-card-text>
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Job.kode" 
                          label="ID Task"
                          :rules="idRules"
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

                      <v-container row>
                        <v-select row
                          v-model="Job.satuan"
                          :items="satuan"
                          item-text="name"
                          item-value="name"
                          label="Satuan"
                          :rules="satuanRules"
                        ></v-select>
                        <v-btn 
                          width="50px" 
                          color="blue" 
                          @click="dialog4=true"
                        > 
                        Add
                        </v-btn>
                      </v-container>

                      <template>
                      <v-dialog v-model="dialog4" width="300px" style="color: blue">
                        <v-card-text>
                          <v-layout>
                            <v-text-field
                              label="Satuan"
                              v-model="name"
                            >
                            </v-text-field>
                          </v-layout>
                          <div class="flex-grow-1"></div>
                            <v-btn class="ma-2" rounded color="green" dark @click="dialog4=false">Cancel</v-btn>
                            <v-btn class="ma-2" rounded color="orange" dark @click="addSatuan()">Save</v-btn>                  
                        </v-card-text>
                      </v-dialog>
                      </template>

                      <v-select row
                          v-model="Job.status"
                          :items="items"
                          label="Status"
                          :rules="statusRules"
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
                  <v-btn class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(Job.id_job)">Save</v-btn>
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
    
  </v-app>
  
</template>

<script>
import Controller from './../service/Job'

  export default {
    data: () => ({
      valid: true,
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      menu: false,
      select: null,
      row: null,
      search:'',
      satuan:'',
      items : [
        'Volume',
        'Price'
      ],
      job: [],
      Job: {
        kode:'',
        name:'',
        satuan: '',
        details: '',
        id_job: '',
        status: ''
      },
      satuan: [],
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
          text: 'Satuan', 
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
      idRules: [
        v => !!v || 'ID is required',
        v => (v && v.length <= 4) || 'ID must be less than 4 characters',
      ],
      nameRules: [
        v => !!v || 'Name is required',
      ],
      satuanRules: [
        v => !!v || 'Satuan is required',
      ],
      statusRules:[
        v => !!v || 'Status is required'
      ],
      specRules: [
        v => !!v || 'Spesification is required'
      ],
    }),
    mounted(){
      this.getSatuan()
      this.getallItem()
    },
    computed: {
      
    },
    methods: {
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
      async addItem(){
        try{
          const payload = {
            kode        : this.Job.kode,
            name        : this.Job.name,
            satuan      : this.Job.satuan,
            status      : this.Job.status,
            details     : this.Job.details,
          }
          await Controller.addItem(payload)
          this.close()
        }catch(err){
          console.log(err);
        }
      },
      async addSatuan()
      {
        try{
          const payload = {
            name :  this.name,
          }
          await Controller.addSatuan(payload)
          this.getSatuan()
          this.dialog4 = false
          this.name = ''
        }catch(err){
          console.log(err)
        }
      },
      async updateItem(id){
        try{
            const payload = {
              kode        : this.Job.kode,
              name        : this.Job.name,
              satuan      : this.Job.satuan,
              status      : this.Job.status,
              details     : this.Job.details,
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
        this.Job = item
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