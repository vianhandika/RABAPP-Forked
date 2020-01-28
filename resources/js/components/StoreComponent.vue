<template>
  <v-data-table
    :headers="headers"
    :items="store"
    :search="search"
    sort-by="date"
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
            
          <Vform>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Store.kode" 
                    label="ID Store"
                    :error-messages="idErrors"
                    @input="$v.Store.kode.$touch()"
                    @blur="$v.Store.kode.$touch()"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.name" 
                      label="Name"
                      :error-messages="nameErrors"
                      @input="$v.Store.name.$touch()"
                      @blur="$v.Store.name.$touch()"
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.address" 
                      label="Address"
                      :error-messages="addressErrors"
                      @input="$v.Store.address.$touch()"
                      @blur="$v.Store.address.$touch()"
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.type" 
                      label="Type of Material"
                      :error-messages="typeErrors"
                      @input="$v.Store.type.$touch()"
                      @blur="$v.Store.type.$touch()"
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.no_telp" 
                      label="Telp Number"
                      :error-messages="noErrors"
                      @input="$v.Store.no_telp.$touch()"
                      @blur="$v.Store.no_telp.$touch()"
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.phone" 
                      label="Phone Number"
                      :error-messages="phoneErrors"
                      @input="$v.Store.phone.$touch()"
                      @blur="$v.Store.phone.$touch()"
                    >
                      </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.owner" 
                      label="Owner"
                      :error-messages="ownerErrors"
                      @input="$v.Store.owner.$touch()"
                      @blur="$v.Store.owner.$touch()"
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
              <span class="headline">Edit Store</span>
            </v-card-title>
          
            <Vform>
              <v-card-text>
                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Store.kode" 
                      label="ID Store"
                      :error-messages="idErrors"
                      @input="$v.Store.kode.$touch()"
                      @blur="$v.Store.kode.$touch()"
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.name" 
                        label="Name"
                        :error-messages="nameErrors"
                        @input="$v.Store.name.$touch()"
                        @blur="$v.Store.name.$touch()"
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.address" 
                        label="Address"
                        :error-messages="addressErrors"
                        @input="$v.Store.address.$touch()"
                        @blur="$v.Store.address.$touch()"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.type" 
                        label="Type of Material"
                        :error-messages="typeErrors"
                        @input="$v.Store.type.$touch()"
                        @blur="$v.Store.type.$touch()"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.no_telp" 
                        label="Telp Number"
                        :error-messages="noErrors"
                        @input="$v.Store.no_telp.$touch()"
                        @blur="$v.Store.no_telp.$touch()"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.phone" 
                        label="Phone Number"
                        :error-messages="phoneErrors"
                        @input="$v.Store.phone.$touch()"
                        @blur="$v.Store.phone.$touch()"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Store.owner" 
                        label="Owner"
                        :error-messages="ownerErrors"
                        @input="$v.Store.owner.$touch()"
                        @blur="$v.Store.owner.$touch()"
                      >
                        </v-text-field>
                    </v-flex>
                  </v-layout>

              </v-card-text>
            </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(Store.id_store)">Save</v-btn>
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
                <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
              </v-card-actions>
            </v-card>
      </v-dialog>
    </template>

  </v-data-table>
</template>

<script>
import Controller from './../service/Store'
import validators from './../validations/Store'

  export default {
    validations: validators,
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      menu: false,
      select: null,
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
    }),
    mounted(){
      this.getallItem()
    },
    computed: {
      filteredStore:function(){
        return this.store.filter((storeData)=>{
          storeData.name.match(this.search)
        });
      },
      idErrors(){
        const errors = []
        if(!this.$v.Store.kode.$dirty) return errors 
        !this.$v.Store.kode.maxLength && errors.push('ID must be at most 255 characters long')
        !this.$v.Store.kode.minLength && errors.push('ID must be at least 4 characters long')
        !this.$v.Store.kode.required && errors.push('ID is required')
        return errors
      },
      nameErrors(){
        const errors = []
        if(!this.$v.Store.name.$dirty) return errors 
        !this.$v.Store.name.maxLength && errors.push('Name must be at most 255 characters long')
        !this.$v.Store.name.minLength && errors.push('Name must be at least 10 characters long')
        !this.$v.Store.name.required && errors.push('Name is required')
        return errors
      },
      addressErrors(){
        const errors = []
        if(!this.$v.Store.address.$dirty) return errors
        !this.$v.Store.address.maxLength && errors.push('Address must be at most 255 characters long')
        !this.$v.Store.address.minLength && errors.push('Address must be at least 10 characters long')
        !this.$v.Store.address.required && errors.push('Address is required')
        return errors
      },
      typeErrors(){
        const errors = []
        if(!this.$v.Store.type.$dirty) return errors
        !this.$v.Store.type.maxLength && errors.push('Type must be at most 255 characters long')
        !this.$v.Store.type.required && errors.push('Type is required')
        return errors
      },
      phoneErrors(){
        const errors = []
        if(!this.$v.Store.phone.$dirty) return errors
        !this.$v.Store.phone.maxLength && errors.push('Phone number must be at most 15 characters long')
        !this.$v.Store.phone.minLength && errors.push('Phone number must be at least 10 characters long')
        !this.$v.Store.phone.required && errors.push('Phone number is required')
        !this.$v.Store.phone.numeric && errors.push('Phone number must be numeric')
        return errors
      },
      noErrors(){
        const errors = []
        if(!this.$v.Store.no_telp.$dirty) return errors
        !this.$v.Store.no_telp.required && errors.push('Telp number is required')
        !this.$v.Store.no_telp.numeric && errors.push('Telp number must be numeric')
        !this.$v.Store.no_telp.maxLength && errors.push('Telp number must be at most 15 characters long')
        !this.$v.Store.no_telp.minLength && errors.push('Telp number must be at least 10 characters long')
        return errors
      },
      ownerErrors(){
        const errors = []
        if(!this.$v.Store.owner.$dirty) return errors
        !this.$v.Store.owner.maxLength && errors.push('Project must be at most 255 characters long')
        !this.$v.Store.owner.minLength && errors.push('Project must be at least 10 characters long')
        !this.$v.Store.owner.required && errors.push('Project is required')
        return errors
      },
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
                kode        : this.Store.kode,
                name        : this.Store.name,
                address     : this.Store.address,
                no_telp     : this.Store.no_telp,
                phone       : this.Store.phone,
                type        : this.Store.type,
                owner       : this.Store.owner
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
        this.Store = item
        console.log(this.Store)
      },
      refresh(){
        this.Store.kode = '';
        this.Store.name     = '';
        this.Store.address  = '';
        this.Store.no_telp  = '';
        this.Store.phone  = '';
        this.Store.owner  = '';
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>