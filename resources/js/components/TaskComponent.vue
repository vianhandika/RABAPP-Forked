<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-data-table
        :headers="headers"
        :items="job"
        :search="search"
        sort-by="date"
        class="elevation-8"
      >
        <template v-slot:top>
          <v-toolbar dark color="light-blue accent-3">
            <v-toolbar-title>Pekerjaan</v-toolbar-title>
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
                <v-btn color="green darken-1" :disabled="Access('R-Pekerjaan-C')!=true" elevation="8" rounded dark class="mb-2" @click="reset();getKode()" v-on="on">Tambah</v-btn>
>>>>>>> Stashed changes
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline" v-if="!edit">Tambah Pekerjaan</span>
                  <span class="headline" v-if="edit">Ubah Pekerjaan</span>
                </v-card-title>
                
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-text>
                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.kode" 
                        label="ID Pekerjaan"
                        readonly
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout>
                    <v-flex>
                      <v-text-field 
                        v-model="Job.name" 
                        label="Nama"
                        :rules="nameRules"
                      >
                      </v-text-field>
                    </v-flex>
                  </v-layout>
                    <v-select row
                      v-model="Job.group"
                      :items="groupTask"
                      item-text="name"
                      item-value="name"
                      label="Grup Pekerjaan"
                      :rules="grupRules"
                      append-icon="expand_more"
                    ></v-select>

                    <v-select row
                      v-model="Job.id_satuan"
                      :items="satuan"
                      item-text="name"
                      item-value="id_satuan"
                      label="Satuan"
                      :rules="satuanRules"
                      append-icon="expand_more"
                    ></v-select>
                      
                    <v-select row
                      v-model="Job.status"
                      :items="items"
                      label="Status"
                      :rules="statusRules"
                      append-icon="expand_more"
                    ></v-select>

                    <v-layout>
                      <v-flex>
                        <v-text-field 
                          v-model="Job.details" 
                          label="Spesifikasi"
                          :rules="specRules"
                        >
                        </v-text-field>
                      </v-flex>
                    </v-layout>
                </v-card-text>
              </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
<<<<<<< Updated upstream
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Batal</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="addItem()">Simpan</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(Job.id_job)">Simpan</v-btn>
=======
                  <v-btn class="ma-2" rounded color="green" dark @click="$refs.form.resetValidation();close()">Batal</v-btn>
                  <v-btn v-if="!edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="$refs.form.resetValidation();addItem()">Simpan</v-btn>
                  <v-btn v-if="edit" class="ma-2" rounded color="orange" :disabled="!valid" dark @click="$refs.form.resetValidation();updateItem(Job.id_job)">Simpan</v-btn>
>>>>>>> Stashed changes
                </v-card-actions>
              </v-card>

            </v-dialog>
          </v-toolbar>
        </template>

        <template v-slot:item.action="{ item }">
          <v-icon
          :disabled="Access('R-Pekerjaan-U')!=true"
            small
            class="mr-2"
            color="green"
            @click="itemHandler(item);edit=true;dialog=true"
          >
            edit
          </v-icon>
<<<<<<< Updated upstream

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
                  <v-card-title class="headline">Konfirmasi</v-card-title>
                    <v-card-text>Anda yakin ingin menghapus pekerjaan ini?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Job.id_job)">Ya</v-btn>
                    <v-btn color="red darken-1" text @click="dialog2 = false">Tidak</v-btn>
                  </v-card-actions>
                </v-card>
          </v-dialog>
=======
          <v-icon
          :disabled="Access('R-Pekerjaan-D')!=true"
            small
            color="red"
            @click="dialog2=true;itemHandler(item);"
          >
            delete
          </v-icon>
>>>>>>> Stashed changes
        </template>
        
      </v-data-table>
      <v-dialog v-model="dialog2" max-width="290px">
          <v-card>
            <v-card-title class="headline">Konfirmasi</v-card-title>
              <v-card-text>Anda yakin ingin menghapus pekerjaan ini?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Job.id_job)">Ya</v-btn>
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
import Controller from './../service/Job'
import GroupTask from './../service/TaskSub'
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
      edit: false,
      items : [
        'Volume',
        'Harga'
      ],
      job: [],
      satuan: [],
      groupTask:[],
      Job: {
        kode:'',
        name:'',
        id_satuan: '',
        details: '',
        id_job: '',
        status: '',
        group:'',
      },
      JobDefault: {
        kode:'',
        name:'',
        id_satuan: '',
        details: '',
        id_job: '',
        status: '',
        group:'',
      },
      headers: [
        {
          text : 'ID',
          sortable: true,
          value : 'kode'
        },
        {
          text: 'Nama',
          align: 'left',
          sortable: true,
          value: 'name',
        },
        {
          text: 'Grup',
          align: 'left',
          sortable: true,
          value: 'group',
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
          text: 'Spesifikasi', 
          value: 'details'
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
      ],
      satuanRules: [
        v => !!v || 'Satuan harus diisi',
      ],
      statusRules:[
        v => !!v || 'Status harus diisi'
      ],
      specRules: [
        v => !!v || 'Spesifikasi harus diisi'
<<<<<<< Updated upstream
=======
      ],
      grupRules: [
        v => !!v || 'Grup Pekerjaan harus diisi'
>>>>>>> Stashed changes
      ],
    }),
    mounted(){
      this.getallItem()
      this.getSatuan()
      this.getKode()
      this.getGroupTask()
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
<<<<<<< Updated upstream
=======
      },
      async getGroupTask()
      {
        try{
          this.groupTask = (await GroupTask.get()).data
        }catch(err){
          console.log(err)
        }
>>>>>>> Stashed changes
      },
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
      async getKode()
      {
        try{
          this.Job.kode = (await Controller.getKode())
          console.log(this.Job.kode)
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        console.log('satuan',this.Job.id_satuan)
        try{
          const payload = {
            kode        : this.Job.kode,
            name        : this.Job.name,
            satuan      : this.Job.id_satuan,
            status      : this.Job.status,
            details     : this.Job.details,
            group       : this.Job.group,
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
        console.log(this.Job.id_satuan)
        try{
          const payload = {
            kode        : this.Job.kode,
            name        : this.Job.name,
            satuan      : this.Job.id_satuan,
            status      : this.Job.status,
            details     : this.Job.details,
            group       : this.Job.group,
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
<<<<<<< Updated upstream
=======
          console.log(id)
>>>>>>> Stashed changes
          await Controller.deleteItem(id).then(()=>{
            this.getallItem()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(item){
        this.Job = item
        console.log(this.Job)
      },
      reset(){
        this.getallItem()
        // this.$refs.form.resetValidation()
        this.Job = Object.assign({},this.JobDefault)
      },
      close () {
        this.getallItem()
        this.dialog = false
        this.edit = false
      },
    },
  }
</script>