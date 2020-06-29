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
            <v-toolbar-title>Toko</v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>

            <v-text-field
              v-model="search"
              append-icon="search"
              label="Cari"
              single-line
              hide-details
              style="width: 5px"
            >
            </v-text-field>
          
            <div class="flex-grow-1"></div>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" v-on="on" @click="reset;edit=false">Tambah</v-btn>
              </template>

              <v-card>
                <v-card-title>
                  <span class="headline" v-if="!edit">Tambah Toko</span>
                  <span class="headline" v-if="edit">Ubah Toko</span>
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
                          label="ID Toko"
                          readonly
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.name" 
                            label="Nama"
                            :rules="nameRules"
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.address" 
                            label="Alamat"
                            :rules="addressRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.type" 
                            label="Tipe Bahan"
                            :rules="typeRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.no_telp" 
                            label="Nomor Telepon"
                            :rules="noRules"
                            type="number"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.phone" 
                            label="Nomor HP"
                            :rules="phoneRules"
                            type="number"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="Store.owner" 
                            label="Pemilik"
                            :rules="ownerRules"
                          >
                            </v-text-field>
                        </v-flex>
                      </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="dialog=false">Batal</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" v-if="!edit" @click="addItem();dialog=false">Simpan</v-btn>
                  <v-btn class="ma-2" rounded color="orange" dark :disabled="!valid" v-if="edit" @click="updateItem(Store.id_store);dialog=false">Simpan</v-btn>
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
                <v-card-title class="headline">Konfirmasi</v-card-title>
                <v-card-text>Anda yakin ingin menghapus toko ini?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(Store.id_store)">Ya</v-btn>
                  <v-btn color="red darken-1" text @click="dialogDelete=false">Tidak</v-btn>
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
      StoreDefault: {
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
          text: 'Nama',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Alamat', 
          value: 'address'
        },
        { 
          sortable: false,
          text: 'Tipe Bahan', 
          value: 'type'
        },
        { 
          sortable: false,
          text: 'Nomor Telepon', 
          value: 'no_telp'
        },
        { 
          sortable: false,
          text: 'Nomor HP', 
          value: 'phone'
        },
        { 
          sortable: false,
          text: 'Pemilik', 
          value: 'owner'
        },
        { 
          text: 'Aksi', 
          value: 'action', 
          sortable: false 
        },
      ],
      //validation
      nameRules: [
        v => !!v || 'Nama harus diisi',
        v => v && v.length <= 30 || 'Nama harus antara 1-30 karakter'
      ],
      addressRules: [
        v => !!v || 'Alamat harus diisi',
        v => v && v.length <= 50 || 'Alamat harus antara anatara 1-50 karakter'
      ],
      typeRules: [
        v => !!v || 'Tipe harus diisi',
        v => v && v.length <= 30 || 'Tipe harus antara 1-30 karakter'
      ],
      phoneRules: [
        v => !!v || 'Nomor HP harus diisi',
        v => v && v.length <= 15 || 'Nomoh HP harus antara 1-15 karakter'
      ],
      noRules: [
        v => !!v || 'Nomor Telepon harus diisi',
        v => v && v.length <= 15 || 'Nomor Telepon harus antara 1-15 karakter'
      ],
      ownerRules:[
        v => !!v || 'Nama pemilik harus diisi',
        v => v && v.length <= 40 || 'Nama pemiliki harus antara 1-40 karakter'
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
        this.snackText = 'Data Berhasil Disimpan'
      },
      update(){
        this.snack = true
        this.snackColor = 'teal darken-1'
        this.snackText = 'Data Berhasil Diubah'
      },
      delete(){
        this.snack = true
        this.snackColor = 'red darken-1'
        this.snackText = 'Data Berhasil Dihapus'
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
          await Controller.addItem(payload).then(() =>{
            this.getallItem()
            this.save()
          })
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
          await Controller.updateItem(payload,id).then(()=>{
            this.getallItem()
            this.update()
          })
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await Controller.deleteItem(id).then(()=>{
            this.getallItem()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(item){
        this.Store = item
        console.log(this.Store)
      },
      reset()
      {
        this.getallItem()
        this.$refs.form.resetValidation()
        this.Store = Object.assign({},this.StoreDefault)
      },
    },
  }
</script>