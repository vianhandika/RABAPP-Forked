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

          <v-col cols="5">
            <v-text-field
              v-model="search"
              append-icon="search"
              label="Search"
              single-line
              hide-details
            >
            </v-text-field>
          </v-col>
          
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
                    @input="filterStructures"
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
                    @input="filterGroups"
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
                    @input="filterTask"
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
                    @input="filterAHS"
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

              <v-list-group v-for="ahs in filtered" :key="ahs.index">
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
                      <v-flex xs3>
                        <div class="caption grey--text">Volume</div>
                        <div>{{ (ahs.volume).toString().replace(".", ",") }}</div>
                      </v-flex>
                      <v-flex xs3>
                        <div class="caption grey--text">Satuan</div>
                        <div>{{ ahs.satuan }}</div>
                      </v-flex>
                      <v-flex xs2>
                        <div class="caption grey--text">Adj</div>
                        <div style>{{ ahs.adjustment }}</div>
                      </v-flex>
                      <v-flex xs7>
                        <div class="caption grey--text">HSP (LAO)</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HSP).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex xs7>
                        <div class="caption grey--text">HP</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:120px">{{ Number(ahs.HP_Adjust).toLocaleString('id-ID') }}</div>
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
                        <v-btn dark text @click="editcalculate(AHS.id_calculate)" :loading="loading">Save</v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <template>
                      <v-card>
                        <v-form ref="form">
                          <v-card-text>
                            <v-layout>
                              <v-flex sm6 md6 xs6>      
                                <v-text-field 
                                  v-model="AHS.project"
                                  label="Project"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.structure"
                                  label="Structure"
                                  :return-object="false" 
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.floor"
                                  label="Floor"
                                  :return-object="false" 
                                  readonly
                                ></v-text-field>
                              </v-flex>
                              <v-flex sm3 md3 xs3 style="margin-left:10px">
                                <v-text-field
                                  v-model="AHS.task"
                                  label="Task Group"
                                  readonly
                                ></v-text-field>
                              </v-flex>
                            </v-layout>

                            <v-layout>
                              <v-flex sm6 md6 xs6>
                                <v-text-field
                                  v-model="AHS.name"
                                  label="Task"
                                  :return-object="false"
                                  readonly
                                ></v-text-field>
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
                                  @change="volume"
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

                            <template v-slot:item.requirements_ml="{ item }">
                              <v-layout>
                                <div style="text-align:right;width:90px">{{ Number(item.coefficient * item.adjustment * ahs.volume).toLocaleString('id-ID') }}</div>  
                              </v-layout>
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
                        <v-layout>
                          <div class="body-2 black--text font-weight-bold">Total of Labor : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_labor).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex>
                        <v-layout>
                          <div class="body-2 black--text font-weight-bold">Total of Materials : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_material).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex>
                        <v-layout>
                          <div class="body-2 black--text font-weight-bold">Total of Equipment : Rp.</div>
                          <div style="width:120px;padding-left:10px" class="body-2 black--text font-weight-bold">{{ Number(ahs.total_equipment).toLocaleString('id-ID') }}</div>
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

                  <template v-slot:item.requirements_ml="{ item }">
                    <v-layout>
                      <div style="text-align:right;width:90px">{{ Number(item.coefficient * item.adjustment * ahs.volume).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                  </template>

                  <template v-slot:item.price="{ item }">
                    <v-layout>
                      <div style="text-align:left;width:30px">Rp.</div>
                      <div style="text-align:right;width:90px">{{ Number(item.price).toLocaleString('id-ID') }}</div>  
                    </v-layout>
                  </template>

                  <template v-slot:item.adjustment="{item}">
                    <v-edit-dialog
                      :return-value.sync="item.adjustment"
                      @save="updateAdjustmentLokalM(item)"
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
import rab from './../service/RAB'
import details from './../service/Details'
import ahs from './../service/AHS'
import materialController from './../service/Material'

  export default {
    data: () => ({
      dialogedit:false,
      detailTable: false,
      loading: false,

      search:'',
      id_structure:'',
      id_groups:'',
      id_sub:'',
      id_ahs:'',
      id_project:'',
      volume_new:0,
      id:1,

      ahs: [],
      rab:[],
      detailStructure:[],
      detailGroup:[],
      detailTask:[],
      detailMaterial:[],
      detailDetails:[],
      Material:[],
      material:[],

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
        {text: 'Adj BT', align: 'center', sortable: false, value: 'adjustment'},
        {text: 'Sub Total (L)', align: 'left', sortable: false, value: 'sub_total', },
        {text: 'Requirements M/L', align: 'center', sortable: false, value: 'requirements_ml'},
        {text: 'Unit', align: 'center', sortable: false, value: 'satuan'},
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getRAB()
      this.getMaterial()
    },
    computed: {
      filtered:function(){
        return this.AHSData.filter((data)=>{
            if(this.search == '')
              return data
            else{
              return (data.name.toLowerCase().match(this.search) || 
                data.project.toLowerCase().match(this.search)) 
            }
        });
      }
    },
    methods: {
      async getMaterial()
      {
        try{
          this.material = (await materialController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getRAB()
      {
        try{
          this.rab = (await rab.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async itemEdit(item)
      {
        this.Material = []
        let ahsLokal = this.AHSData.find(obj=>obj.id_calculate == item.id_calculate)
        this.AHS = ahsLokal
        this.Material = this.AHS.detail.data

        console.log('AHS Lokal',this.AHS)
        console.log('Material',this.Material)
      },
      deletecalculate(ahs)
      {
        this.AHSData.splice(this.AHSData.indexOf(ahs),1)
      },
      volume()
      {
        this.AHS.HP = this.AHS.HSP * this.AHS.volume
        this.AHS.HP_Adjust = this.AHS.HP * this.AHS.adjustment
      },
      editcalculate(id)
      {
        this.loading = true
        let data = this.AHSData.find(obj=>obj.id_calculate == id)
        data.HP = this.AHS.HP
        data.HP_Adjust = this.AHS.HP_Adjust 
        data.HSP = this.AHS.HSP
        data.HSP_before_overhead = this.AHS.HSP_before_overhead
        data.total_labor = this.AHS.total_labor
        data.total_material = this.AHS.total_material
        data.total_equipment = this.AHS.total_equipment
        data.volume = this.AHS.volume        
        
        this.dialogedit = false
        this.loading=false
        
        console.log('Edit AHS Data',data)
        console.log('AHS Data',this.AHSData)
      },
      async addcalculate()
      {
        let ahs_lokal = this.detailDetails.find(obj=>obj.id_ahs == this.id_ahs)
        for(let data of ahs_lokal.detail.data)
        {
          let newD = {
            id_calculate: this.id,
            id_material: data.id_material,
            status: data.status,
            adjustment: data.adjustment,
            sub_total: data.sub_total,
            name: data.name, 
            price: data.price,
            satuan: data.satuan,
            coefficient: data.coefficient
          }
          ahs_lokal.detail.data.splice(ahs_lokal.detail.data.indexOf(data),1,newD)
        }
        let newData = {
          id_calculate: this.id,
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
          HP: ahs_lokal.HSP * this.volume_new,
          HP_Adjust: ahs_lokal.HSP * this.volume_new * ahs_lokal.adjustment,
          volume: parseFloat(this.volume_new),
          total_labor: ahs_lokal.total_labor,
          total_material: ahs_lokal.total_material,
          total_equipment: ahs_lokal.total_equipment,
          HSP_before_overhead: ahs_lokal.HSP_before_overhead,
          HSP: ahs_lokal.HSP,
          id_ahs: ahs_lokal.id_ahs,
          kode: ahs_lokal.kode,
          detail: ahs_lokal.detail,
        }
        this.AHSData.push(newData)
        this.id++;   
        this.ahs = (await rabDetails.get()).data
        console.log('AHS Data',this.AHSData)
        console.log('AHS Lokal After Edit',this.ahs)
      },
      updateAdjustmentLokal(item)
      {
        let materialData = this.material.find(obj=>obj.id_material == item.id_material)
        item.sub_total = item.adjustment * materialData.price * item.coefficient
        
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
        
        this.AHS.HSP_before_overhead = parseFloat(this.AHS.HSP_before_overhead) + parseFloat(this.AHS.total_equipment)
        this.AHS.HSP = this.AHS.HSP_before_overhead + (this.AHS.HSP_before_overhead * this.AHS.overhead/100)
        this.AHS.HP = this.AHS.HSP * this.AHS.volume
        this.AHS.HP_Adjust = this.AHS.HP * this.AHS.adjustment
        console.log('AHS',this.AHS)
        this.update()
      },
      updateAdjustmentLokalM(item)
      {
        let ahs_lokal = this.AHSData.find(obj=>obj.id_calculate == item.id_calculate)
        let materialData = this.material.find(obj=>obj.id_material == item.id_material)
        
        item.sub_total = item.adjustment * materialData.price * item.coefficient
        ahs_lokal.HSP_before_overhead=0
        ahs_lokal.total_material=0
        ahs_lokal.total_labor=0

        for(let data of ahs_lokal.detail.data)
        {
          let materialData = this.material.find(obj=>obj.id_material == data.id_material)
          if(materialData.status == 'labor')
            ahs_lokal.total_labor += data.sub_total
          else
            ahs_lokal.total_material += data.sub_total
          ahs_lokal.HSP_before_overhead += data.sub_total
        }
        ahs_lokal.HSP_before_overhead = parseFloat(ahs_lokal.HSP_before_overhead) + parseFloat(ahs_lokal.total_equipment)
        ahs_lokal.HSP = ahs_lokal.HSP_before_overhead + (ahs_lokal.HSP_before_overhead * ahs_lokal.overhead/100)
        ahs_lokal.HP = ahs_lokal.HSP * ahs_lokal.volume
        ahs_lokal.HP_Adjust = ahs_lokal.HP * ahs_lokal.adjustment
        this.update()
        console.log('AHS After Edit',this.AHSData)
      },
      equipment()
      {
        let temp = 0
        for(let material of this.Material)
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
      async filterStructures()
      {
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailDetails=[]
        let rab = this.rab.find(obj=>obj.id_project == this.id_project)
        console.log('item',rab)
        this.detailStructure = (await details.show(rab.id_rab)).data
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
    }
  }
</script>

<style >
.marginBorder{
  margin-left: 10px;
}
</style>