<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="store"
        :search="search"
        class="elevation-8"
      >
        <template v-slot:top>
          <v-toolbar dark color="light-blue accent-3">
            <v-toolbar-title>Store</v-toolbar-title>
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
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" v-on="on" @click="reset">New</v-btn>
              </template>

              <v-card>
                <v-card-title>
                  <span class="headline" v-if="!edit">New Store</span>
                  <span class="headline" v-if="edit">Edit Store</span>
                </v-card-title>
                
                <v-form 
                  ref="form"
                  lazy-validation
                  v-model="valid"
                  > 
                  <v-card-text>
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Store.kode" 
                          label="ID Store"
                          readonly
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.name" 
                            label="Name"
                            :rules="nameRules"
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.address" 
                            label="Address"
                            :rules="addressRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.type" 
                            label="Type of Materials"
                            :rules="typeRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.no_telp" 
                            label="Telephone Number"
                            :rules="noRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.phone" 
                            label="Phone Number"
                            :rules="phoneRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.owner" 
                            label="Owner"
                            :rules="ownerRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="dialog=false">Cancel</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" v-if="!edit" @click="addItem();dialog=false">Save</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" v-if="edit" @click="updateItem(Store.id_store);dialog=false">Save</v-btn>
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
                <v-card-text>Are you sure want to delete this store?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(Store.id_store)">Yes</v-btn>
                  <v-btn color="red darken-1" text @click="dialogDelete=false">No</v-btn>
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
import Controller from './../service/Store'

  export default {
    data: () => ({
      snack: false,
      snackColor: '',
      snackText: '',
      y: 'top',

      valid: true,
      dialog: false,
      dialogDelete: false,
      edit: false,
      search:'',
      store: [],
      Store: {
        id_store: '',
        kode:'',
        name:'',
        address: '',
        type: '',
        no_telp: '',
        phone: '',
        owner: '',
      },
      headers: [
        {
          text : 'ID',
          sortable: false,
          value : 'kode'
        },
        {
          text: 'Name',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Address', 
          value: 'address'
        },
        { 
          sortable: false,
          text: 'Type of Materials', 
          value: 'type'
        },
        { 
          sortable: false,
          text: 'Telp Number', 
          value: 'no_telp'
        },
        { 
          sortable: false,
          text: 'Phone Number', 
          value: 'phone'
        },
        { 
          sortable: false,
          text: 'Owner', 
          value: 'owner'
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
      typeRules: [
        v => !!v || 'Type is required'
      ],
      phoneRules: [
        v => !!v || 'Phone is required',
        v => (v && !v.numeric) || 'Phone number must be numeric'
      ],
      noRules: [
        v => !!v || 'Telephone number is required',
        v => (v && !v.numeric) || 'Telephone number must be numeric'
      ],
      ownerRules:[
        v => !!v || 'Owner is required'
      ]
    }),
    mounted(){
      this.getallItem()
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
      async getallItem(){
        try{
          this.store = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getKode()
      {
        try{
          this.Store.kode = await Controller.getKode()
          console.log(this.Store.kode) 
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            kode        : this.Store.kode,
            name        : this.Store.name,
            address     : this.Store.address,
            no_telp     : this.Store.no_telp,
            phone       : this.Store.phone,
            type        : this.Store.type,
            owner       : this.Store.owner
          }
          await Controller.addItem(payload)
          this.reset()
          this.save()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              kode        : this.Store.kode,
              name        : this.Store.name,
              address     : this.Store.address,
              no_telp     : this.Store.no_telp,
              phone       : this.Store.phone,
              type        : this.Store.type,
              owner       : this.Store.owner
            } 
            await Controller.updateItem(payload,id)
            this.reset()
            this.update()
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await Controller.deleteItem(id).data
          this.getallItem()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(item){
        this.Store = item
        console.log(this.Store)
      },
      resetForm(){
        this.$refs.form.reset()
      },
      resetValidation(){
        this.$refs.form.resetValidation()
      },
      reset()
      {
        this.getallItem()
        this.resetForm()
        this.resetValidation()
      },
    },
  }
</script>