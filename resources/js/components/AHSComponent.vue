<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar color="light-blue accent-3">
        <v-toolbar-title class="white--text">AHS Master</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
          dark
        ></v-divider>

        <v-col cols="6">
          <v-row>
            <v-text-field
              v-model="search"
              hide-details
              background-color="white"
              solo
              dense
              style="width:300px"
              label="cari..."
              @keyup.enter="searchAll"
            >
            </v-text-field>  
            <v-btn 
              style="height:38px"
              color="blue"  
              dark
              @click="searchAll"
            >
            <v-icon>search</v-icon> 
            </v-btn>
          </v-row>
        </v-col>
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" persistent width="850px">
          <template v-slot:activator="{ on }">
            <v-btn color="green darken-1" dark elevation="8" rounded class="mb-2" @click="dialogAdd=true;dialogEdit=false;reset()" v-on="on">Tambah</v-btn>
          </template>
          <v-toolbar dark color="light-blue accent-4">
            <v-btn icon dark :disabled="Access('R-AHSMaster-C')!=true" @click="dialog = false; dialogAdd=false;dialogEdit=false">
              <v-icon @click="$refs.form.resetValidation();getPagination()">close</v-icon>
            </v-btn>
            <v-toolbar-title v-if="dialogAdd">Tambah AHS Master</v-toolbar-title>
            <v-toolbar-title v-if="!dialogAdd">Ubah AHS Master</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items v-if="dialogAdd">
              <v-btn dark text @click="addItem" :loading="loading">Simpan</v-btn>
            </v-toolbar-items>
            <v-toolbar-items v-if="!dialogAdd">
<<<<<<< Updated upstream
              <v-btn dark text @click="updateItem(AHS.id_ahs)" :loading="loading">Simpan</v-btn>
=======
              <v-btn dark text @click="$refs.form.resetValidation();updateItem(AHS.id_ahs)" :loading="loading">Simpan</v-btn>
>>>>>>> Stashed changes
            </v-toolbar-items>
          </v-toolbar>

          <v-card>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-card-text>
                <v-layout v-if="dialogAdd">
                  <v-flex>
                    <v-text-field 
                      v-model="AHS.kode" 
                      label="ID AHS"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout v-if="dialogAdd">
                  <v-flex sm6 md6 xs6>
                    <v-select
                      v-model="AHS.id_sub"
                      label="Grup Pekerjaan"
                      :items="task"
                      item-text="name"
                      item-value="id_sub"
                      :return-object="false"
                      :rules="groupRules"
                      append-icon="expand_more"
                      @change="filterTask(AHS.id_sub)"
                    ></v-select>
                  </v-flex>

                  <v-flex sm6 md6 xs6 style="margin-left:10px">
                    <v-autocomplete
                      v-model="AHS.id_job"
                      label="Pekerjaan"
                      :items="temp"
                      item-text="name"
                      item-value="id_job"
                      :return-object="false"
                      :rules="taskRules"
                    ></v-autocomplete>
                    </v-flex>
                </v-layout>

                <v-layout v-if="dialogEdit">
                  <v-flex>
                    <v-text-field 
                      v-model="AHS.kode" 
                      label="ID AHS"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-layout v-if="dialogEdit">
                  <v-flex sm6 md6 xs6>
                    <v-select
                      v-model="AHS.id_sub"
                      label="Grup Pekerjaan"
                      :items="task"
                      item-text="name"
                      item-value="id_sub"
                      :return-object="false" 
                      @change="filterTask(AHS.id_sub)"
                      append-icon="expand_more"
                    ></v-select>
                  </v-flex>
                  <v-flex sm6 md6 xs6 @click="filterTask(AHS.id_sub)" style="margin-left:10px">
                    <v-select
                      v-model="AHS.id_job"
                      label="Pekerjaan"
                      :items="temp"
                      item-text="name"
                      item-value="id_job"
                      :return-object="false"
                      append-icon="expand_more"
                    ></v-select>
                  </v-flex>
                </v-layout>
                  
                <v-layout style="margin-top: 10px">
                  <v-flex>
                    <v-text-field
                      v-model="AHS.total_equipment"
                      label="Total Peralatan"
                      type="number"
                      @change="equipment"
                    ></v-text-field>
                  </v-flex>
                  <v-flex style="margin-left:20px">
                    <v-text-field 
                      v-model="AHS.total_before_overhead" 
                      label="HSP (M)"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                  <v-flex style="margin-left: 20px">
                    <v-text-field
                      v-model="AHS.overhead"
                      label="Overhead (%)"
                      @change="overhead"
                      type="number"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                  <v-flex style="margin-left:20px">
                    <v-text-field 
                      v-model="AHS.total" 
                      label="HSP (MSO)"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>

                <v-col cols="12">
                  <v-data-table
                    :headers="headers_material"
                    :items="filterMaterial"
                    class="elevation-5"
                    :search="searchMaterials"
                    height="200px"
                  >
                    <template v-slot:top>
                      <v-toolbar color="light-blue accent-2" dark>
                        <v-toolbar-title>Bahan/Tenaga Kerja</v-toolbar-title>
                        <v-divider
                          inset
                          vertical
                          class="mx-4"
                        ></v-divider>
                      </v-toolbar>
                      <v-col cols="12" sm="8">
                        <v-text-field
                          v-model="searchMaterials"
                          append-icon="search"
                          label="Cari"
                          single-line
                          hide-details
                          color="blue"
                        >
                        </v-text-field>
                      </v-col>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <v-btn
                        icon
                        color="green"
                        @click="addList(item)"
                      >
                      <v-icon>add_box</v-icon>
                      </v-btn>
                    </template>

                    <template v-slot:item.coefficient="props">
                      <v-edit-dialog
                        :return-value.sync="props.item.coefficient"
                        lazy
                        large
                        persistent
                        dark
                      > {{ props.item.coefficient }}
                        <template v-slot:input>
                          <v-text-field
                            v-model="props.item.coefficient"
                            label="Edit"
                            single-line
                            counter
                          ></v-text-field>
                        </template>
                      </v-edit-dialog>
                    </template>

                    <template v-slot:item.price="{ item }">
                      <v-layout>
                        <div style="text-align:left;width:30px">Rp.</div>
                        <div style="text-align:right;width:90px">{{ Number(item.price).toLocaleString('id-ID') }}</div>  
                      </v-layout>
                    </template>
                  </v-data-table>
                </v-col>
                  
                <v-col cols="12">
                  <v-data-table
                    :headers="headers_details"
                    :items="detailsAHS"
                    class="elevation-5"
                    :search="searchAHS"
                  >
                    <template v-slot:top>
                      <v-toolbar color="light-blue accent-2" dark>
                        <v-toolbar-title>Detail AHS</v-toolbar-title>
                        <v-divider
                          inset
                          vertical
                          class="mx-4"
                        ></v-divider>
                      </v-toolbar>
                      <v-col cols="12" sm="8">
                        <v-text-field
                          v-model="searchAHS"
                          append-icon="search"
                          label="Cari"
                          single-line
                          hide-details
                          color="blue"
                        >
                        </v-text-field>
                      </v-col>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <v-dialog v-model="dialogdeletedetail" max-width="290px">
                        <template v-slot:activator="{on}">
                          <v-btn
                            icon
                            color="red"
                            dark @click="itemDetail(item);dialogdeletedetail=true"
                            v-on="on"
                          >
                          <v-icon>delete</v-icon>
                          </v-btn>
                        </template>
                        <v-card>
                          <v-card-title class="headline">Konfirmasi</v-card-title>
                            <v-card-text>Anda yakin ingin menghapus detail ini?</v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialogdeletedetail = false; deleteList(ahs_details)">Ya</v-btn>
                            <v-btn color="red darken-1" text @click="dialogdeletedetail = false">Tidak</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    </template>

                    <template v-slot:item.coefficient="props">
                      <v-edit-dialog
                        :return-value.sync="props.item.coefficient"
                        @save="editList(props.item)"
                        lazy
                        large
                        persistent
                        dark
                      > {{ props.item.coefficient }}
                        <template v-slot:input>
                          <v-text-field
                            v-model="props.item.coefficient"
                            label="Edit"
                            single-line
                            counter
                          ></v-text-field>
                        </template>
                      </v-edit-dialog>
                    </template>

                    <template v-slot:item.price="{item}">
                      <v-layout>
                        <div style="text-align:left;width:30px">Rp.</div>
                        <div style="text-align:right;width:90px">{{ Number(item.price).toLocaleString('id-ID') }}</div>  
                      </v-layout>
                    </template>
                    
                    <template v-slot:item.sub_total="{item}">
                      <v-layout>
                        <div style="text-align:left;width:30px">Rp.</div>
                        <div style="text-align:right;width:90px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>  
                      </v-layout>
                    </template>
                  </v-data-table>
                </v-col>
              </v-card-text>
            </v-form>
          </v-card>
        </v-dialog>
      </v-toolbar>

      <v-card elevation="10">
        <v-list-group v-for="data in ahs" :key="data.id_ahs">
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <v-flex sm3 md3 xs3>
                  <div class="caption grey--text">ID AHS</div>
                  <div>{{ data.kode }}</div>
                </v-flex>
                <v-flex sm5 md5 xs5 style="padding-right:20px">
                  <div class="caption grey--text">{{data.name_sub}}</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex sm5 md5 xs5>
                  <div class="caption grey--text">HSP (M)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:100px">{{ Number(data.total_before_overhead).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex sm3 md3 xs3 style="padding-right:20px">
                  <div class="caption grey--text">Overhead (%)</div>
                  <div>{{ data.overhead }}</div>
                </v-flex>
                <v-flex sm5 md5 xs5>
                  <div class="caption grey--text">HSP (MSO)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:100px">{{ Number(data.total).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <div class="caption grey--text">Aksi</div>
                  <v-layout>
                    <v-icon color="green" :disabled="Access('R-AHSMaster-U')!=true" @click="itemHandler(data);dialogEdit=true;dialog=true;dialogAdd=false;detailAHS=true;detailTable=false">edit</v-icon>
                    <v-icon color="red" :disabled="Access('R-AHSMaster-D')!=true" @click="itemHandler(data);dialogDelete=true;detailTable=false">delete</v-icon>
                    <v-icon color="blue" :disabled="Access('R-AHSMaster-C')!=true" @click="itemHandler(data);dialogCopy=true;detailTable=false">file_copy</v-icon>
                    <v-icon color="light-blue accent-3" @click="detailTable=true">expand_more</v-icon>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-list-item-content>
          </template>
            
          <v-data-table
            :headers="headers"
            sortBy="status"
            update: sort-desc
            class="elevation-10"
            :items="data.ahs_details.data"
            v-if="detailTable"
          >
            <template v-slot:top>
              <v-layout style="padding:10px">
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total Tenaga Kerja : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_labor).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total Bahan : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_material).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total Peralatan : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_equipment).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
              </v-layout>
              <v-divider></v-divider>
            </template>
            <template v-slot:item.sub_total="{ item }">
              <v-layout>
                <div style="text-align:left;width:25px">Rp.</div>
                <div style="text-align:right;width:100px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>
              </v-layout>
            </template>

            <template v-slot:item.price="{ item }">
              <v-layout>
                <div style="text-align:left;width:25px">Rp.</div>
                <div style="text-align:right;width:100px">{{ Number(item.price).toLocaleString('id-ID') }}</div>
              </v-layout>
            </template>

            <template v-if="Access('R-AHSMaster-U')==true" v-slot:item.coefficient="props">
              <v-edit-dialog
                :return-value.sync="props.item.coefficient"
                @save="updateDetail(props)"
                @cancel="cancel"
                lazy
                large
                persistent
                dark
              > {{ props.item.coefficient.toString().replace('.',',') }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.coefficient"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template>

            <template v-slot:item.action="{ item }">
              <v-dialog v-model="dialogDetail" max-width="290px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    :disabled="Access('R-AHSMaster-D')!=true"
                    small
                    icon
                    color="red"
                    v-on="on"
                    @click="itemDetail(item)"
                  >
                    delete
                  </v-icon>
                </template>
                <v-card>
                  <v-card-title class="headline">Konfirmasi</v-card-title>
                    <v-card-text>Anda yakin ingin menghapus detail ini?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialogDetail = false; deleteDetail(ahs_details.id_ahs_details)">Ya</v-btn>
                    <v-btn color="red darken-1" text @click="dialogDetail = false">Tidak</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-list-group>

        <v-pagination
          v-model="current_page"
          class="my-4"
          :length="total_pages"
          prev-icon="arrow_left"
          next-icon="arrow_right"
          circle
          @input="getPagination"
          :total-visible="5"
        ></v-pagination>
      </v-card>
      
      <template>
        <v-dialog v-model="dialogDelete" max-width="290px">
          <v-card>
            <v-card-title class="headline">Konfirmasi</v-card-title>
              <v-card-text>Anda yakin ingin menghapus AHS Master ini?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(AHS.id_ahs)">Ya</v-btn>
              <v-btn color="red darken-1" text @click="dialogDelete = false">Tidak</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>

      <template>
        <v-dialog v-model="dialogCopy" max-width="290px">
          <v-card>
            <v-card-title class="headline">Konfirmasi</v-card-title>
              <v-card-text>Anda yakin ingin melakukan copy AHS Master ini?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialogCopy = false; copyItem()">Ya</v-btn>
              <v-btn color="red darken-1" text @click="dialogCopy = false">Tidak</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>
    </v-container>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
      <v-icon dark>done</v-icon>
      {{ snackText }}
    </v-snackbar>
  </v-app>
</template>

<script>
import Controller from './../service/Job'
import materialController from './../service/Material'
import ahsController from './../service/AHS'
import detailController from './../service/AHSDetails'
import task from './../service/TaskSub'
import { mapGetters, mapState, mapActions } from 'vuex'
  export default {
    data: () => ({
      current_page: 1,
      total_pages: 0,
      valid: true,

      snack: false,
      y: 'top',
      snackColor: '',
      snackText: '',
      edit_id_material:'',
      
      dialog: false,
      dialogAdd: false,
      dialogDelete: false,
      dialogEdit: false,
      dialogDetail: false,
      dialogCopy: false,
      dialogdeletedetail: false,
      tambah: false,
      detailAHS: false,
      detailTable: false,
      edit: false,
      loading:false,

      search:'',
      searchAHS: '',
      searchMaterials: '',
      select: -1,
      id_ahs: '',
      
      ahs: [],
      ahsAll:[],
      job: [],
      material:[],
      details:[],
      detailsAHS:[],
      detailsData:[],
      task : [],
      taskTemp:[],
      filter:[],
      temp:[],
      filterMaterial:[],

      AHS:{
        kode:'',
        id_ahs:'',
        id_job: '',
        id_sub:'', 
        total_labor: 0,
        total_material: 0,
        total_before_overhead: 0,
        overhead: 10,
        total: 0,
        total_equipment: 0,
      },
       AHSDefault:{
        kode:'',
        id_ahs:'',
        id_job: '',
        id_sub:'', 
        total_labor: 0,
        total_material: 0,
        total_before_overhead: 0,
        overhead: 10,
        total: 0,
        total_equipment: 0,
      },
      ahs_details:{
        id_ahs_details:'',
        id_material: '',
        coefficient: '',
        sub_total : 0,
      },
      details_default:{
        id_ahs_details:'',
        id_material:'',
        coefficient: '',
        sub_total:0,
      },
      Material:{
        id_material:'',
      },
      headers: [
        {text: 'ID', align: 'left', sortable: false, value: 'kode',},
        {text: 'Tipe', align: 'left', sortable: true, value: 'status',},
        {text: 'Nama', align: 'left', sortable: false, value: 'name',},
        {text: 'Harga', align: 'left', sortable: false, value: 'price',},
        {text: 'Koefisien', align: 'center', sortable: false, value: 'coefficient'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total', },
        {text: 'Aksi', align: 'center', sortable: false, value: 'action', },
      ],
      headers_material:[
        {text: 'ID', value:'id_material'},
        {text: 'Nama', value: 'name'},
        {text: 'Harga',value: 'price'},
        {text: 'Aksi',value: 'action'},
      ],
      headers_details: [
        {text: 'Tipe', align: 'left', sortable: true, value: 'status',},
        {text: 'Nama', align: 'left', sortable: false, value: 'name',},
        {text: 'Harga', align: 'left', sortable: false, value: 'price'},
        {text: 'Koefisien', align: 'left', sortable: false, value: 'coefficient', align: 'center'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total'},
        {text: 'Aksi', align: 'left', sortable: false, value: 'action',},
      ],
      //validation
      groupRules: [
        v => !!v || 'Grup pekerjaan wajib diisi'
      ],
      taskRules: [
        v => !!v || 'Pekerjaan wajib diisi'
      ],
      materialsRules: [
        v => !!v || 'Bahan wajib diisi'
      ],
      coefficientRules: [
        v => !!v || 'Koefisien wajib diisi',
        v => (v && !v.numeric) || 'Koefisien harus berupa angka'
      ]
    }),
    mounted(){
      this.getAll()
      this.getallItem()
      this.getallItemMaterial()
      this.getTask()
      this.getallDetails()
      this.getPagination()
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
      copy(){
        this.snack = true
        this.snackColor = 'green darken-1'
        this.snackText = 'Data Berhasil Disalin'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Batal'
      },
      overhead()
      {
        let temp = parseFloat(this.AHS.total_before_overhead * this.AHS.overhead/100).toFixed(2)
        this.AHS.total = parseFloat(this.AHS.total_before_overhead) + parseFloat(temp)
      },
      equipment()
      {
        let temp = 0
        for(let material of this.details)
        {
          temp += parseFloat(material.sub_total)
        }
        this.AHS.total_before_overhead = parseFloat(temp) + parseFloat(this.AHS.total_equipment)
        this.AHS.total = parseFloat(this.AHS.total_before_overhead+(this.AHS.total_before_overhead * this.AHS.overhead/100)).toFixed(2)
      },
      async searchAll()
      {
        try{
          if(this.search=='')
            this.getallAHS()
          else
          {
            await ahsController.search(this.search).then(response=>{
              this.current_page = response.meta.pagination.current_page
              this.ahs = response.data
              this.total_pages = response.meta.pagination.total_pages
            })
          } 
        }catch(err){
          console.log(err)
        }
      },
      async filterTask(id)
      {
        // this.ahsAll = (await ahsController.getall()).data
        this.job = (await Controller.getallItem()).data
        let group = this.task.find(obj=>obj.id_sub == this.AHS.id_sub)
        this.job = this.job.filter(obj=>obj.group==group.name)
        // let filterAHS = this.ahsAll.filter(obj=>obj.id_sub == id)

        // let job = this.job
        // for(let ahs of filterAHS)
        // {
        //   job = this.job.filter(obj=>obj.id_job != ahs.id_job)
        //   this.job = job
        // }
        this.temp = this.job
        console.log('Result',this.temp)
      },
      async filterMaterials()
      {
        this.filterMaterial = (await materialController.getallItem()).data
        let m = this.material
        for(let detail of this.details)
        {
          this.filterMaterial = m.filter(obj=>obj.id_material != detail.id_material)
          m = this.filterMaterial
        }
        console.log('Filter Materials',this.filterMaterial)
      },
      async itemHandler(item){
        this.details=[]
        this.detailsAHS=[]
        this.tambah=false

        this.AHS = item
        this.AHS.id_sub = item.id_sub
        for(let detail of item.ahs_details.data)
        {
          let each_detail = {
            id_ahs_details : detail.id_ahs_details,
            id_material : detail.id_material,
            coefficient : detail.coefficient,
            sub_total : detail.sub_total
          }
          this.details.push(each_detail)
        }
  
        for(let detail_ahs of item.ahs_details.data)
        {
          let data = this.material.find(obj=>obj.id_material == detail_ahs.id_material)
          let each_detail = {
            id_ahs_details: detail_ahs.id_ahs_details,
            id_material : detail_ahs.id_material,
            status : data.status,
            name : data.name,
            price : data.price,
            coefficient : detail_ahs.coefficient,
            sub_total : parseFloat(data.price * detail_ahs.coefficient).toFixed(2),
          }
          this.detailsAHS.push(each_detail)
        }
        this.temp = (await Controller.getallItem()).data
        console.log('This Details Edit',this.details)
        console.log('This Details',this.detailsAHS)
        this.filterMaterials()
      },
      itemDetail(item){
        this.ahs_details = item
      },
      async addList(item)
      {
        let data = this.material.find(obj=>obj.id_material == item.id_material)
        let detail = {
          id_ahs_details : null,
          id_material : item.id_material,
          coefficient : item.coefficient,
          sub_total : parseFloat(data.price * item.coefficient).toFixed(2)
        }
        let detail_ahs = {
          id_ahs_details: null,
          id_material : item.id_material,
          status : data.status,
          name : data.name,
          price : data.price,
          coefficient : item.coefficient,
          sub_total : parseFloat(data.price * item.coefficient).toFixed(2),
        }
        this.details.push(detail)
        this.detailsAHS.push(detail_ahs)
        this.sumOfTotal(data,detail)
        this.AHS.total = parseFloat(this.AHS.total_before_overhead+(this.AHS.total_before_overhead * this.AHS.overhead/100)).toFixed(2)
        this.filterMaterials()
        console.log('Detail AHS',this.details)
      },
      sumOfTotal(material,detail)
      {
        if(material.status == "material")
          this.AHS.total_material = parseFloat(this.AHS.total_material) + parseFloat(detail.sub_total)
        if(material.status == "labor")
          this.AHS.total_labor = parseFloat(this.AHS.total_labor) + parseFloat(detail.sub_total)
        
        this.AHS.total_before_overhead = parseFloat(this.AHS.total_before_overhead) + parseFloat(detail.sub_total)
        if(this.AHS.overhead == '0')
          this.AHS.total = this.AHS.total_before_overhead
        else
          this.AHS.total = parseFloat(this.AHS.total_before_overhead) + parseFloat(this.AHS.total_before_overhead * this.AHS.overhead/100) 
        
        console.log('Total Material',this.AHS.total_material)
        console.log('Total Labor',this.AHS.total_labor)
        console.log('Total Before Overhead',this.AHS.total_before_overhead)
        console.log('Total',this.AHS.total)
      },
      delOfTotal(material,detail)
      {
        if(material.status == "material")
          this.AHS.total_material = parseFloat(this.AHS.total_material) - parseFloat(detail.sub_total)
        if(material.status == "labor")
          this.AHS.total_labor = parseFloat(this.AHS.total_labor) - parseFloat(detail.sub_total)
        
        this.AHS.total_before_overhead = parseFloat(this.AHS.total_before_overhead - detail.sub_total).toFixed(2)
        if(this.AHS.overhead == '0')
          this.AHS.total = this.AHS.total_before_overhead
        else
          this.AHS.total = parseFloat(this.AHS.total_before_overhead) + parseFloat(this.AHS.total_before_overhead * this.AHS.overhead/100) 
        console.log('Total Material',this.AHS.total_material)
        console.log('Total Labor',this.AHS.total_labor)
        console.log('Total Before Overhead',this.AHS.total_before_overhead)
        console.log('Total',this.AHS.total)
      },
      editList(data)
      {
        let material = this.material.find(obj=>obj.id_material == data.id_material)
        let detail = this.details.find(obj=>obj.id_material == data.id_material)
        this.delOfTotal(material,data)

        let newDetail = {
          id_ahs_details: data.id_ahs_details,
          id_material : data.id_material,
          coefficient : data.coefficient,
          sub_total : parseFloat(data.coefficient * material.price).toFixed(2)
        }
        let newDetailAHS = {
          id_ahs_details: data.id_ahs_details,
          id_material : data.id_material,
          status : data.status,
          name : data.name,
          price : data.price,
          coefficient : data.coefficient,
          sub_total : parseFloat(material.price * data.coefficient).toFixed(2),
        }
        this.details.splice(this.details.indexOf(detail),1,newDetail)
        this.detailsAHS.splice(this.detailsAHS.indexOf(data),1,newDetailAHS)
        this.sumOfTotal(material,newDetail)
        this.update()

        console.log('Details',this.details)
        console.log('Detail AHS',this.detailsAHS)
      },
      deleteList(data){
        let material = this.material.find(obj=>obj.id_material == data.id_material)
        let detail = this.details.find(obj=>obj.id_material == data.id_material)
        this.delOfTotal(material,data)
        this.details.splice(this.details.indexOf(detail),1)
        this.detailsAHS.splice(this.detailsAHS.indexOf(data),1)

        console.log('This Details Delete',this.details)
        console.log('This Details',this.detailsAHS)
        this.filterMaterials()
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallDetails(){
        try{
          this.detailsData = (await detailController.getallItem()).data
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
      async getallItemMaterial(){
        try{
          this.material = (await materialController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS()
      {
        try{
          this.ahs = (await ahsController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getAll()
      {
        try{
          this.ahsAll = (await ahsController.getall()).data
        }catch(err){
          console.log(err)
        }
      },
      async getKode()
      {
        try{
          this.AHS.kode = (await ahsController.getKode())
        }catch(err){
          console.log(err)
        }
      },
      async getPagination()
      {
        try{
          if(this.search == "")
          {
            await ahsController.get(this.current_page).then(response =>{
              this.current_page = response.meta.pagination.current_page
              this.ahs = response.data
              this.total_pages = response.meta.pagination.total_pages
            })
          }else{
            await ahsController.search(this.search,this.current_page).then(response =>{
              this.current_page = response.meta.pagination.current_page
              this.ahs = response.data
              this.total_pages = response.meta.pagination.total_pages
            })
          }
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          this.loading=true
          const payload = {
            kode                  : this.AHS.kode,
            id_job                : this.AHS.id_job,
            id_sub                : this.AHS.id_sub,
            total_labor           : this.AHS.total_labor,
            total_material        : this.AHS.total_material,
            total_equipment       : this.AHS.total_equipment,
            total_before_overhead : this.AHS.total_before_overhead,
            overhead              : this.AHS.overhead,
            total                 : this.AHS.total,
            detail                : this.details
          }
          await ahsController.addItem(payload).then(()=>{
            this.current_page = 1
            this.close()
            this.save()
            this.loading = false
          })
        }catch(err){
          console.log(err)
          this.loading = false
        }
      },
      async updateItem(id){
        try{
          this.loading = true
          const payload = {
            kode            : this.AHS.kode,
            id_sub          : this.AHS.id_sub,
            id_job          : this.AHS.id_job,
            total_labor     : this.AHS.total_labor,
            total_material  : this.AHS.total_material,
            total_equipment : this.AHS.total_equipment,
            total_before_overhead : this.AHS.total_before_overhead,
            overhead        : this.AHS.overhead,
            total           : this.AHS.total,
            detail          : this.details
          } 
          await ahsController.updateItem(payload,id).then(()=>{
            this.close()
            this.update()
            this.loading = false
          })
        }catch(err){
          this.loading = false
          console.log(err);
        }
      },
      async copyItem()
      {
        const payload = {
          id_ahs: this.AHS.id_ahs
        }
        try{
            await ahsController.copy(payload).then(()=>{
            this.current_page = 1 
            this.getallAHS()
            this.copy()
          })
        }catch(err){
          console.log(err)
        }
      },
      async updateDetail(props){
        try{
          const payload = {
            coefficient   : props.item.coefficient,
          } 
          await detailController.updateDetail(payload,props.item.id_ahs_details)
            this.getItem(props.item.id_ahs).then(()=>{
            this.close()
            this.update()
          })
        }catch(err){
          console.log(err);
        }
      }, 
      async deleteItem(id){
        try{
          await ahsController.deleteItem(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          await detailController.deleteItem(id).data
          this.getPagination().then(()=>{
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async getItem(id){
        try{
          this.detailsData  = (await detailController.getItem(id)).data
        }catch(err){
          console.log(err)
        }
      },
      reset () {
        this.getKode()
        this.filterMaterials()
        this.ahs_details.coefficient = ''
        this.AHS = Object.assign({},this.AHSDefault)
        // this.$refs.form.resetValidation()
        this.details=[]
        this.detailsAHS=[]
        this.tambah = false
      },
      close () {
        this.dialog = false
        this.details=[]
        this.AHS = Object.assign({},this.AHSDefault)
        this.getPagination()
      },
    }
  }
</script>

<style >
.borderAhs{
  border-left: 4px solid #40C4FF
}
.borderMaterial{
  margin-left: 10px;
  border-left: 4px solid #448AFF
}
.right{
  text-align: right
}
</style>