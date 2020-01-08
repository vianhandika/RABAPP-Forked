<template>
  <v-data-table
    :headers="headers"
    :items="project"
    :search="search"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Project</v-toolbar-title>
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
              <span class="headline">New Project</span>
            </v-card-title>
            
          <Vform>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.kode" 
                    label="ID Project"
                    :error-messages="idErrors"
                    @input="$v.Project.kode.$touch()"
                    @blur="$v.Project.kode.$touch()"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.name" 
                    label="Project"
                    :error-messages="nameErrors"
                    @input="$v.Project.name.$touch()"
                    @blur="$v.Project.name.$touch()"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.address"
                    label="Address"
                    :error-messages="addressErrors"
                    @input="$v.Project.address.$touch()"
                    @blur="$v.Project.address.$touch()"
                    ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.owner" 
                    label="Owner"
                    :error-messages="ownerErrors"
                    @input="$v.Project.owner.$touch()"
                    @blur="$v.Project.owner.$touch()"
                  ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex xs12>
                  <v-menu 
                  ref="menu1"
                  v-model="menu1"
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
                    v-model="Project.date"
                    label="Date"
                    required
                    v-on="on"
                    :error-messages="dateErrors"
                    @input="$v.Project.date.$touch()"
                    @blur="$v.Project.date.$touch()"
                  ></v-text-field>
                </template>
                  <v-date-picker v-model="Project.date" no-title @input="menu1 = false"></v-date-picker>
                </v-menu>
                </v-flex>
              </v-layout>
      
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.no_telp" 
                    label="Telp Number"
                    :error-messages="noErrors"
                    @input="$v.Project.no_telp.$touch()"
                    @blur="$v.Project.no_telp.$touch()"
                  ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.phone" 
                    label="Phone Number"
                    :error-messages="phoneErrors"
                    @input="$v.Project.phone.$touch()"
                    @blur="$v.Project.phone.$touch()"
                  >
                    </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.type"
                    label="Type"
                    :error-messages="typeErrors"
                    @input="$v.Project.type.$touch()"
                    @blur="$v.Project.type.$touch()"
                    ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.nominal"
                    label="Nominal"
                    :error-messages="nominalErrors"
                    @input="$v.Project.nominal.$touch()"
                    @blur="$v.Project.nominal.$touch()"
                  ></v-text-field>
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
              <span class="headline">Edit Project</span>
            </v-card-title>
          
            <Vform>
              <v-card-text>
                <v-layout>
                  <v-flex>
                    <v-text-field 
                      v-model="Project.kode" 
                      label="ID Project"
                      :error-messages="idErrors"
                      @input="$v.Project.kode.$touch()"
                      @blur="$v.Project.kode.$touch()"
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.name" 
                    label="Project"
                    :error-messages="nameErrors"
                    @input="$v.Project.name.$touch()"
                    @blur="$v.Project.name.$touch()"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.address"
                    label="Address"
                    :error-messages="addressErrors"
                    @input="$v.Project.address.$touch()"
                    @blur="$v.Project.address.$touch()"
                    ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.owner" 
                    label="Owner"
                    :error-messages="ownerErrors"
                    @input="$v.Project.owner.$touch()"
                    @blur="$v.Project.owner.$touch()"
                  ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex xs12>
                  <v-menu 
                  ref="menu1"
                  v-model="menu1"
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
                    v-model="Project.date"
                    label="Date"
                    required
                    v-on="on"
                    :error-messages="dateErrors"
                    @input="$v.Project.date.$touch()"
                    @blur="$v.Project.date.$touch()"
                  ></v-text-field>
                </template>
                  <v-date-picker v-model="Project.date" no-title @input="menu1 = false"></v-date-picker>
                </v-menu>
                </v-flex>
              </v-layout>
      
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.no_telp" 
                    label="Telp Number"
                    :error-messages="noErrors"
                    @input="$v.Project.no_telp.$touch()"
                    @blur="$v.Project.no_telp.$touch()"
                  ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="Project.phone" 
                    label="Phone Number"
                    :error-messages="phoneErrors"
                    @input="$v.Project.phone.$touch()"
                    @blur="$v.Project.phone.$touch()"
                  >
                    </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.type"
                    label="Type"
                    :error-messages="typeErrors"
                    @input="$v.Project.type.$touch()"
                    @blur="$v.Project.type.$touch()"
                    ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="Project.nominal"
                    label="Nominal"
                    :error-messages="nominalErrors"
                    @input="$v.Project.nominal.$touch()"
                    @blur="$v.Project.nominal.$touch()"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-card-text>
            </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(Project.id_project)">Save</v-btn>
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
                <v-card-text>Are you sure want to delete this project?</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Project.id_project)">Yes</v-btn>
                <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
              </v-card-actions>
            </v-card>
      </v-dialog>
    </template>

  </v-data-table>
</template>

<script>
import Controller from './../service/Project'
import validators from './../validations/Project'

  export default {
    validations: validators,
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      menu: false,
      menu1: false,
      menu2: false,
      search:'',
      id_project: '',
      kode: '',
      name:'',
      address: '',
      owner: '',
      date: new Date().toISOString().substr(0, 10),
      no_telp: '',
      phone: '',
      type: '',
      nominal: 0,
      project: [],
      Project: {
        id_project: '',
        name:'',
        address: '',
        owner: '',
        date: new Date().toISOString().substr(0, 10),
        no_telp: '',
        phone: '',
        type: '',
        nominal: 0,
        kode: ''
      },
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
        },
        {
          text: 'Project',
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
          text: 'Owner', 
          value: 'owner'
        },
        { 
          sortable: false,
          text: 'Date', 
          value: 'date'
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
          text: 'Type', 
          value: 'type'
        },
        { 
          sortable: false,
          text: 'Nominal', 
          value: 'nominal'
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
      filteredProject:function(){
        return this.project.filter((projectData)=>{
          projectData.name.match(this.search);
        });
      },
      idErrors(){
        const errors = []
        if(!this.$v.Project.kode.$dirty) return errors 
        !this.$v.Project.kode.maxLength && errors.push('ID must be at most 255 characters long')
        !this.$v.Project.kode.minLength && errors.push('ID must be at least 4 characters long')
        !this.$v.Project.kode.required && errors.push('ID is required')
        return errors
      },
      nameErrors(){
        const errors = []
        if(!this.$v.Project.name.$dirty) return errors 
        !this.$v.Project.name.maxLength && errors.push('Name must be at most 255 characters long')
        !this.$v.Project.name.minLength && errors.push('Name must be at least 10 characters long')
        !this.$v.Project.name.required && errors.push('Name is required')
        return errors
      },
      addressErrors(){
        const errors = []
        if(!this.$v.Project.address.$dirty) return errors
        !this.$v.Project.address.maxLength && errors.push('Address must be at most 255 characters long')
        !this.$v.Project.address.minLength && errors.push('Address must be at least 10 characters long')
        !this.$v.Project.address.required && errors.push('Address is required')
        return errors
      },
      ownerErrors(){
        const errors = []
        if(!this.$v.Project.owner.$dirty) return errors
        !this.$v.Project.owner.maxLength && errors.push('Project must be at most 255 characters long')
        !this.$v.Project.owner.minLength && errors.push('Project must be at least 10 characters long')
        !this.$v.Project.owner.required && errors.push('Project is required')
        return errors
      },
      contactErrors(){
        const errors = []
        if(!this.$v.Project.contact.$dirty) return errors
        !this.$v.Project.contact.maxLength && errors.push('Owner must be at most 255 characters long')
        !this.$v.Project.contact.minLength && errors.push('Owner must be at least 10 characters long')
        !this.$v.Project.contact.required && errors.push('Owner is required')
        return errors
      },
      phoneErrors(){
        const errors = []
        if(!this.$v.Project.phone.$dirty) return errors
        !this.$v.Project.phone.maxLength && errors.push('Phone number must be at most 15 characters long')
        !this.$v.Project.phone.minLength && errors.push('Phone number must be at least 10 characters long')
        !this.$v.Project.phone.required && errors.push('Phone number is required')
        !this.$v.Project.phone.numeric && errors.push('Phone number must be numeric')
        return errors
      },
      dateErrors(){
        const errors = []
        if(!this.$v.Project.date.$dirty) return errors
        !this.$v.Project.date.required && errors.push('Date is required')
        return errors
      },
      noErrors(){
        const errors = []
        if(!this.$v.Project.no_telp.$dirty) return errors
        !this.$v.Project.no_telp.required && errors.push('Telp number is required')
        !this.$v.Project.no_telp.numeric && errors.push('Telp number must be numeric')
        !this.$v.Project.no_telp.maxLength && errors.push('Telp number must be at most 15 characters long')
        !this.$v.Project.no_telp.minLength && errors.push('Telp number must be at least 10 characters long')
        return errors
      },
      typeErrors(){
        const errors = []
        if(!this.$v.Project.type.$dirty) return errors
        !this.$v.Project.type.maxLength && errors.push('Type must be at most 255 characters long')
        !this.$v.Project.type.required && errors.push('Type is required')
        return errors
      },
      nominalErrors(){
        const errors = []
        if(!this.$v.Project.nominal.$dirty) return errors
        !this.$v.Project.nominal.required && errors.push('Nominal is required')
        !this.$v.Project.nominal.numeric && errors.push('Nominal must be numeric')
        return errors
      }
    },
    methods: {
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
            name        : this.Project.name,
            address     : this.Project.address,
            owner       : this.Project.owner,
            date        : this.Project.date,
            no_telp     : this.Project.no_telp,
            phone       : this.Project.phone,
            type        : this.Project.type,
            nominal     : this.Project.nominal
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
              name        : this.Project.name,
              address     : this.Project.address,
              owner       : this.Project.owner,
              date        : this.Project.date,
              no_telp     : this.Project.no_telp,
              phone       : this.Project.phone,
              type        : this.Project.type,
              nominal     : this.Project.nominal,
              kode        : this.Project.kode
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
        this.Project = item
        console.log(this.Project)
      },
      refresh(){
        this.Project.kode     = '';
        this.Project.name     = '';
        //this.Project.date = '';
        this.Project.address  = '';
        this.Project.contact  = '';
        this.Project.phone    = 0;
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>