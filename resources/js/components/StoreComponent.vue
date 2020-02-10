<template>
  <v-data-table
    :headers="headers"
    :items="store"
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar dark color="cyan">
        <v-toolbar-title>Store</v-toolbar-title>
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
          dense
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" max-width="450px">
          <template v-slot:activator="{ on }">
            <v-btn color="blue" dark class="mb-2" v-on="on">New</v-btn>
          </template>

          <v-card>
            <v-card-title>
              <span class="headline">New Store</span>
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
                      :rules="idRules"
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
                        label="Type of Material"
                        :rules="typeRules"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.no_telp" 
                        label="Telp Number"
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
              <v-btn class="ma-2" rounded color="green" dark @click="reset();dialog=false">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" @click="addItem();dialog=false">Save</v-btn>
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
              <span class="headline">Edit Store</span>
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
                      :rules="idRules"
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
                        label="Type of Material"
                        :rules="typeRules"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.no_telp" 
                        label="Telp Number"
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
              <v-btn class="ma-2" rounded color="green" dark @click="reset();dialog3=false">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" @click="updateItem(Store.id_store);dialog3=false">Save</v-btn>
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
            <v-card-text>Are you sure want to delete this store?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Store.id_store)">Yes</v-btn>
              <v-btn color="red darken-1" text @click="reset(); dialog2=false">No</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>
    </template>
  </v-data-table>
</template>

<script>
import Controller from './../service/Store'

  export default {
    data: () => ({
      valid: true,
      dialog: false,
      dialog2: false,
      dialog3: false,
      search:'',
      store: [],
      Store: {
        kode:'',
        name:'',
        address: '',
        type: '',
        no_telp: '',
        phone: '',
        owner: '',
        id_store: '',
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
      idRules: [
        v => !!v || 'ID is required',
        v => (v && v.length <= 4) || 'ID must be less than 4 characters',
      ],
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
        v => !!v || 'Telp number is required',
        v => (v && !v.numeric) || 'Telp number must be numeric'
      ],
      ownerRules:[
        v => !!v || 'Owner is required'
      ]
    }),
    mounted(){
      this.getallItem()
    },
    computed: {

    },
    methods: {
      async getallItem(){
        try{
          this.store = (await Controller.getallItem()).data
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
      // close () {
      //   // this.reset()
      //   this.dialog = false
      //   this.dialog2 = false
      //   this.dialog3 = false
      //   this.getallItem()
      // },
    },
  }
</script>