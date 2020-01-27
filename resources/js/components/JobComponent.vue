<template>
  <v-data-table
    :headers="headers"
    :items="job"
    :search="search"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar color="cyan">
        <v-toolbar-title>Task</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <v-text-field
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="search"
            label="Search"
            class="hidden-sm-and-down"
            color="blue"
            v-model="search"
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" max-width="450px">
          <template v-slot:activator="{ on }">
            <v-btn color="blue" dark class="mb-2" v-on="on">New</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">New Task</span>
            </v-card-title>
            
          <Vform>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Job.kode" 
                    label="ID Task"
                    :error-messages="idErrors"
                    @input="$v.Job.kode.$touch()"
                    @blur="$v.Job.kode.$touch()"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Job.name" 
                      label="Name"
                      :error-messages="nameErrors"
                      @input="$v.Job.name.$touch()"
                      @blur="$v.Job.name.$touch()"
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
                    :error-messages="satuanErrors"
                    @input="$v.Job.satuan.$touch()"
                    @blur="$v.Job.satuan.$touch()"
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

                <!-- <v-radio-group v-model="Job.status" row> 
                  <v-radio label="Volume" value="v"></v-radio>
                  <v-radio label="Price" value="p"></v-radio>
                </v-radio-group> -->

                <v-select row
                    v-model="Job.status"
                    :items="items"
                    label="Status"
                    :error-messages="statusErrors"
                    @input="$v.Job.status.$touch()"
                    @blur="$v.Job.status.$touch()"
                  ></v-select>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Job.details" 
                      label="Spesification"
                      :error-messages="detailsErrors"
                      @input="$v.Job.details.$touch()"
                      @blur="$v.Job.details.$touch()"
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>
            </v-card-text>
          </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="addItem()">Save</v-btn>
            </v-card-actions>
          </v-card>

        </v-dialog>
      </v-toolbar>
    </template>

    <template v-slot:item.action="{ item }">
      <v-dialog v-model="dialog3" max-width="450px">
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
          
            <Vform>
              <v-card-text>
                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Job.kode" 
                      label="ID Task"
                      :error-messages="idErrors"
                      @input="$v.Job.kode.$touch()"
                      @blur="$v.Job.kode.$touch()"
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.name" 
                        label="Name"
                        :error-messages="nameErrors"
                        @input="$v.Job.name.$touch()"
                        @blur="$v.Job.name.$touch()"
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
                      :error-messages="satuanErrors"
                      @input="$v.Job.satuan.$touch()"
                      @blur="$v.Job.satuan.$touch()"
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

                  <!-- <v-radio-group v-model="Job.status" row> 
                    <v-radio label="Volume" value="v"></v-radio>
                    <v-radio label="Price" value="p"></v-radio>
                  </v-radio-group> -->

                  <v-select row
                      v-model="Job.status"
                      :items="items"
                      label="Status"
                      :error-messages="statusErrors"
                      @input="$v.Job.status.$touch()"
                      @blur="$v.Job.status.$touch()"
                    ></v-select>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.details" 
                        label="Spesification"
                        :error-messages="detailsErrors"
                        @input="$v.Job.details.$touch()"
                        @blur="$v.Job.details.$touch()"
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>
              </v-card-text>
            </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(Job.id_job)">Save</v-btn>
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
</template>

<script>
import Controller from './../service/Job'
import validators from './../validations/Job'

  export default {
    validations: validators,
    data: () => ({
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
    }),
    mounted(){
      this.getSatuan()
      this.getallItem()
    },
    computed: {
      idErrors(){
        const errors = []
        if(!this.$v.Job.kode.$dirty) return errors 
        !this.$v.Job.kode.maxLength && errors.push('ID must be at most 255 characters long')
        !this.$v.Job.kode.minLength && errors.push('ID must be at least 4 characters long')
        !this.$v.Job.kode.required && errors.push('ID is required')
        return errors
      },
      nameErrors(){
        const errors = []
        if(!this.$v.Job.name.$dirty) return errors 
        !this.$v.Job.name.maxLength && errors.push('Name must be at most 255 characters long')
        !this.$v.Job.name.minLength && errors.push('Name must be at least 10 characters long')
        !this.$v.Job.name.required && errors.push('Name is required')
        return errors
      },
      satuanErrors(){
        const errors = []
        if(!this.$v.Job.satuan.$dirty) return errors 
        !this.$v.Job.satuan.required && errors.push('Satuan is required')
        return errors
      },
      detailsErrors(){
        const errors = []
        if(!this.$v.Job.details.$dirty) return errors 
        !this.$v.Job.details.maxLength && errors.push('Details must be at most 255 characters long')
        !this.$v.Job.details.minLength && errors.push('Details must be at least 10 characters long')
        !this.$v.Job.details.required && errors.push('Details is required')
        return errors
      },
      statusErrors(){
        const errors = []
        if(!this.$v.Job.status.$dirty) return errors 
        !this.$v.Job.status.required && errors.push('Status is required')
        return errors
      },
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
          this.getallItem()
          this.close()
          this.refresh()
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
            this.getallItem()
            this.close()
            this.refresh()
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
      refresh(){
        this.Job.kode = '';
        this.Job.name     = '';
        this.Job.details  = '';
        this.Job.satuan  = '';
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>