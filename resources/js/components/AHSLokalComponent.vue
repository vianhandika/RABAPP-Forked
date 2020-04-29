<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar color="light-blue accent-3">
        <v-toolbar-title class="white--text">AHS Lokal</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
            dark
          ></v-divider>
      
          <v-col cols="6">
            <v-layout>
              <v-text-field
                v-model="search"
                v-on:keyup.enter="filterAHS"
                hide-details
                background-color="white"
                solo
                dense
                style="width:300px"
                label="Search"
              >
              </v-text-field>  
              <v-btn 
                style="height:38px"
                color="blue"  
                dark
                @click="searchAll"
                @v-on:keyup.enter="searchAll"
              >
              <v-icon>search</v-icon> 
              </v-btn>
            </v-layout>
          </v-col>
          <div class="flex-grow-1"></div>
          <v-dialog v-model="dialog" width="850px">  
            <template v-slot:activator="{ on }">
              <v-btn color="green darken-1" elevation="8" rounded dark v-on="on" @click="itemadjhandler();">Edit</v-btn>
            </template>
            <template>
              <v-toolbar dark color="light-blue accent-4">
                <v-btn icon dark @click="dialog = false">
                  <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>Edit Adjustment</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn dark text @click="updateItemAdj(AHSAdj.id_rab)" :loading="loading">Save</v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card>
                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-card-text>
                    <v-layout>
                      <v-flex sm6 md6 xs6>      
                        <v-select
                          v-model="AHSAdj.id_project"
                          label="Project"
                          :items="project"
                          item-value="id_project"
                          item-text="project"
                          append-icon="expand_more"
                          @change="filterStructures(AHSAdj.id_project)"
                        ></v-select>
                      </v-flex>
                      <v-flex sm2 md2 xs2 style="margin-left:10px">
                        <v-select
                          v-model="AHSAdj.id_structure"
                          label="Structure"
                          item-text="structure"
                          item-value="id_structure"
                          :items="detailStructure"
                          append-icon="expand_more"
                          @change="filterAllMaterials(AHSAdj.id_structure)"
                        ></v-select>
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                </v-form>
                <v-container>
                  <v-data-table
                    :headers="headersEdit"
                    sortBy="name"
                    update: sort-asc
                    class="elevation-5"
                    :items="detailM"
                    :search="searchDetails"
                  >
                    <template v-slot:top>
                      <v-toolbar dark color="light-blue accent-2">
                        <v-toolbar-title>Detail Materials/Labor</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                        <v-col cols="6">
                          <v-text-field
                            v-model="searchDetails"
                            append-icon="search"
                            label="Search"
                            single-line
                            hide-details
                          ></v-text-field>
                        </v-col>
                      </v-toolbar>
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

                    <template v-slot:item.adjustment="{item}">
                      <v-edit-dialog
                        :return-value.sync="item.adjustment"
                        @save="updateAdjustAll(item)"
                        @cancel="cancel"
                        lazy
                        persistent
                        dark
                        large
                      > {{ item.adjustment }}
                        <template v-slot:input>
                          <v-text-field
                            v-model="item.adjustment"
                            label="Edit"
                            single-line
                            counter
                          ></v-text-field>
                        </template>
                      </v-edit-dialog>
                    </template>
                  </v-data-table>
                  <v-dialog v-model="updatedialog" max-width="290px">
                      <v-card>
                        <v-card-title class="headline">Confirmation</v-card-title>
                          <v-card-text>Are you sure want to update all of?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="green darken-1" text @click="updatedialog = false; deleteItem(AHS.id_ahs_lokal)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="updatedialog = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                </v-container>
              </v-card>
            </template>
          </v-dialog>
        </v-toolbar>

      <v-card elevation="10">
        <v-list-group v-for="data in ahs" :key="data.id_ahs_lokal" @click="getItem(data.id_ahs_lokal)">
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <v-flex xs5>
                  <div class="caption grey--text">{{data.structure}}-{{data.floor}}</div>
                  <div align="justify">{{ data.project }} </div>
                </v-flex>
                <v-flex xs4 style="padding-left:15px">
                  <div class="caption grey--text">{{data.task}}</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex xs2 style="padding-left:10px">
                  <div class="caption grey--text">Status</div>
                  <div>{{ data.status }}</div>
                </v-flex>
                <v-flex xs5 style="padding-left:10px">
                  <div class="caption grey--text">HSP (LBO)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:120px">{{ Number(data.HSP_before_overhead).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs3 style="padding-left:10px">
                  <div class="caption grey--text">Overhead (%)</div>
                  <div>{{ data.overhead }}</div>
                </v-flex>
                <v-flex xs3 style="padding-left:10px">
                  <div class="caption grey--text">Adjustment</div>
                  <div>{{ data.adjustment }}</div>
                </v-flex>
                <v-flex xs5 style="padding-left:10px">
                  <div class="caption grey--text">HSP (LAO)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:120px">{{ Number(data.HSP).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex style="padding-left:10px">
                  <div class="caption grey--text">Actions</div>
                  <v-layout>
                  <v-dialog v-model="dialogedit" width="850px">
                    <template v-slot:activator="{ on }">
                      <v-icon color="green" @click="itemEdit(data);dialogedit=true;detailTable=false" v-on="on">edit</v-icon>
                    </template>

                    <v-toolbar dark color="light-blue accent-4">
                      <v-btn icon dark @click="dialogedit = false">
                        <v-icon>close</v-icon>
                      </v-btn>
                      <v-toolbar-title>Edit AHS Lokal</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                        <v-btn dark text @click="updateItem(AHS.id_ahs_lokal)" :loading="loading">Save</v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <template>
                      <v-card>
                        <v-form ref="form" v-model="valid" lazy-validation>
                          <v-card-text>
                            <v-layout>
                              <v-flex>      
                                <v-text-field
                                  v-model="AHS.project"
                                  label="Project"
                                  readonly
                                ></v-text-field>
                              </v-flex >
                            </v-layout>

                            <v-layout>
                              <v-flex sm2 md2 xs2>
                                <v-text-field
                                  v-model="AHS.structure"
                                  label="Structure"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm2 md2 xs2 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.floor"
                                  label="Floor"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm2 md2 xs2 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.task"
                                  label="Task Group"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm6 md6 xs6 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.name"
                                  label="Task"
                                  :return-object="false"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex sm3 md3 xs3>
                                <v-text-field
                                  v-model="AHS.total_equipment"
                                  label="Total Of Equipment"
                                  type="number"
                                  @change="equipment"
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:20px">
                                <v-text-field 
                                  v-model="AHS.HSP_before_overhead" 
                                  label="Total"
                                  readonly
                                >
                                </v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left: 20px">
                                <v-text-field
                                  v-model="AHS.overhead"
                                  label="Overhead (%)"
                                  @change="overhead"
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:20px">
                                <v-text-field 
                                  v-model="AHS.HSP" 
                                  label="Total After Overhead"
                                  readonly
                                >
                                </v-text-field>
                              </v-flex>
                            </v-layout>
                          </v-card-text>
                        </v-form>
                        <v-container>
                          <v-data-table
                            :headers="headers"
                            sortBy="status"
                            update: sort-desc
                            class="elevation-5"
                            :items="Material"
                            :search="searchDetails"
                          >
                            <template v-slot:top>
                              <v-toolbar dark color="light-blue accent-2">
                                <v-toolbar-title>Detail Materials/Labor</v-toolbar-title>
                                <v-divider
                                  class="mx-4"
                                  inset
                                  vertical
                                ></v-divider>
                                <v-col cols="12" sm="6" md="6">
                                  <v-text-field
                                    v-model="searchDetails"
                                    append-icon="search"
                                    label="Search"
                                    single-line
                                    hide-details
                                  ></v-text-field>
                                </v-col>
                              </v-toolbar>
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

                            <template v-slot:item.action="{ item }">
                              <v-dialog v-model="dialog8" max-width="290px">
                                <template v-slot:activator="{ on }">
                                  <v-icon
                                    icon
                                    color="red"
                                    v-on="on"
                                    @click="itemDetail(item)"
                                  >
                                    delete
                                  </v-icon>
                                </template>
                                  <v-card>
                                    <v-card-title class="headline">Confirmation</v-card-title>
                                      <v-card-text>Are you sure want to delete this detail?</v-card-text>
                                    <v-card-actions>
                                      <v-spacer></v-spacer>
                                      <v-btn color="green darken-1" text @click="dialog8 = false; deletematerials(ahs_details)">Yes</v-btn>
                                      <v-btn color="red darken-1" text @click="dialog8 = false">No</v-btn>
                                    </v-card-actions>
                                  </v-card>
                              </v-dialog>
                            </template>

                            <template v-slot:item.adjustment="{item}">
                              <v-edit-dialog
                                :return-value.sync="item.adjustment"
                                @save="updateAdjustmentLokal(item)"
                                @cancel="cancel"
                                lazy
                                persistent
                                dark
                                large
                              > {{ item.adjustment }}
                                <template v-slot:input>
                                  <v-text-field
                                    v-model="item.adjustment"
                                    label="Edit"
                                    single-line
                                    counter
                                  ></v-text-field>
                                </template>
                              </v-edit-dialog>
                            </template>
                          </v-data-table>
                        </v-container>
                      </v-card>
                    </template>
                  </v-dialog>
                  <v-icon color="red" @click="itemHandler(data);dialog6=true;detailTable=false">delete</v-icon>
                  <v-icon color="blue" @click="itemHandler(data);detailTable=true">expand_more</v-icon>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-list-item-content>
            
          </template>

          <v-dialog v-model="dialog6" max-width="290px">
            <v-card>
              <v-card-title class="headline">Confirmation</v-card-title>
                <v-card-text>Are you sure want to delete this AHS LOkal?</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog6 = false; deleteItem(AHS.id_ahs_lokal)">Yes</v-btn>
                <v-btn color="red darken-1" text @click="dialog6 = false">No</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <template>
            <v-data-table
              :headers="headers"
              sortBy="status"
              update: sort-desc
              class="elevation-10"
              :items="data.detail.data"
              v-if="detailTable"
            >
            <template v-slot:top>
              <v-layout style="padding:10px">
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total of Labor : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_labor).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total of Materials : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_material).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total of Equipment : Rp.</div>
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

            <template v-slot:item.adjustment="props">
              <v-edit-dialog
                :return-value.sync="props.item.adjustment"
                @save="updateAdjustment(props)"
                @cancel="cancel"
                lazy
                persistent
                dark
                large
              > {{ props.item.adjustment }}
                <template v-slot:input>
                  <v-text-field
                    v-model="props.item.adjustment"
                    label="Edit"
                    single-line
                    counter
                  ></v-text-field>
                </template>
              </v-edit-dialog>
            </template>
            
            <template v-slot:item.action="{ item }">
              <v-dialog v-model="dialog8" max-width="290px">
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
                        <v-card-text>Are you sure want to delete this detail?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialog8 = false; deleteDetail(ahs_details.id_ahs_lokal_details)">Yes</v-btn>
                        <v-btn color="red darken-1" text @click="dialog8 = false">No</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>
            </template>
            </v-data-table>
            <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
              <v-icon dark>done</v-icon>
              {{ snackText }}
            </v-snackbar>
          </template>
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
        >
        </v-pagination>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import ahs from './../service/AHS'
import detailController from './../service/AHSLokalDetails'
import project from './../service/Project'
import rabDetails from './../service/AHSLokal'
import jobController from './../service/Job'
import task from './../service/TaskSub'
import detailsRab from './../service/Details'
import rabController from './../service/RAB'
import materialController from './../service/Material'

  export default {
    data: () => ({
      current_page: 1,
      total_pages: 0,
      valid: true,

      snack: false,
      y: 'top',
      snackColor: '',
      snackText: '',
      searchDetails:'',

      dialog:false,
      dialog6: false,
      dialog8: false,
      detailTable: false,
      dialogedit:false,
      loading:false,
      updatedialog:false,

      search:'',
      select:-1,
      searchAHS:'',
      id_ahs:'',
      
      // id_project:'',
      // id_structure:'',
      // id_rab:'',
      id_structure_details:'',

      ahs: [],
      job: [],
      details:[],
      detailsData:[],

      ahsAll:[],
      task:[],
      temp:[],
      Material:[],
      material:[],

      project:[],
      temp:[],
      filter:[],

      rab:[],
      detailStructure:[],
      detailGroup:[],
      detailTask:[],
      detailAHS:[],
      detailMaterial:[],
      detailM:[],
      
      AHSAdj:{
        id_project:'',
        id_rab:'',
        id_structure:'',
      },
      AHS:{
        kode:'',
        id_ahs_lokal:'',
        id_project: '',
        id_job: '',
        id_sub:'', 
        adjustment:0,
        total_labor: 0,
        total_material: 0,
        total: 0,
        HP:'',
      },
      ahs_details:{
        id_ahs_lokal_details:'',
        id_material: '',
        coefficient: 0,
        adjustment: 0,
        sub_total : 0,
      },
      headers: [
        {text: 'Type', align: 'left', sortable: false, value: 'status',},
        {text: 'Item', align: 'left', sortable: true, value: 'name'},
        {text: 'Price', align: 'left', sortable: false, value: 'price',},
        {text: 'Coefficient', align: 'center', sortable: false, value: 'coefficient'},
        {text: 'Adj BT', align: 'left', sortable: false, value: 'adjustment', align: 'center'},
        {text: 'Sub Total (L)', align: 'left', sortable: false, value: 'sub_total'},
        {text: 'Actions', align: 'center', sortable: false, value: 'action'},
      ],
      headersEdit: [
        {text: 'Type', align: 'left', sortable: false, value: 'status',},
        {text: 'Item', align: 'left', sortable: true, value: 'name'},
        {text: 'Price', align: 'left', sortable: false, value: 'price',},
        {text: 'Coefficient', align: 'center', sortable: false, value: 'coefficient'},
        {text: 'Adj BT', align: 'left', sortable: false, value: 'adjustment', align: 'center'},
        {text: 'Sub Total (L)', align: 'left', sortable: false, value: 'sub_total'},
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getall()
      this.getProject()
      this.getPagination()
      this.getTask()
      this.getRAB()
      this.getMaterial()
    },
    computed: {
    },
    methods: {
      itemadjhandler()
      {
        console.log('cek')
        this.detailM=[]
        this.AHSAdj.id_project=''
        this.AHSAdj.id_structure=''
        this.dialog=true
      },
      updateAdjustAll(item)
      {
        console.log('item',item)
        let material = this.detailM.filter(obj=>obj.id_material == item.id_material)
        console.log('material',material)
        for(let data of material)
        {
          data.adjustment = item.adjustment
          data.sub_total = item.adjustment * item.coefficient * item.price
        }
        console.log('detail material',this.detailM)
      },
      async getMaterial()
      {
        try{
          this.material = (await materialController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      deletematerials(item)
      {
        console.log('item',item)
        if(item.status == "labor")
          this.AHS.total_labor = parseFloat(this.AHS.total_labor) - parseFloat(item.sub_total)
        else
          this.AHS.total_material = parseFloat(this.AHS.total_material) - parseFloat(item.sub_total)
        this.AHS.HSP_before_overhead = parseFloat(this.AHS.HSP_before_overhead) - parseFloat(item.sub_total) 
        this.AHS.HSP = parseFloat(this.AHS.HSP_before_overhead+(this.AHS.HSP_before_overhead*this.AHS.overhead/100))
        this.Material.splice(this.Material.indexOf(item),1)
      },
      async getRAB()
      {
        try{
          this.rab = (await rabController.getallItem()).data
          console.log('RAB',this.rab)
        }catch(err){
          console.log(err)
        }
      },
      async updateItem(id){
        try{
          console.log('hai edit')
          this.loading = true
          console.log('ID Sub',this.AHS.id_sub)
          const payload = {
            id_sub_details      : this.AHS.id_sub_details,
            id_job              : this.AHS.id_job,
            total_labor         : this.AHS.total_labor,
            total_material      : this.AHS.total_material,
            total_equipment     : this.AHS.total_equipment,
            HSP_before_overhead : this.AHS.HSP_before_overhead,
            HSP                 : this.AHS.HSP,
            overhead            : this.AHS.overhead,
            adjustment          : this.AHS.adjustment,
            volume              : this.AHS.volume,
            HP                  : parseFloat(this.AHS.HSP * this.AHS.volume).toFixed(2),
            HP_Adjust           : parseFloat(this.AHS.HSP * this.AHS.volume * this.AHS.adjustment).toFixed(2),
            detail              : this.detailMaterial
          } 
          await rabDetails.updateItem(payload,id).then(()=>{
            this.close()
            this.update()
            this.loading = false
            this.dialogedit = false
          })
        }catch(err){
          this.loading = false
          console.log(err);
        }
      },
      async updateItemAdj(id){
        try{
          this.loading = true
          console.log('ID Project',id)
          const payload = {
            detail                : this.detailM
          } 
          await detailController.updateAdj(payload,id).then(()=>{
            this.close()
            this.update()
            this.loading = false
          })
        }catch(err){
          this.loading = false
          console.log(err);
        }
      },
      overhead()
      {
        let temp = parseFloat(this.AHS.HSP_before_overhead * this.AHS.overhead/100).toFixed(2)
        console.log(temp)
        this.AHS.HSP = parseFloat(this.AHS.HSP_before_overhead) + parseFloat(temp)
        console.log('AHS Total')
        console.log(this.AHS.total)
      },
      equipment()
      {
        let temp = 0
        for(let material of this.detailMaterial)
        {
          temp += parseFloat(material.sub_total)
        }
        console.log('Total Material',temp)
        this.AHS.HSP_before_overhead = parseFloat(temp) + parseFloat(this.AHS.total_equipment)
        console.log('Total Before Overhead',this.AHS.HSP_before_overhead)
        this.AHS.HSP = parseFloat(this.AHS.HSP_before_overhead+(this.AHS.HSP_before_overhead * this.AHS.overhead/100)).toFixed(2)
        this.AHS.HP = this.HSP * this.AHS.volume
        this.AHS.HP_Adjust = this.HP * this.AHS.adjustment
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async filterStructures(id)
      {
        console.log('Id Project',id)
        let rab = this.rab.find(obj=>obj.id_project == id)
        console.log('RAB',rab)
        this.AHSAdj.id_rab = rab.id_rab
        console.log('id rab',this.AHSAdj.id_rab)
        console.log('item',rab)
        this.detailStructure = (await detailsRab.show(rab.id_rab)).data
        console.log('detail structure',this.detailStructure)
      },
      async filterAllMaterials(id)
      {
        this.detailM=[]
        let structure = this.detailStructure.find(obj=>obj.id_structure == this.AHSAdj.id_structure)
        console.log('detail structure',structure)
        let detail = (await detailsRab.showG(structure.id_structure_details)).data
        console.log('detail group',detail)
        for(let group of detail)
        {
            for(let task of group.task_sub.data)
            {
              for(let rab_details of task.rab_details.data)
              {
                for(let material of rab_details.detail.data)
                {
                  if(material.status == "material")
                    this.detailM.push(material)
                }
              }
            }
        }
        console.log('material All',this.detailM)
      },
      async filterTask(id)
      {
        console.log('Id Sub',id)
        this.ahsAll = (await ahs.getall()).data
        console.log('AHS All',this.ahsAll)
        this.detailAHS = this.ahsAll.filter(obj=>obj.id_sub == id)
        console.log('Choose AHS',this.detailAHS)
        let task_sub = this.detailTask.find(obj=>obj.id_structure == this.AHS.id_structure && obj.id_groups == this.AHS.id_groups && obj.id_sub == this.AHS.id_sub)
        console.log('task_sub',task_sub)
        this.AHS.id_sub_details = task_sub.id_sub_details
      },
      async searchAll()
      {
        try{
          if(this.search=='')
            this.getallAHS()
          else 
            this.ahs = (await rabDetails.search(this.search)).data
          console.log('search ahs',this.ahs) 
        }catch(err){
          console.log(err)
        }
      },
      async getPagination()
      {
        try{
          if(this.search == "")
          {
            await rabDetails.pagination(this.current_page).then(response=>{
              this.ahs = response.data
              this.current_page = response.meta.pagination.current_page
              this.total_pages = response.meta.pagination.total_pages
            })
          }else{
            await rabDetails.search(this.search,this.current_page).then(response =>{
              this.current_page = response.meta.pagination.current_page
              this.ahs = response.data
              this.total_pages = response.meta.pagination.total_pages
            })
          }
        }catch(err){
          console.log(err)
        }
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
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      itemHandler(item){
        this.AHS = item
        this.ahs_details = item
        console.log('item',this.AHS)
        console.log('ahs_details',this.ahs_details)
      },
      itemDetail(item){
        this.ahs_details = item
      },
      async itemEdit(item)
      {
        console.log('Item Edit',item)
        this.Material = []
        
        let ahs = (await rabDetails.getItem(item.id_ahs_lokal)).data
        this.AHS = ahs[0]
        console.log('AHS Lokal',this.AHS)
        
        this.Material = (await detailController.getItem(this.AHS.id_ahs_lokal)).data
        for(let material of this.Material)
          {
            let each_detail = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_ahs_lokal : material.id_ahs_lokal,
              id_material : material.id_material,
              kode: material.kode,
              coefficient : material.coefficient,
              sub_total : material.sub_total,
              adjustment: material.adjustment
            }
            this.detailMaterial.push(each_detail)
          }
        console.log('Material',this.Material)
        console.log('Detail Material',this.detailMaterial)
      },
      async getall(){
        try{
          this.detailsData = (await detailController.getDetails()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS()
      {
        try{
          this.ahs = (await rabDetails.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async updateAdjustment(props){
        try{
            const payload = {
              adjustment   : props.item.adjustment,
            } 
            await detailController.updateDetail(payload,props.item.id_ahs_lokal_details)
            this.getItem(props.item.id_ahs_lokal_details).then(response=>{
              this.getPagination()
              this.update()
            })
        }catch(err){
          console.log(err);
        }
      }, 
      updateAdjustmentLokal(item)
      {
        console.log('Detail Material',this.detailMaterial)
        console.log('Material Before Edit',this.Material)
        console.log('Item',item)
        let materialData = this.material.find(obj=>obj.id_material == item.id_material)
        item.sub_total = item.adjustment * materialData.price * item.coefficient
        console.log('Material After Edit', this.Material)
        this.detailMaterial=[]
        console.log('After Empty Detail',this.detailMaterial)
        for(let material of this.Material)
        {
          let each = {
            id_ahs_lokal_details : material.id_ahs_lokal_details,
            id_ahs_lokal : material.id_ahs_lokal,
            id_material : material.id_material,
            kode: material.kode,
            coefficient : material.coefficient,
            sub_total : material.sub_total,
            adjustment: material.adjustment
          }
          this.detailMaterial.push(each)
        }
        console.log('After Edit Detail',this.detailMaterial)
        this.AHS.HSP_before_overhead=0
        this.AHS.total_material=0
        this.AHS.total_labor=0
        for(let data of this.Material)
        {
          let materialData = this.material.find(obj=>obj.id_material == data.id_material)
          if(materialData.status == 'labor')
            this.AHS.total_labor += data.sub_total
          else
            this.AHS.total_material += data.sub_total
          this.AHS.HSP_before_overhead += data.sub_total
        }
        console.log('Total Material',this.AHS.total_material)
        console.log('Total Labor',this.AHS.total_labor)
        this.AHS.HSP_before_overhead = parseFloat(this.AHS.HSP_before_overhead) + parseFloat(this.AHS.total_equipment)
        this.AHS.HSP = this.AHS.HSP_before_overhead + (this.AHS.HSP_before_overhead * this.AHS.overhead/100)
        console.log('HSP Before Overhead',this.AHS.HSP_before_overhead)
        console.log('HSP',this.AHS.HSP)
        this.AHS.HP = this.AHS.HSP * this.AHS.volume
        this.AHS.HP_Adjust = this.AHS.HP * this.AHS.adjustment
        console.log('HP',this.AHS.HP)
        console.log('HP_Adjust',this.AHS.HP_Adjust)
        this.update()
      },
      async deleteItem(id){
        try{
          await rabDetails.delete(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          let ahs = this.details.find(obj=>obj.id_ahs_lokal_details == id)
          await detailController.deleteItem(id).data
          this.getItem(ahs.id_ahs_lokal).then(response=>{
            this.getPagination()
            this.delete()
          })
        }catch(err){
          console.log(err)
        }
      },
      async getItem(id){
        try{
          this.details = (await detailController.getItem(id)).data
        }catch(err){
          console.log(err)
        }
      },
      async getProject()
      {
        try{
          this.project = (await project.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      close () {
        this.dialog = false
        this.dialog6 = false
        this.dialog8 = false
        this.details=[]
        this.getallAHS()
        this.getall()
      },
    }
  }
</script>

<style >
</style>