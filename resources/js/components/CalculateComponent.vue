<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar dark color="light-blue accent-3">
        <v-toolbar-title>Calculate AHS</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>

          <v-text-field
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          >
          </v-text-field>
        </v-toolbar>
        <v-card elevation="10">
          <template>
            <v-container>
              <v-row>
                <v-col cols="12" sm="3" md="3">
                  <v-select
                    :items="rab"
                    item-text="project"
                    item-value="id_project"
                    label="Project"
                    append-icon="expand_more"
                    v-model="id_project"
                    @change="filterStructures"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" sm="2" md="2">
                  <v-select
                    v-model="id_structure"
                    :items="detailStructure"
                    item-text="structure"
                    item-value="id_structure"
                    label="Building"
                    append-icon="expand_more"
                    @change="filterGroups"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" sm="2" md="2">
                  <v-select
                    v-model="id_groups"
                    :items="detailGroup"
                    item-text="floor"
                    label="Floor"
                    item-value="id_groups"
                    append-icon="expand_more"
                    @change="filterTask"
                  >
                  </v-select>
                </v-col>
                
                <v-col cols="12" sm="2" md="2">
                  <v-select
                    v-model="id_sub"
                    :items="detailTask"
                    item-text="task"
                    item-value="id_sub"
                    label="Task Group"
                    append-icon="expand_more"
                    @change="filterAHS"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                  <v-select
                    v-model="id_ahs"
                    :items="detailDetails"
                    item-text="name"
                    item-value="id_ahs"
                    label="AHS"
                    append-icon="expand_more"
                  >
                  </v-select>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="2">
                  <v-text-field
                    label="Volume"
                    v-model="volume_new"
                    type="number"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="2">
                  <v-btn
                    dark
                    color="blue darken-3"
                    elevation="3"
                    small
                    rounded
                    @click="addcalculate"
                    style="margin-top:18px"
                  >Add
                  </v-btn>
                </v-col>
              </v-row>

              <v-list-group v-for="ahs in AHSData" :key="ahs.id_ahs_lokal">
                <template v-slot:activator>
                  <v-list-item-content>
                    <v-layout>
                      <v-flex xs7>
                        <div class="caption grey--text">{{ahs.structure}}-{{ahs.floor}}</div>
                        <div align="justify">{{ ahs.project }}</div>
                      </v-flex>
                      <v-flex xs5 style="padding-left:15px">
                        <div class="caption grey--text">{{ahs.task}}</div>
                        <div>{{ ahs.name }}</div>
                      </v-flex>
                      <v-flex xs3 style="padding-left:10px">
                        <div class="caption grey--text">Status</div>
                        <div>{{ ahs.status }}</div>
                      </v-flex>
                      <v-flex xs3 v-if="ahs.status=='Price'">
                        <div class="caption grey--text">Volume</div>
                        <div>{{ ahs.volume.toString().replace(".", ",") }}</div>
                      </v-flex>
                      <v-flex xs3 v-if="ahs.status=='Volume'">
                        <div class="caption grey--text">Volume</div>
                        <div>{{ (ahs.volume * ahs.adjustment).toFixed(2).toString().replace(".", ",") }}</div>
                      </v-flex>
                      <v-flex xs3>
                        <div class="caption grey--text">Satuan</div>
                        <div>{{ ahs.satuan }}</div>
                      </v-flex>
                      <v-flex xs2>
                        <div class="caption grey--text">Adjust</div>
                        <div style>{{ ahs.adjustment }}</div>
                      </v-flex>
                      <v-flex xs7>
                        <div class="caption grey--text">HSP (LBO)</div>
                        <v-layout v-if="ahs.status=='Volume'">
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HSP_before_overhead).toLocaleString('id-ID') }}</div>
                        </v-layout>
                        <v-layout v-if="ahs.status=='Price'">
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HSP_before_overhead * ahs.adjustment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex xs7>
                        <div class="caption grey--text">HSP (LAO)</div>
                        <v-layout v-if="ahs.status=='Volume'">
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HSP).toLocaleString('id-ID') }}</div>
                        </v-layout>
                        <v-layout v-if="ahs.status=='Price'">
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HSP * ahs.adjustment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                  </v-list-item-content>
                  <v-dialog v-model="dialogedit" width="850px">
                    <template v-slot:activator="{ on }">
                      <v-icon color="green" @click="itemEdit(ahs);dialogedit=true;detailTable=false" v-on="on">edit</v-icon>
                    </template>

                    <v-toolbar dark color="light-blue accent-4">
                      <v-btn icon dark @click="dialogedit = false">
                        <v-icon>close</v-icon>
                      </v-btn>
                      <v-toolbar-title>Edit Calculate</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                        <v-btn dark text @click="editcalculate(AHS.id_ahs_lokal)" :loading="loading">Save</v-btn>
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
                                  readonly
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
                                  readonly
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
                                  readonly
                                ></v-select>
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex sm3 md3 xs3>
                                <v-select
                                  v-model="AHS.id_ahs"
                                  label="Task"
                                  :items="detailDetails"
                                  item-text="name"
                                  item-value="id_ahs"
                                  :return-object="false"
                                  readonly
                                ></v-select>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field 
                                  v-model="AHS.satuan" 
                                  label="Satuan"
                                  readonly
                                >
                                </v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field 
                                  v-model="AHS.volume" 
                                  label="Volume"
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3a style="margin-left:10px">
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
                                  readonly
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
                                  readonly
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
                              <v-layout>
                                <div style="text-align:left;width:30px">Rp.</div>
                                <div style="text-align:right;width:90px">{{ Number(item.sub_total_lokal).toLocaleString('id-ID') }}</div>  
                              </v-layout>
                              <!-- <v-layout v-if="AHS.status =='Volume'">
                                <div style="text-align:left;width:30px">Rp.</div>
                                <div style="text-align:right;width:90px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>  
                              </v-layout> -->
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

                  <v-icon color="red" @click="deletecalculate(ahs);detailTable=false;">delete</v-icon>
                  <v-icon color="light-blue accent-3" @click="detailTable=true">expand_more</v-icon>
                </template>
                <template>
                  <v-data-table
                    :headers="headers"
                    sortBy="status"
                    update: sort-desc
                    class="elevation-10"
                    :items="ahs.detail.data"
                    v-if="detailTable"
                  >
                  <template v-slot:top>
                    <v-layout style="padding:10px">
                      <v-flex>
                        <v-layout v-if="ahs.status=='Volume'">
                          <div class="body-2 black--text font-weight-bold">Total of Labor : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_labor).toLocaleString('id-ID') }}</div>
                        </v-layout>
                        <v-layout v-if="ahs.status=='Price'">
                          <div class="body-2 black--text font-weight-bold">Total of Labor : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_labor * ahs.adjustment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex>
                        <v-layout v-if="ahs.status=='Volume'">
                          <div class="body-2 black--text font-weight-bold">Total of Materials : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_material).toLocaleString('id-ID') }}</div>
                        </v-layout>
                        <v-layout v-if="ahs.status=='Price'">
                          <div class="body-2 black--text font-weight-bold">Total of Materials : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_material * ahs.adjustment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex>
                        <v-layout v-if="ahs.status=='Volume'">
                          <div class="body-2 black--text font-weight-bold">Total of Equipment : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_equipment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                        <v-layout v-if="ahs.status=='Price'">
                          <div class="body-2 black--text font-weight-bold">Total of Equipment : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_equipment * ahs.adjustment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                  </template>
                  
                  <template v-slot:item.sub_total="{ item }">
                    <v-layout>
                      <div style="text-align:left;width:30px">Rp.</div>
                      <div style="text-align:right;width:90px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                  </template>

                  <template v-slot:item.sub_total_lokal="{ item }">
                    <v-layout v-if="item.status_job == 'Volume'">
                      <div style="text-align:left;width:30px">Rp.</div>
                      <div style="text-align:right;width:90px">{{ Number(item.sub_total_lokal).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                    <v-layout v-if="item.status_job == 'Price'">
                      <div style="text-align:left;width:30px">Rp.</div>
                      <div style="text-align:right;width:90px">{{ Number(item.sub_total_lokal * AHS.adjustment).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                  </template>

                  <template v-slot:item.price="{ item }">
                    <v-layout>
                      <div style="text-align:left;width:30px">Rp.</div>
                      <div style="text-align:right;width:90px">{{ Number(item.price).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                  </template>
                  </v-data-table>
                </template>
              </v-list-group>   
            </v-container>
          </template>
        </v-card>
    </v-container>
  </v-app>
</template>

<script>
import rabDetails from './../service/AHSLokal'
import job from './../service/Job'
import rab from './../service/RAB'
import details from './../service/Details'
import ahsLokalDetails from './../service/AHSLokalDetails'
import ahs from './../service/AHS'
import detailController from './../service/AHSLokalDetails'

  export default {
    data: () => ({
      valid:true,
      dialogedit:false,
      detailTable: false,
      loading: false,

      search:'',
      id_structure:'',
      id_groups:'',
      id_sub:'',
      id_ahs:'',
      id_project:'',
      id_job:'',
      volume_new:0,

      ahs: [],
      job:[],
      rab:[],
      detailStructure:[],
      detailGroup:[],
      detailTask:[],
      detailMaterial:[],
      detailDetails:[],
      Material:[],

      Structure:[],
      Groups:[],
      TaskSub:[],
      AHSData:[],

      temprab:{},
      temp:{},
      AHS:{},
      AHSDefault:{},

      headers: [
        {text: 'Status', align: 'left', sortable: true, value: 'status'},
        {text: 'Item', align: 'left', sortable: false, value: 'name'},
        {text: 'Price', align: 'left', sortable: false, value: 'price'},
        {text: 'Coefficient', align: 'center', sortable: false, value: 'coefficient'},
        {text: 'Sub Total (M)', align: 'left', sortable: false, value: 'sub_total', },
        {text: 'Sub Total (L)', align: 'left', sortable: false, value: 'sub_total_lokal'},
        {text: 'Requirements M/L', align: 'center', sortable: false, value: 'requirements_ml'},
        {text: 'Unit', align: 'center', sortable: false, value: 'satuan'},
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getJob()
      this.getRAB()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
            if(this.search == '')
              return data
            else{
              return (data.name.match(this.search) || 
                data.project.match(this.search)) 
            }
        });
      }
    },
    methods: {
      async getRAB()
      {
        try{
          this.rab = (await rab.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      itemHandler(ahs)
      {
        this.AHS = ahs
        this.index = this.calculateTemp.indexOf(ahs)
      },
      async itemEdit(item)
      {
        console.log('Item Edit',item)
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailDetails=[]
        this.Material = []
        let ahsLokal = this.AHSData.find(obj=>obj.id_ahs_lokal == item.id_ahs_lokal)
        console.log('ahs lokal',ahsLokal)
        this.AHS = ahsLokal
        console.log('AHS Lokal',this.AHS)

        this.ahsAll = (await ahs.getall()).data
        this.detailDetails = this.ahsAll.filter(obj=>obj.id_sub == item.id_sub)
        console.log('detail ahs',this.detailDetails)
        
        let RAB = this.rab.find(obj=>obj.id_rab == this.AHS.id_rab)
        console.log('RAB',RAB)
        for(let detailS of RAB.structure.data)
        {
          let detail = {
            id_structure_details  : detailS.id_structure_details,
            id_structure          : detailS.id_structure,
            structure             : detailS.structure
          }
          this.detailStructure.push(detail)
        }
        console.log('Structure',this.Structure)
        console.log('Detail Structure',this.detailStructure)
        console.log('RAB Structure Data',RAB.structure.data)
        for(let detailG of RAB.structure.data)
        {
          for(let detailgroup of detailG.group.data)
          {
            let detail = {
              id_group_details : detailgroup.id_group_details,
              id_structure  : detailgroup.id_structure,
              id_groups     : detailgroup.id_groups,
              structure     : detailgroup.structure,
              floor         : detailgroup.floor
            }
            this.detailGroup.push(detail)

            for(let detailtask of detailgroup.task_sub.data)
            {
              let detail = {
                id_sub_details : detailtask.id_sub_details,
                id_structure  : detailtask.id_structure,
                id_groups     : detailtask.id_groups,
                id_sub        : detailtask.id_sub,
                structure     : detailtask.structure,
                floor         : detailtask.floor,
                task          : detailtask.task
              }
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
              adjustment: material.adjustment
            }
            this.detailMaterial.push(each_detail)
          }
        console.log('Material',this.Material)
        console.log('Detail Material',this.detailMaterial)
      },
      deletecalculate(ahs)
      {
        this.AHSData.splice(this.AHSData.indexOf(ahs),1)
        console.log('delete calculate',this.AHSData)
      },
      editcalculate(id)
      {
        let data = this.AHSData.find(obj=>obj.id_ahs_lokal == id)
        console.log('Edit AHS Data',data)
        this.AHSData.splice(this.AHSData.indexOf(data),1,this.AHS)
        console.log('After Edit',this.AHSData)
        this.dialogedit = false
      },
      addcalculate()
      {
        let ahs_lokal = this.ahs.find(obj=>obj.id_ahs == this.id_ahs)
        console.log('ahs lokal after search',ahs_lokal)
        console.log('ahs_lokal.detail.data',ahs_lokal.detail.data)
        let i=1
        let newData = {
          id_ahs_lokal: ahs_lokal.id_ahs_lokal,
          id_sub_details: ahs_lokal.id_sub_details,
          overhead: ahs_lokal.overhead,
          adjustment: ahs_lokal.adjustment,
          id_job: ahs_lokal.id_job,
          name: ahs_lokal.name,
          satuan: ahs_lokal.satuan,
          status: ahs_lokal.status,
          id_project: ahs_lokal.id_project,
          project: ahs_lokal.project,
          name_sub: ahs_lokal.name_sub,
          id_structure: ahs_lokal.id_structure,
          id_groups: ahs_lokal.id_groups,
          id_sub: ahs_lokal.id_sub,
          structure: ahs_lokal.structure,
          floor: ahs_lokal.floor,
          task: ahs_lokal.task,
          id_rab: ahs_lokal.id_rab,
          HP: ahs_lokal.HP,
          HP_Adjust: ahs_lokal.HP_Adjust,
          volume: parseFloat(this.volume_new),
          total_labor: parseFloat(ahs_lokal.total_labor * this.volume_new).toFixed(2),
          total_material: parseFloat(ahs_lokal.total_material * this.volume_new).toFixed(2),
          total_equipment: parseFloat(ahs_lokal.total_equipment * this.volume_new).toFixed(2),
          HSP_before_overhead: parseFloat(ahs_lokal.HSP_before_overhead * this.volume_new).toFixed(2),
          HSP: parseFloat(ahs_lokal.HSP * this.volume_new).toFixed(2),
          id_ahs: ahs_lokal.id_ahs,
          kode: ahs_lokal.kode,
          detail: ahs_lokal.detail,
        }
        this.AHSData.push(newData)   
        console.log('ahs lokal',newData)
        console.log('calculte Temp',this.AHSData)
      },
      async filterStructures()
      {
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailDetails=[]
        // this.AHS = Object.assign({},this.AHSDefault)
        console.log('id project',this.id_project)
        this.temprab={}
        this.Structure=[]
        this.Groups=[]
        this.TaskSub=[]
        this.AHSData=[]

        this.temprab = this.rab.find(obj=>obj.id_project == this.id_project)
        console.log('item',this.temprab)
        this.detailStructure = (await details.show(this.temprab.id_rab)).data
        console.log('detail structure',this.detailStructure)
      },
      async filterGroups()
      {
        try{
          this.detailGroup=[]
          this.detailTask=[]
          this.detailDetails=[]

          let structure = this.detailStructure.find(obj=>obj.id_structure == this.id_structure)
          console.log('detail structure',structure)
          let detail = (await details.showG(structure.id_structure_details)).data
          console.log('detail group',detail)
          this.detailGroup = detail.filter(obj=>obj.id_structure == this.id_structure)
          console.log('filter detail group',this.detailGroup)
        }catch(err){
          console.log(err)
        }
      },
      async filterTask()
      {
        try{
          this.detailTask=[]
          this.detailDetails=[]
          
          let group = this.detailGroup.find(obj=>obj.id_structure == this.id_structure && 
                      obj.id_groups == this.id_groups)
          let detail = (await details.showT(group.id_group_details)).data
          console.log('detail group',detail)
          this.detailTask = detail.filter(obj=>obj.id_structure == this.id_structure && 
                            obj.id_groups == this.id_groups)
          console.log('filter detail task',this.detailTask)
        }catch(err){
          console.log(err)
        }
      },
      async filterAHS()
      {
        try{
          this.detailDetails=[]
          console.log('cek filter ahs')
          let task = this.detailTask.find(obj=>obj.id_structure == this.id_structure && 
                    obj.id_groups == this.id_groups && obj.id_sub == this.id_sub)
          console.log('detail task',task)
          let detail = (await rabDetails.showByID(task.id_sub_details)).data
          console.log('detail ahs',detail)
          this.detailDetails = detail.filter(obj=>obj.id_structure == this.id_structure && 
                            obj.id_groups == this.id_groups && obj.id_sub == this.id_sub)
          console.log('filter detail ahs',this.detailDetails)
        }catch(err){
          console.log(err)
        }
      },
      // async filterMaterials()
      // {
      //   try{
      //       this.AHS = this.detailDetails.find(obj=>obj.id_structure == this.id_structure && 
      //               obj.id_groups == this.id_groups && obj.id_sub == this.id_sub && obj.id_ahs == this.id_ahs)
      //     console.log('detail ahs',this.AHS)
      //     this.Material = (await ahsLokalDetails.getItem(this.AHS.id_ahs_lokal)).data
      //     console.log('materials of ahs',this.Material)
      //   }catch(err){
      //     console.log(err)
      //   }
      // },
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
      async getallAHS()
      {
        try{
          this.ahs = (await rabDetails.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getJob()
      {
        try{
          this.job = (await job.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
    }
  }
</script>

<style >
.marginBorder{
  margin-left: 10px;
}
</style>