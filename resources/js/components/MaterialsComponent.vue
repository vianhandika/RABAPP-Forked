<template>
  <v-data-table
    :headers="headers"
    :items="material"
    :pagination.sync="pagination"
    sortBy="status"
    update: sort-desc    
    :search="search"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar dark color="cyan">
        <v-toolbar-title>Materials/Labor</v-toolbar-title>
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
              <span class="headline">New Materials/Labor</span>
            </v-card-title>
            
          <Vform>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Material.kode" 
                    label="ID"
                  >
                  </v-text-field>
                </v-flex>

                <v-radio-group v-model="Material.status" row>
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
                  label="Store">
                  </v-select>
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
              <span class="headline">Edit Material/Labor</span>
            </v-card-title>
          
            <Vform>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Material.kode" 
                    label="ID"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Material.name" 
                      label="Name"
                      required
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
                    required>
                  </v-select>
                </v-layout>
            </v-card-text>
          </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(Material.id_material)">Save</v-btn>
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
</template>

<script>
import Controller from './../service/Material'
import jobController from './../service/Job'
import storeController from './../service/Store'

  export default {
    data: () => ({
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
          value: 'price'
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
          this.getallItem()
          this.close()
          this.refresh()
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
        this.Material = item
        this.det
        console.log(this.Material)
      },
      refresh(){
        this.Material.kode     = '';
        this.Material.name     = '';
        this.Material.price  = 0;
        this.Material.type = '',
        this.Material.satuan = '',
        this.Material.id_store = '',
        this.Material.status= '',
        this.Material.spesification = ''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>