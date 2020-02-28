<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="material"
        :pagination.sync="pagination"
        sortBy="status"
        update: sort-desc    
        :search="search"
        sort-by="date"
        class="elevation-8"
      >
      <template v-slot:item.price="{ item }">
        <v-layout>
          Rp.
          <v-spacer></v-spacer>
          {{ Number(item.price).toLocaleString('id-ID') }}
        </v-layout>
      </template>
      
        <template v-slot:top>
          <v-toolbar dark color="light-blue accent-3">
            <v-toolbar-title>Materials/Labor</v-toolbar-title>
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
                  <span class="headline">New Materials/Labor</span>
                </v-card-title>
                
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-text>
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Material.kode" 
                        label="ID"
                        readonly
                      >
                      </v-text-field>
                    </v-flex>

                    <v-radio-group v-model="Material.status" row :rules="statusRules">
                      <v-radio label="Material" value="material"></v-radio>
                      <v-radio label="Labor" value="labor"></v-radio>
                    </v-radio-group>
                  </v-layout>

                  <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.name" 
                          label="Name"
                          required
                          :rules="nameRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                        <v-flex>
                          <v-text-field
                            v-model="Material.type"
                            label="Type"
                            required
                            :rules="typeRules"
                          >
                          </v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-container row>
                      <v-select row
                        v-model="Material.satuan"
                        :items="satuan"
                        item-text="name"
                        item-value="name"
                        label="Satuan"
                        required
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
                            v-model="name">
                          </v-text-field>
                        </v-layout>
                        <div class="flex-grow-1"></div>
                          <v-btn class="ma-2" rounded color="green" dark @click="dialog4=false">Cancel</v-btn>
                          <v-btn class="ma-2" rounded color="orange" dark @click="addSatuan()">Save</v-btn>                  
                      </v-card-text>
                    </v-dialog>
                    </template>
                    
                    <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Material.price"
                            label="Price"
                            required
                            :rules="priceRules"
                          >
                          </v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.spesification" 
                          label="Spesification"
                          required
                          :rules="specRules"
                        >
                          </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-select
                        v-model="Material.store"
                        :items="store"
                        item-text="name"
                        item-value="id_store"
                        label="Store"
                        :rules="storeRules"
                      >
                      </v-select>
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
                  <span class="headline">Edit Materials/Labor</span>
                </v-card-title>
              
                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-card-text>
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.kode" 
                          label="ID"
                          readonly
                        >
                        </v-text-field>
                      </v-flex>

                      <v-radio-group v-model="Material.status" row :rules="statusRules">
                        <v-radio label="Material" value="material"></v-radio>
                        <v-radio label="Labor" value="labor"></v-radio>
                      </v-radio-group>
                    </v-layout>

                    <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Material.name" 
                            label="Name"
                            required
                            :rules="nameRules"
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                          <v-flex>
                            <v-text-field
                              v-model="Material.type"
                              label="Type"
                              required
                              :rules="typeRules"
                            >
                            </v-text-field>
                          </v-flex>
                      </v-layout>

                      <v-container row>
                        <v-select row
                          v-model="Material.satuan"
                          :items="satuan"
                          item-text="name"
                          item-value="name"
                          label="Satuan"
                          required
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
                              v-model="name">
                            </v-text-field>
                          </v-layout>
                          <div class="flex-grow-1"></div>
                            <v-btn class="ma-2" rounded color="green" dark @click="dialog4=false">Cancel</v-btn>
                            <v-btn class="ma-2" rounded color="orange" dark @click="addSatuan()">Save</v-btn>                  
                        </v-card-text>
                      </v-dialog>
                      </template>
                      
                      <v-layout>
                          <v-flex>
                            <v-text-field 
                              v-model="Material.price"
                              label="Price"
                              required
                              :rules="priceRules"
                            >
                            </v-text-field>
                          </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Material.spesification" 
                            label="Spesification"
                            required
                            :rules="specRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="Material.id_store"
                          :items="store"
                          item-text="name"
                          item-value="id_store"
                          label="Store"
                          :rules="storeRules"
                        >
                        </v-select>
                      </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(Material.id_material)">Save</v-btn>
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
                    <v-card-text>Are you sure want to delete this material/labor?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Material.id_material)">Yes</v-btn>
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
import Controller from './../service/Material'
import jobController from './../service/Job'
import storeController from './../service/Store'

  export default {
    data: () => ({
      valid: true,
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      menu: false,
      select: null,
      search:'',
      material: [],
      satuan: [],
      store:[],
      
      Material: {
        store:'',
        kode: '',
        name:'',
        type: '',
        price: 0,
        spesification: '',
        satuan: '',
        status: '',
      },
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
        },
        {
          text: 'Status',
          align: 'left',
          sortable: false,
          value: 'status',
        },
        {
          text: 'Name',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Type', 
          value: 'type'
        },
        {
          sortable: false,
          text: 'Price',
          value: 'price',
          width: '11%',
        },
        {
          sortable: false,
          text: 'Satuan',
          value: 'satuan'
        },
        { 
          sortable: false,
          text: 'Spesification', 
          value: 'spesification'
        },
        { 
          sortable: false,
          text: 'Store', 
          value: 'store'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      //validation
      statusRules:[
        v => !!v || 'Status is required'
      ],
      nameRules: [
        v => !!v || 'Name is required',
      ],
      typeRules:[
        v => !!v || 'Type is required'
      ],
      priceRules:[
        v => !!v || 'Price is required',
        v => (v && !v.numeric) || 'Price must be numeric'
      ],
      satuanRules: [
        v => !!v || 'Satuan is required',
      ],
      specRules: [
        v => !!v || 'Spesification is required'
      ],
      storeRules: [
        v => !!v || 'Store is required'
      ],
    }),
    mounted(){
      this.getStore()
      this.getSatuan()
      this.getallItem()
    },
    computed: {
    },
    methods: {
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
      async getSatuan()
      {
        try{
          this.satuan = (await Controller.getSatuan()).data
        }catch(err){
          console.log(err)
        }
      },
      async getStore()
      {
        try{
          this.store = (await storeController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.material = (await Controller.getallItem()).data
          this.Material.kode = "M/L-0"+(this.material.length+1)
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            id_store        : this.Material.store,
            kode            : this.Material.kode,
            name            : this.Material.name,
            price           : this.Material.price,
            type            : this.Material.type,
            satuan          : this.Material.satuan,
            status          : this.Material.status,
            spesification   : this.Material.spesification
          }
          await Controller.addItem(payload)
          this.close()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              id_store        : this.Material.store,
              kode            : this.Material.kode,
              name            : this.Material.name,
              price           : this.Material.price,
              type            : this.Material.type,
              satuan          : this.Material.satuan,
              status          : this.Material.status,
              spesification   : this.Material.spesification
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
        this.Material = item
        console.log(this.Material)
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