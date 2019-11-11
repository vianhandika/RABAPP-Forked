<template>
  <v-data-table
    :headers="headers"
    :items="material"
    :search="search"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
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
                    label="ID Material"
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

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Material.spesification_1" 
                      label="Spesification I"
                      required
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Material.spesification_2" 
                      label="Spesification II"
                      required
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

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
                      label="ID Material"
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

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Material.spesification_1" 
                      label="Spesification I"
                      required
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Material.spesification_2" 
                      label="Spesification II"
                      required
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

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

  export default {
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      menu: false,
      select: null,
      search:'',
      id_material: '',
      kode:'',
      name:'',
      type: '',
      price: 0,
      spesification_1: '',
      spesification_2: '',
      material: [],
      Material: {
        id_material: '',
        kode: '',
        name:'',
        type: '',
        price: 0,
        spesification_1: '',
        spesification_2: '',
      },
      items: [
        'm',
        'm2',
        'm3',
        'btg',
        'bh',
        'kg',
        'Oh'
      ],
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
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
          text: 'Spesification I',
          value: 'spesification_1'
        },
        {
          sortable: false,
          text: 'Spesification II',
          value: 'spesification_2'
        },
        { 
          sortable: false,
          text: 'Price', 
          value: 'price'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
    }),
    mounted(){
      this.getallItem()
    },
    computed: {
      filteredMaterials:function(){
        return this.material.filter((materialData)=>{
          materialData.name.match(this.search);
        });
      }
    },
    methods: {
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
            kode            : this.Material.kode,
            name            : this.Material.name,
            price           : this.Material.price,
            type            : this.Material.type,
            coefficient     : this.Material.coefficient,
            sat_conversion  : this.Material.sat_conversion,
            spesification_1 : this.Material.spesification_1,
            spesification_2 : this.Material.spesification_2
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
                kode            : this.Material.kode,
                name            : this.Material.name,
                price           : this.Material.price,
                type            : this.Material.type,
                coefficient     : this.Material.coefficient,
                sat_conversion  : this.Material.sat_conversion,
                spesification_1 : this.Material.spesification_1,
                spesification_2 : this.Material.spesification_2
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
      },
      refresh(){
        this.Material.kode     = '';
        this.Material.name     = '';
        this.Material.price  = 0;
        this.Material.type = '',
        this.Material.coefficient = 0,
        this.Material.sat_conversion= '',
        this.Material.spesification_1 = ''
        this.Material.spesification_2 = ''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>