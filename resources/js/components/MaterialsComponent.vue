<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="material"
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
            <v-toolbar-title>Bahan/Tenaga Kerja</v-toolbar-title>
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
<<<<<<< Updated upstream
                <v-btn color="green darken-1" elevation="8" rounded dark class="mb-2" @click="reset();getKode()" v-on="on">Tambah</v-btn>
=======
                <v-btn color="green darken-1" :disabled="Access('R-BahanTenagaKerja-C')!=true" elevation="8" rounded dark class="mb-2" @click="reset();getKode()" v-on="on">Tambah</v-btn>
>>>>>>> Stashed changes
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline" v-if="!edit">Tambah Bahan/Tenaga Kerja</span>
                  <span class="headline" v-if="edit">Ubah Bahan/Tenaga Kerja</span>
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

                      <v-spacer></v-spacer>
                      <v-select 
                        v-model="Material.status" 
                        :rules="statusRules"
                        :items="items"
                        label="Status"
                        append-icon="keyboard_arrow_down"
                      >
                      </v-select>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.name" 
                          label="Nama"
                          :rules="nameRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="Material.type"
                          label="Tipe"
                          :rules="typeRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-select row
                      v-model="Material.id_satuan"
                      :items="satuan"
                      item-text="name"
                      item-value="id_satuan"
                      label="Satuan"
                      :rules="satuanRules"
                      append-icon="expand_more"
                    ></v-select>
                      
                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.price"
                          label="Harga"
                          :rules="priceRules"
                          type="number"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Material.spesification" 
                          label="Spesifikasi"
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
                        label="Toko"
                        append-icon="expand_more"
                        :rules="storeRules"
                      >
                      </v-select>
                    </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
<<<<<<< Updated upstream
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Batal</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="addItem()">Simpan</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(Material.id_material)">Simpan</v-btn>
=======
                  <v-btn class="ma-2" rounded color="green" dark @click="$refs.form.resetValidation();close()">Batal</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="$refs.form.resetValidation();addItem()">Simpan</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="$refs.form.resetValidation();updateItem(Material.id_material)">Simpan</v-btn>
>>>>>>> Stashed changes
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>

        <template v-slot:item.action="{ item }">
          <v-icon
          :disabled="Access('R-BahanTenagaKerja-U')!=true"
            small
            class="mr-2"
            color="green"
            @click="itemHandler(item);edit=true;dialog=true"
          >
            edit
          </v-icon>
          <v-icon
          :disabled="Access('R-BahanTenagaKerja-D')!=true"
            small
            color="red"
            @click="dialog2=true;itemHandler(item)"
          >
            delete
          </v-icon>
          
        </template>
      </v-data-table>
      <v-dialog v-model="dialog2" max-width="290px">
              <v-card>
                <v-card-title class="headline">Konfirmasi</v-card-title>
                  <v-card-text>Anda yakin ingin menghapus bahan/tenaga kerja ini?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Material.id_material)">Ya</v-btn>
                  <v-btn color="red darken-1" text @click="dialog2 = false">Tidak</v-btn>
                </v-card-actions>
              </v-card>
          </v-dialog>
    </v-container>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
      <v-icon dark>done</v-icon>
      {{ snackText }}
    </v-snackbar>
  </v-app>
</template>

<script>
import Controller from './../service/Material'
import jobController from './../service/Job'
import storeController from './../service/Store'
import { mapGetters, mapState, mapActions } from 'vuex'
  export default {
    data: () => ({
      snack: false,
      snackColor: '',
      snackText: '',
      y: 'top',
      search:'',

      valid: true,
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      edit: false,
      
      material: [],
      satuan: [],
      store:[],
      
      Material: {
        id_store:'',
        kode: '',
        name:'',
        type: '',
        price: 0,
        spesification: '',
        id_satuan: '',
        status: '',
      },
      MaterialDefault: {
        id_store:'',
        kode: '',
        name:'',
        type: '',
        price: 0,
        spesification: '',
        id_satuan: '',
        status: '',
      },
      items: [
        'material',
        'labor'
      ],
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: true,
          value: 'kode',
          width: '10%'
        },
        {
          text: 'Status',
          align: 'left',
          sortable: true,
          value: 'status',
        },
        {
          text: 'Nama',
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
          text: 'Harga',
          value: 'price',
          width: '15%',
        },
        {
          sortable: false,
          text: 'Satuan',
          value: 'satuan'
        },
        { 
          sortable: false,
          text: 'Spesifikasi', 
          value: 'spesification'
        },
        { 
          sortable: false,
          text: 'Toko', 
          value: 'store'
        },
        { 
          text: 'Aksi', 
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
        v => !!v || 'Price is required'
      ],
      satuanRules: [
        v => !!v || 'Unit is required',
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
      this.getKode()
    },
    computed: {
      ...mapGetters({
            nama: 'LoggedUser/Name',
            jabatan: 'LoggedUser/Jabatan',
            divisi: 'LoggedUser/Divisi',
            akses:'LoggedUser/Akses',
        }),
    },
    methods: {
      Access(codeAccess){

        var x;
        for(x in this.akses.data){
            if (codeAccess.includes(this.akses.data[x].Fitur)) {
                return true
            } 
        }
        return false
            
      },
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
      async getKode()
      {
        try{
          this.Material.kode = (await Controller.getKode())
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            id_store        : this.Material.id_store,
            kode            : this.Material.kode,
            name            : this.Material.name,
            price           : this.Material.price,
            type            : this.Material.type,
            satuan          : this.Material.id_satuan,
            status          : this.Material.status,
            spesification   : this.Material.spesification
          }
          await Controller.addItem(payload).then(()=>{
            this.close()
            this.save()
          })
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
          const payload = {
            id_store        : this.Material.id_store,
            kode            : this.Material.kode,
            name            : this.Material.name,
            price           : this.Material.price,
            type            : this.Material.type,
            satuan          : this.Material.id_satuan,
            status          : this.Material.status,
            spesification   : this.Material.spesification
          } 
          await Controller.updateItem(payload,id).then(()=>{
            this.close()
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
        this.Material = item
        console.log(this.Material)
      },
      reset(){
        // this.$refs.form.resetValidation()
        this.getallItem()
        this.Material = Object.assign({},this.MaterialDefault)
      },
      close () {
        this.getallItem()
        this.dialog = false
        this.edit = false
      },
    },
  }
</script>