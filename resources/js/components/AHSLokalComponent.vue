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
         
          <!-- <v-col cols="3">
          <v-select
            hide-details
            label="Choose Task Group"
            class="hidden-sm-and-down"
            v-model="select"
            :items="project"
            item-text="project"
            item-value="id_project"
            prepend-inner-icon="expand_more"
            single-line
            solo
            dense
            background-color="white"
          >
          </v-select> 
          </v-col> -->
      
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
        </v-toolbar>

      <v-card elevation="10">
        <v-list-group v-for="data in ahs" :key="data.id_ahs_lokal" @click="getItem(data.id_ahs_lokal)">
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <!-- <v-flex xs3>
                  <div class="caption grey--text">ID RAB</div>
                  <div>{{ data.id_rab }}</div>
                </v-flex> -->
                <v-flex xs5>
                  <div class="caption grey--text">{{data.structure}}-{{data.floor}}</div>
                  <div align="justify">{{ data.project }} </div>
                </v-flex>
                <!--  -->
                <!-- <v-flex xs3 style="padding-left:15px">
                  <div class="caption grey--text">Task Group</div>
                  <div>{{ data.name_sub }}</div>
                </v-flex> -->
                <v-flex xs4 style="padding-left:15px">
                  <div class="caption grey--text">{{data.task}}</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex xs2 style="padding-left:10px">
                  <div class="caption grey--text">Status</div>
                  <div>{{ data.status }}</div>
                </v-flex>
                <v-flex xs2 style="padding-left:10px">
                  <div class="caption grey--text">Volume</div>
                  <div>{{ data.volume_adj }}</div>
                </v-flex>
                <!-- <v-flex xs2 style="padding-left:10px">
                  <div class="caption grey--text">Satuan</div>
                  <div>{{ data.satuan }}</div>
                </v-flex> -->
                <v-flex xs2 style="padding-left:15px">
                  <div class="caption grey--text">Adjust</div>
                  <div>{{ data.adjustment }}</div>
                </v-flex>
                <v-flex xs5 style="padding-left:10px">
                  <div class="caption grey--text">HSP (LBO)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:120px">{{ Number(data.HSP_before_overhead_adj).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs3 style="padding-left:10px">
                  <div class="caption grey--text">Overhead (%)</div>
                  <div>{{ data.overhead }}</div>
                </v-flex>
                <v-flex xs5 style="padding-left:10px">
                  <div class="caption grey--text">HSP (LAO)</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:120px">{{ Number(data.HSP_adj).toLocaleString('id-ID') }}</div>
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
                              <v-flex sm4 md4 xs4>
                                <v-select
                                  v-model="AHS.id_structure"
                                  label="Structure"
                                  :items="detailStructure"
                                  item-text="structure"
                                  item-value="id_structure"
                                  :return-object="false" 
                                  append-icon="expand_more"
                                ></v-select>
                              </v-flex>
                              <v-flex sm4 md4 xs4 style="margin-left:10px">
                                <v-select
                                  v-model="AHS.id_groups"
                                  label="Floor"
                                  :items="detailGroup"
                                  item-text="floor"
                                  item-value="id_groups"
                                  :return-object="false" 
                                  append-icon="expand_more"
                                ></v-select>
                              </v-flex>
                              <v-flex sm4 md4 xs4 style="margin-left:10px">
                                <v-select
                                  v-model="AHS.id_sub"
                                  label="Task Group"
                                  :items="detailTask"
                                  item-text="task"
                                  item-value="id_sub"
                                  :return-object="false" 
                                  append-icon="expand_more"
                                  @change="filterTask(AHS.id_sub)"
                                ></v-select>
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex sm3 md3 xs3>
                                <v-select
                                  v-model="AHS.id_ahs"
                                  label="Task"
                                  :items="detailAHS"
                                  item-text="name"
                                  item-value="id_ahs"
                                  :return-object="false"
                                  append-icon="expand_more"
                                  @change="getMaterials(AHS.id_ahs)"
                                ></v-select>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-select
                                  v-model="AHS.id_ahs"
                                  label="HSP (MAO)"
                                  :items="detailAHS"
                                  item-text="total"
                                  item-value="id_ahs"
                                  :return-object="false"
                                  append-icon="expand_more"
                                  readonly
                                ></v-select>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field 
                                  v-model="AHS.volume" 
                                  label="Volume"
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field 
                                  v-model="AHS.adjustment" 
                                  label="Adjustment"
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>
                            </v-layout>

                            <v-layout style="margin-top: 10px">
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
                          >
                            <template v-slot:top>
                              <v-toolbar dark color="light-blue accent-2">
                                <v-toolbar-title>Detail Materials/Labor</v-toolbar-title>
                                <v-divider
                                  class="mx-4"
                                  inset
                                  vertical
                                ></v-divider>
                              </v-toolbar>
                            </template>

                            <template v-slot:item.sub_total_lokal="{item}">
                              <v-layout v-if="AHS.status == 'Price'">
                                <div style="text-align:left;width:30px">Rp.</div>
                                <div style="text-align:right;width:90px">{{ Number(item.sub_total_lokal * item.adjustment).toLocaleString('id-ID') }}</div>  
                              </v-layout>
                              <v-layout v-if="AHS.status =='Volume'">
                                <div style="text-align:left;width:30px">Rp.</div>
                                <div style="text-align:right;width:90px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>  
                              </v-layout>
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
                <v-card-text>Are you sure want to delete this ahs?</v-card-text>
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
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_labor_adj).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total of Materials : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_material_adj).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex>
                  <v-layout>
                    <div class="body-2 black--text font-weight-bold">Total of Equipment : Rp.</div>
                    <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(data.total_equipment_adj).toLocaleString('id-ID') }}</div>
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

            <template v-slot:item.sub_total_lokal="{ item }">
              <v-layout>
                <div style="text-align:left;width:25px">Rp.</div>
                <div style="text-align:right;width:100px">{{ Number(item.sub_total_lokal).toLocaleString('id-ID') }}</div>
              </v-layout>
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
      
      dialog6: false,
      dialog8: false,
      detailTable: false,
      dialogedit:false,
      loading:false,

      search:'',
      select:-1,
      searchAHS:'',
      id_ahs:'',
      
      ahs: [],
      job: [],
      details:[],
      detailsData:[],

      ahsAll:[],
      task:[],
      temp:[],
      Material:[],

      project:[],
      temp:[],
      filter:[],

      rab:[],
      // Structure:[],
      // Groups:[],
      // TaskSub:[],
      detailStructure:[],
      detailGroup:[],
      detailTask:[],
      detailAHS:[],
      detailMaterial:[],

      detail: {
        id_material:'',
        coefficient:'',
        sub_total:''
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
        // {text: 'ID', align: 'left', sortable: false, value: 'kode',},
        {text: 'Type', align: 'left', sortable: false, value: 'status',},
        {text: 'Item', align: 'left', sortable: false, value: 'name',},
        {text: 'Price', align: 'left', sortable: false, value: 'price',},
        {text: 'Coefficient', align: 'center', sortable: false, value: 'coefficient'},
        {text: 'Sub Total (M)', align: 'left', sortable: false, value: 'sub_total'},
        // {text: 'Adjustment', align: 'left', sortable: false, value: 'adjustment', align: 'center'},
        {text: 'Sub Total (L)', align: 'left', sortable: false, value: 'sub_total_lokal'},
        // {text: 'Materials/Labor', align: 'left', sortable: false, value: 'requirements_ml'},
        {text: 'Actions', align: 'center', sortable: false, value: 'action'},
      ],
      headersAHS: [
        {text: 'ID', align: 'left', sortable: false, value: 'kode'},
        {text: 'Type', align: 'left', sortable: true, value: 'status'},
        {text: 'Item', align: 'left', sortable: false, value: 'name'},
        {text: 'Price', align: 'left', sortable: false, value: 'price',},
        {text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total'},
        {text: 'Adjustment', align: 'left', sortable: false, value: 'sub_adjustment'},
      ],
      headers_detail_task: [
        {text: 'ID', align: 'left', sortable: false, value: 'id_sub'},
        {text: 'Building', align: 'left', sortable: false, value: 'structure'},
        {text: 'Floor', align: 'left', sortable: false, value: 'floor'},
        {text: 'Task Group', align: 'left', sortable: false, value: 'task'},
        {text: 'Detail', align: 'left', sortable: false, value: 'action'}
      ],
      headers_filter_materials: [
        {text: 'ID', align: 'left', sortable: false, value: 'kode'},
        {text: 'Type', align: 'left', sortable: true, value: 'status'},
        {text: 'Item', align: 'left', sortable: false, value: 'name'},
        {text: 'Price', align: 'left', sortable: false, value: 'price'},
        {text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total'},
        {text: 'Adjustment', align: 'left', sortable: false, value: 'adjustment'}
      ],
      headers_ahs_details:[
        {text: 'ID',value:'id_ahs_lokal'},
        {text: 'Builiding',value:'structure'},
        {text: 'Floor',value:'floor'},
        {text: 'Task Group',value:'task'},
        {text: 'AHS',value:'name', width:'25%'},
        {text: 'HSP', value: 'HSP'},
        {text: 'Volume',value:'volume',align: 'center'},
        {text: 'Adjustment',value:'adjustment',align: 'center'},
        {text: 'HP',value:'HP',width:'15%'},
        {text: 'HP Adjustment',value:'HP_Adjust'},
        {text: 'Actions',value:'action'},
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getall()
      this.getProject()
      this.getPagination()
      this.getTask()
      this.getRAB()
    },
    computed: {
    },
    methods: {
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
        // let total = parseFloat(temp) + parseFloat(temp*this.AHS.overhead/100)
        console.log('Total Material',temp)
        this.AHS.HSP_before_overhead = parseFloat(temp) + parseFloat(this.AHS.total_equipment)
        // total + parseFloat(this.AHS.total_equipment)
        console.log('Total Before Overhead',this.AHS.HSP_before_overhead)
        this.AHS.HSP = parseFloat(this.AHS.HSP_before_overhead+(this.AHS.HSP_before_overhead * this.AHS.overhead/100)).toFixed(2)
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
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
        // let ahsLokal = this.ahs.find(obj=>obj.id_ahs_lokal == item.id_ahs_lokal)
        // console.log('ahs lokal',ahsLokal)
        // this.AHS = ahsLokal
        // console.log('AHS Lokal',this.AHS)

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
      async getMaterials(id)
      {
        try{
          let AHS = (await ahs.showbyID(id)).data
          console.log('AHS Master',AHS)
          let Temp=[]
          let TempAll=[]
          for(let material of AHS.ahs_details.data)
          {
            let each = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_ahs_lokal : this.AHS.id_ahs_lokal,
              id_material : material.id_material,
              kode: material.kode,
              name: material.name,
              status: material.status,
              price: material.price, 
              coefficient : material.coefficient,
              sub_total : material.sub_total,
              adjustment: this.AHS.adjustment
            }
            Temp.push(each)
            TempAll.push(each)
          }
          console.log('ID AHS Lokal',this.AHS.id_ahs_lokal)
          let MaterialTemp = (await detailController.getItem(this.AHS.id_ahs_lokal)).data
          let Material=[]
          for(let material of MaterialTemp)
          {
            let data = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_ahs_lokal : material.id_ahs_lokal,
              id_material : material.id_material,
              kode: material.kode,
              name: material.name,
              status: material.status,
              price: material.price, 
              coefficient : material.coefficient,
              sub_total : material.sub_total,
              adjustment: material.adjustment 
            }
            Material.push(data)
          }
          console.log('Material Hendak Dihapus',Material)
          console.log('Material Hendak Dipush (new)',Temp)
          let j=0
          console.log('Temp All',TempAll)
          for(let material of Material)
          {
            console.log('Perulangan ke-',j)
            console.log('Temp',Temp[j])
            if(Temp[j] != undefined)
            {
              let data = {
                id_ahs_lokal_details : material.id_ahs_lokal_details,
                id_ahs_lokal : this.AHS.id_ahs_lokal,
                id_material : Temp[j].id_material,
                kode: Temp[j].kode,
                name: Temp[j].name,
                status: Temp[j].status,
                price: Temp[j].price, 
                coefficient : Temp[j].coefficient,
                sub_total : Temp[j].sub_total,
                adjustment: this.AHS.adjustment 
              }
              console.log('New Material',data)
              Material.splice(Material.indexOf(material),1,data)
              TempAll.splice(TempAll.indexOf(material))
              j++
              console.log('Material For',Material)
              console.log('Sisa Temp',TempAll)
              console.log('j selanjutnya',j)
            }
            else{
              Material.splice(Material.indexOf(material))
              console.log('ELSE',Material)
            }
          }
          console.log('This Material After Splice',Material)
          console.log('Sisa Temp All',TempAll)
          for(let temp of TempAll)
          {
            temp.id_ahs_lokal_details = null
            Material.push(temp)
          }
          console.log('Result Material Temp',Material)
          this.Material = Material 
          console.log('Result Material',this.Material)
          this.detailMaterial=[]
          for(let material of Material)
          {
            let each_detail = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_ahs_lokal : this.AHS.id_ahs_lokal,
              id_material : material.id_material,
              kode: material.kode,
              coefficient : material.coefficient,
              sub_total : material.sub_total,
              adjustment: this.AHS.adjustment
            }
            this.detailMaterial.push(each_detail)
          }
          console.log('Result Detail Material',this.detailMaterial)
          // this.AHS.HSP_before_overhead = parseFloat(AHS.total_before_overhead) + parseFloat(this.AHS.total_equipment)
          // console.log('HSP Before Overhead',this.AHS.HSP_before_overhead)
          // this.AHS.HSP = parseFloat(this.AHS.HSP_before_overhead+(this.AHS.HSP_before_overhead*this.AHS.overhead/100))
          this.AHS.id_job = AHS.id_job
          this.AHS.total_labor = AHS.total_labor
          this.AHS.total_material = AHS.total_material
          this.AHS.total_equipment = AHS.total_equipment
          this.AHS.HSP_before_overhead = AHS.total_before_overhead
          this.AHS.HSP = AHS.total
          this.AHS.overhead = AHS.overhead
        }catch(err){
          console.log(err)
        }
      },
      async itemEdit(item)
      {
        console.log('Item Edit',item)
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailAHS=[]
        this.Material = []
        let ahsLokal = this.ahs.find(obj=>obj.id_ahs_lokal == item.id_ahs_lokal)
        console.log('ahs lokal',ahsLokal)
        this.AHS = ahsLokal
        console.log('AHS Lokal',this.AHS)

        this.ahsAll = (await ahs.getall()).data
        this.detailAHS = this.ahsAll.filter(obj=>obj.id_sub == item.id_sub)
        console.log('detail ahs',this.detailAHS)
        
        let RAB = this.rab.find(obj=>obj.id_rab == this.AHS.id_rab)
        console.log('RAB',RAB)
        for(let detailS of RAB.structure.data)
        {
          // let structure = {
          //   id_structure_details: detailS.id_structure_details,
          //   id_structure : detailS.id_structure
          // }
          let detail = {
            id_structure_details  : detailS.id_structure_details,
            id_structure          : detailS.id_structure,
            structure             : detailS.structure
          }
          // this.Structure.push(structure)
          this.detailStructure.push(detail)
        }
        console.log('Structure',this.Structure)
        console.log('Detail Structure',this.detailStructure)
        console.log('RAB Structure Data',RAB.structure.data)
        for(let detailG of RAB.structure.data)
        {
          for(let detailgroup of detailG.group.data)
          {
            // let group = {
            //   id_group_details  : detailgroup.id_group_details,
            //   id_structure      : detailgroup.id_structure,
            //   id_groups         : detailgroup.id_groups
            // }
            let detail = {
              id_group_details : detailgroup.id_group_details,
              id_structure  : detailgroup.id_structure,
              id_groups     : detailgroup.id_groups,
              structure     : detailgroup.structure,
              floor         : detailgroup.floor
            }
            // this.Groups.push(group)
            this.detailGroup.push(detail)

            for(let detailtask of detailgroup.task_sub.data)
            {
              // let task = {
              //   id_sub_details : detailtask.id_sub_details,
              //   id_structure : detailtask.id_structure,
              //   id_groups    : detailtask.id_groups,
              //   id_sub       : detailtask.id_sub
              // }
              let detail = {
                id_sub_details : detailtask.id_sub_details,
                id_structure  : detailtask.id_structure,
                id_groups     : detailtask.id_groups,
                id_sub        : detailtask.id_sub,
                structure     : detailtask.structure,
                floor         : detailtask.floor,
                task          : detailtask.task
              }
              // this.TaskSub.push(task)
              this.detailTask.push(detail)
            }
          }
        }
        this.Material = (await detailController.getItem(this.AHS.id_ahs_lokal)).data
        for(let material of ahsLokal.detail.data)
          {
            let each_detail = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_ahs_lokal : material.id_ahs_lokal,
              id_material : material.id_material,
              kode: material.kode,
              coefficient : material.coefficient,
              sub_total : material.sub_total,
              sub_total_lokal : material.sub_total,
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
          let each = {
            id_project: -1,
            project: 'All'
          }
          this.project.push(each)
        }catch(err){
          console.log(err)
        }
      },
      close () {
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