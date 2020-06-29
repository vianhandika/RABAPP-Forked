<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-row>
        <v-col cols="12" md="6">
          <v-data-table
            :headers="headersStructure"
            :items="structure"
            class="elevation-8"
            :search="searchstructure"
          >
            <template v-slot:top>
              <v-toolbar dark color="light-blue accent-3">
                <v-toolbar-title>Gedung</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>

                <v-text-field
                  v-model="searchstructure"
                  append-icon="search"
                  label="Cari"
                  single-line
                  hide-details
                  style="width: 45px"
                >
                </v-text-field>
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="building"
                  label="Gedung"
                  single-line
                  hide-details
                  style="width: 40px"
                >
                </v-text-field>
                <v-btn 
                  class="ma-3" 
                  color="green darken-1" 
                  elevation="8" 
                  rounded 
                  dark
                  @click="addStructure"
                >
                  Tambah
                </v-btn>
              </v-toolbar>
            </template>

            <template v-slot:item.name="props">
              <v-edit-dialog
                :return-value.sync="props.item.name"
                @save="updateStructure(props)"
                lazy
                large
                persistent
                dark
              > {{ props.item.name }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.name"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template> 

            <template v-slot:item.action="{ item }">
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
                        <v-card-text>Anda yakin ingin menghapus gedung ini?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialogDelete = false; deleteStructure(Structure.id_structure)">Ya</v-btn>
                        <v-btn color="red darken-1" text @click="dialogDelete = false">Tidak</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-col>
        <v-col cols="12" md="6">
          <v-data-table
            :headers="headersFloor"
            :items="floor"
            class="elevation-8"
            :search="searchfloor"
          >
            <template v-slot:top>
              <v-toolbar dark color="light-blue accent-3">
                <v-toolbar-title>Lantai</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>

                <v-text-field
                  v-model="searchfloor"
                  append-icon="search"
                  label="Cari"
                  single-line
                  hide-details
                  style="width: 45px"
                >
                </v-text-field>
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="floor_data"
                  label="Lantai"
                  single-line
                  hide-details
                  style="width: 40px"
                >
                </v-text-field>
                <v-btn 
                  class="ma-3" 
                  color="green darken-1" 
                  elevation="8" 
                  rounded 
                  dark
                  @click="addFloor"
                >
                  Tambah
                </v-btn>
              </v-toolbar>
            </template>

            <template v-slot:item.name="props">
              <v-edit-dialog
                :return-value.sync="props.item.name"
                @save="updateFloor(props)"
                lazy
                large
                persistent
                dark
              >Lantai {{ props.item.name }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.name"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template>

            <template v-slot:item.action="{ item }">
              <v-dialog v-model="dialogDeleteFloor" max-width="290px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    color="red"
                    v-on="on"
                    @click="itemFloor(item)"
                  >
                    delete
                  </v-icon>
                </template>
                    <v-card>
                      <v-card-title class="headline">Konfirmasi</v-card-title>
                        <v-card-text>Anda yakin ingin menghapus lantai ini?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialogDeleteFloor = false; deleteFloor(Floor.id_group)">Ya</v-btn>
                        <v-btn color="red darken-1" text @click="dialogDeleteFloor = false">Tidak</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="6">
          <v-data-table
            :headers="headersTask"
            :items="task_group"
            class="elevation-8"
            :search="searchtask"
          >
        
            <template v-slot:top>
              <v-toolbar dark color="light-blue accent-3">
                <v-toolbar-title>Grup Pekerjaan</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>

                <v-text-field
                  v-model="searchtask"
                  append-icon="search"
                  label="Cari"
                  single-line
                  hide-details
                  style="width: 45px"
                >
                </v-text-field>
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="task"
                  label="Grup Pekerjaan"
                  single-line
                  hide-details
                  style="width: 40px"
                >
                </v-text-field>
                <v-btn 
                  class="ma-3" 
                  color="green darken-1" 
                  elevation="8" 
                  rounded 
                  dark
                  @click="addTaskSub"
                >
                  Tambah
                </v-btn>
              </v-toolbar>
            </template>

            <template v-slot:item.name="props">
              <v-edit-dialog
                :return-value.sync="props.item.name"
                @save="updateTaskSub(props)"
                lazy
                large
                persistent
                dark
              > Pekerjaan {{ props.item.name }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.name"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template>

            <template v-slot:item.action="{ item }">
              <v-dialog v-model="dialogDeleteTask" max-width="290px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    color="red"
                    v-on="on"
                    @click="itemTask(item)"
                  >
                    delete
                  </v-icon>
                </template>
                    <v-card>
                      <v-card-title class="headline">Konfirmasi</v-card-title>
                        <v-card-text>Anda yakin ingin menghapus grup pekerjaan ini?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialogDeleteTask = false; deleteTaskSub(Task.id_sub)">Ya</v-btn>
                        <v-btn color="red darken-1" text @click="dialogDeleteTask = false">Tidak</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-col>

        <v-col cols="12" md="6"> 
          <v-data-table
            :headers="headersSatuan"
            :items="satuan"
            class="elevation-8"
            :search="searchsatuan"
          >
            <template v-slot:top>
              <v-toolbar dark color="light-blue accent-3">
                <v-toolbar-title>Satuan</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>

                <v-text-field
                  v-model="searchsatuan"
                  append-icon="search"
                  label="Cari"
                  single-line
                  hide-details
                  style="width: 45px"
                >
                </v-text-field>
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="satuan_data"
                  label="Satuan"
                  single-line
                  hide-details
                  style="width: 40px"
                >
                </v-text-field>
                <v-btn 
                  class="ma-3" 
                  color="green darken-1" 
                  elevation="8" 
                  rounded 
                  dark
                  @click="addSatuan"
                >
                  Tambah
                </v-btn>
              </v-toolbar>
            </template>

            <template v-slot:item.name="props">
              <v-edit-dialog
                :return-value.sync="props.item.name"
                @save="updateSatuan(props)"
                lazy
                large
                persistent
                dark
              > {{ props.item.name }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.name"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template>

            <template v-slot:item.action="{ item }">
              <v-dialog v-model="dialogDeleteSatuan" max-width="290px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    color="red"
                    v-on="on"
                    @click="itemSatuan(item)"
                  >
                    delete
                  </v-icon>
                </template>
                    <v-card>
                      <v-card-title class="headline">Konfirmasi</v-card-title>
                        <v-card-text>Anda yakin ingin menghapus satuan ini?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialogDeleteSatuan = false; deleteSatuan(Satuan.id_satuan)">Ya</v-btn>
                        <v-btn color="red darken-1" text @click="dialogDeleteSatuan = false">Tidak</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
      <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
        <v-icon dark>done</v-icon>
        {{ snackText }}
      </v-snackbar>
    </v-container>
  </v-app>
</template>

<script>
import structure from './../service/Structure'
import floor from './../service/Group'
import task from './../service/TaskSub'
import satuan from './../service/Satuan'

  export default {
    data: () => ({
      snack: '',
      snackText:'',
      snackColor:'',
      y: 'top',

      valid: true,
      dialogStructure: false,
      dialogDelete: false,
      dialogDeleteFloor: false,
      dialogDeleteTask: false,
      dialogDeleteSatuan: false,
      
      searchstructure:'',
      searchfloor:'',
      searchtask:'',
      searchsatuan:'',

      building:'',
      floor_data:'',
      task:'',
      satuan_data:'',
      
      structure:[],
      floor:[],
      task_group:[],
      satuan:[],

      Structure: {
        id_structure:'',
        name:''
      },
      Floor:{
        id_group:'',
        name:''
      },
      Task:{
        id_sub: '',
        name:''
      },
      Satuan:{

      },
      headersStructure: [
        {text: 'ID', value:'id_structure'},
        {text: 'Nama', value:'name'},
        {text: 'Aksi', value:'action'},
      ],
      headersFloor: [
        {text: 'ID', value: 'id_group'},
        {text: 'Nama', value: 'name'},
        {text: 'Aksi', value: 'action'},
      ],
      headersTask: [
        {text: 'ID', value:'id_sub'},
        {text: 'Nama', value:'name'},
        {text: 'Aksi', value:'action'},
      ],
      headersSatuan: [
        {text: 'ID', value: 'id_satuan'},
        {text: 'Nama', value: 'name'},
        {text: 'Aksi', value: 'action'},
      ]
    }),
    mounted(){
      this.getStructure()
      this.getFloor()
      this.getTaskSub()
      this.getSatuan()
    },
    computed: {
      
    },
    methods: {
      save () {
        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Data Berhasil Disimpan'
      },
      update()
      {
        this.snack = true
        this.snackColor = 'teal darken-1'
        this.snackText = 'Data Berhasil Diubah'
      },
      delete(){
        this.snack = true
        this.snackColor = 'red'
        this.snackText = 'Data Berhasil Dihapus'
      },
      itemHandler(item)
      {
        this.Structure = item
      },
      itemFloor(item)
      {
        this.Floor = item
      },
      itemTask(item)
      {
        this.Task = item
      },
      itemSatuan(item)
      {
        this.Satuan = item
      },
      async getStructure(){
        try{
          this.structure = (await structure.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async addStructure()
      {
        try{
          const payload = {
            name : this.building,
          }
          await structure.add(payload).then(()=>{
            this.getStructure()
            this.building = ''
            this.save()  
          })
        }catch(err){
          console.log(err)
        }
      },
      async updateStructure(props){
        try{
          const payload = {
            name        : props.item.name,
          }
          await structure.update(payload,props.item.id_structure).then(()=>{
            this.getStructure()
            this.update();
          })
        }catch(err){
          console.log(err)
        }
      },
      async deleteStructure(id){
        try{
          await structure.delete(id).then(()=>{
            this.getStructure()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async getFloor(){
        try{
          this.floor = (await floor.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async addFloor()
      {
        try{
          const payload = {
            name : this.floor_data,
          }
          await floor.add(payload).then(()=>{
            this.getFloor()
            this.floor_data = ''
            this.save()
          })
        }catch(err){
          console.log(err);
        }
      },
      async updateFloor(props){
        try{
          const payload = {
            name        : props.item.name
          }
          await floor.update(payload,props.item.id_group).then(()=>{
            this.getFloor()
            this.update()
          })
        }catch(err){
          console.log(err)
        }
      },
      async deleteFloor(id){
        try{
          await floor.delete(id).then(()=>{
            this.getFloor()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async getTaskSub(){
        try{
          this.task_group = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async addTaskSub()
      {
        try{
          const payload = {
            name :  this.task,
          }
          await task.add(payload).then(()=>{
            this.getTaskSub()
            this.task = ''
            this.save()
          })
        }catch(err){
          console.log(err)
        }
      },
      async updateTaskSub(props){
        try{
          const payload = {
            name        : props.item.name
          }
          await task.update(payload,props.item.id_sub).then(()=>{
            this.getTaskSub()
            this.update()
          })
        }catch(err){
          console.log(err)
        }
      },
      async deleteTaskSub(id){
        try{
          await task.delete(id).then(()=>{
            this.getTaskSub()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async addSatuan()
      {
        try{
          const payload = {
            name :  this.satuan_data,
          }
          await satuan.add(payload).then(()=>{
            this.getSatuan()
            this.satuan_data = ''
            this.save()
          })
        }catch(err){
          console.log(err)
        }
      },
      async updateSatuan(props){
        try{
          const payload = {
            name        : props.item.name
          }
          await satuan.update(payload,props.item.id_satuan).then(()=>{
            this.getSatuan()
            this.update()
          })
        }catch(err){
          console.log(err)
        }
      },
      async deleteSatuan(id){
        try{
          await satuan.delete(id).then(()=>{
            this.getSatuan()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async getSatuan()
      {
        try{
          this.satuan = (await satuan.get()).data
        }catch(err){
          console.log(err)
        }
      },
    }
  }
</script>