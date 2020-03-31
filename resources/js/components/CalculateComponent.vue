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
      <v-card>
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
                  @change="filterMaterials"
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
                  @click="calculate"
                  style="margin-top:18px"
                >Check
                </v-btn>
              </v-col>
              <v-col cols="2">
                <v-btn
                  dark
                  color="green darken-3"
                  elevation="3"
                  small
                  rounded
                  @click="resetdata"
                  style="margin-top:18px"
                  v-if="reset"
                >Reset
                </v-btn>
              </v-col>
            </v-row>
            <v-card elevation="10">
              <v-list-group>
                <template v-slot:activator>
                  <v-list-item-content>
                    <v-layout>
                      <v-flex xs4>
                        <div class="caption grey--text">Task Group</div>
                        <div style>{{ AHS.name_sub }}</div>
                      </v-flex>
                      <v-flex xs5>
                        <div class="caption grey--text">Task</div>
                        <div>{{ AHS.name }}</div>
                      </v-flex>
                      <v-flex xs6>
                        <div class="caption grey--text">Total of Labor</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:100px">{{ Number(AHS.total_labor).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex xs6>
                        <div class="caption grey--text">Total of Materials</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:100px">{{ Number(AHS.total_material).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex xs6>
                        <div class="caption grey--text">Total of Equipment</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:100px">{{ Number(AHS.total_equipment).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                      <v-flex xs6>
                        <div class="caption grey--text">HSP Overhead</div>
                        <v-layout>
                          <div style="text-align:left;width:25px">Rp.</div>
                          <div style="text-align:right;width:100px">{{ Number(AHS.HSP_before_overhead).toLocaleString('id-ID') }}</div>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                  </v-list-item-content>
                    <v-icon color="light-blue accent-3" @click="detailTable=true">expand_more</v-icon>
                </template>

                <template>
                  <div>
                    <v-data-table
                      :headers="headers"
                      sortBy="status"
                      update: sort-desc
                      class="elevation-10"
                      :items="this.AHS.detail.data"
                      v-if="detailTable"
                    >
                    <template v-slot:item.sub_total="{ item }">
                      <v-layout>
                        <div style="text-align:left;width:30px">Rp.</div>
                        <div style="text-align:right;width:90px">{{ Number(item.sub_total).toLocaleString('id-ID') }}</div>  
                      </v-layout>
                    </template>

                    <template v-slot:item.price="{ item }">
                      <v-layout>
                        <div style="text-align:left;width:30px">Rp.</div>
                        <div style="text-align:right;width:90px">{{ Number(item.price).toLocaleString('id-ID') }}</div>  
                      </v-layout>
                    </template>
                    </v-data-table>
                  </div>
                </template>
              </v-list-group>
            </v-card>
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

  export default {
    data: () => ({
      detailTable: false,
      reset: false,

      search:'',
      id_structure:'',
      id_groups:'',
      id_sub:'',
      id_ahs:'',
      id_project:'',
      id_job:'',
      rap:0,
      volume_new:0,
      labor: 0,
      material: 0,
      hsp: 0,
      hp:0,
      hp_adjust:0,
      adjust:0,
      
      ahs: [],
      job:[],
      rab:[],
      detailStructure:[],
      detailGroup:[],
      detailTask:[],
      detailDetails:[],
      Material:[],

      AHS:{
        kode:'',
        id_ahs:'',
        name: '',
        name_sub:'', 
        total_labor: 0,
        total_material: 0,
        total_before_overhead: 0,
        overhead: 0,
        HSP_before_overhead: 0,
        total_equipment: 0,
      },
      AHSDefault:{
        kode:'',
        id_ahs:'',
        name: '',
        name_sub:'', 
        total_labor: 0,
        total_material: 0,
        total_before_overhead: 0,
        overhead: 0,
        HSP_before_overhead: 0,
        total_equipment: 0,
      },
      headers: [
        {text: 'ID', align: 'left', sortable: false, value: 'kode',width:'15%'},
        {text: 'Status', align: 'left', sortable: true, value: 'status',width:'15%'},
        {text: 'Item', align: 'left', sortable: false, value: 'name',width:'15%'},
        {text: 'Unit', align: 'left', sortable: false, value: 'satuan',width:'15%',align:'center'},
        {text: 'Price', align: 'left', sortable: false, value: 'price', width:'10%'},
        {text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient', width:'15%', align: 'center'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total', width:'10%'},
        // {text: 'Volume', align: 'left', sortable: false, value: 'volume', width:'15%', align: 'center'},
        // {text: 'Actions', align: 'left', sortable: false, value: 'action', width:'15%'},
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
      calculate()
      {
        this.AHS.total_labor = parseFloat(this.AHS.total_labor * this.volume_new).toFixed(2)
        this.AHS.total_material = parseFloat(this.AHS.total_material * this.volume_new).toFixed(2)
        this.AHS.total_equipment = parseFloat(this.AHS.total_equipment * this.volume_new).toFixed(2)
        this.AHS.total_equipment = parseFloat(this.AHS.total_equipment * this.volume_new).toFixed(2)
        this.AHS.HSP_before_overhead = parseFloat(this.AHS.HSP_before_overhead * this.volume_new).toFixed(2)
        console.log('detail',this.AHS.detail.data)
        for(let data of this.AHS.detail.data)
        {
          let each = {
            id_ahs_lokal_details : data.id_ahs_lokal_details,
            id_ahs_lokal : data.id_ahs_lokal,
            kode: data.kode,
            id_material : data.id_material,
            coefficient : data.coefficient,
            sub_total : parseFloat(data.price * data.coefficient * this.volume_new).toFixed(2), 
            adjustment : data.adjustment,
            name : data.name,
            type : data.type,
            price : parseFloat(data.price * this.volume_new).toFixed(2),
            status : data.status,
            satuan : data.satuan,
            volume: data.volume,
            id_structure: data.id_structure,
            id_groups: data.id_groups,
            id_sub: data.id_sub,
            id_job: data.id_job,
            id_sub_details: data.id_sub_details,
            id_ahs: data.id_ahs
          }
          this.AHS.detail.data.splice(this.AHS.detail.data.indexOf(data),1,each)
        }
        this.reset = true
      },
      resetdata()
      {
        console.log('reset')
        this.AHS.total_labor = parseFloat(this.AHS.total_labor/this.volume_new).toFixed(2)
        this.AHS.total_material = parseFloat(this.AHS.total_material/this.volume_new).toFixed(2)
        this.AHS.total_equipment = parseFloat(this.AHS.total_equipment/this.volume_new).toFixed(2)
        this.AHS.HSP_before_overhead = parseFloat(this.AHS.HSP_before_overhead/this.volume_new).toFixed(2)
        for(let data of this.AHS.detail.data)
        {
          let each = {
            id_ahs_lokal_details : data.id_ahs_lokal_details,
            id_ahs_lokal : data.id_ahs_lokal,
            kode: data.kode,
            id_material : data.id_material,
            coefficient : data.coefficient,
            sub_total : parseFloat(data.price * data.coefficient / this.volume_new).toFixed(2), 
            adjustment : data.adjustment,
            name : data.name,
            type : data.type,
            price : parseFloat(data.price /this.volume_new).toFixed(2),
            status : data.status,
            satuan : data.satuan,
            volume: data.volume,
            id_structure: data.id_structure,
            id_groups: data.id_groups,
            id_sub: data.id_sub,
            id_job: data.id_job,
            id_sub_details: data.id_sub_details,
            id_ahs: data.id_ahs
          }
          this.AHS.detail.data.splice(this.AHS.detail.data.indexOf(data),1,each)
        }
        // this.volume_new = 0 
        this.reset = false
      },
      async filterStructures()
      {
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailDetails=[]
        this.AHS = Object.assign({},this.AHSDefault)
        console.log('id project',this.id_project)
        let item = this.rab.find(obj=>obj.id_project == this.id_project)
        console.log('item',item)
        this.detailStructure = (await details.show(item.id_rab)).data
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
          let detail = (await rabDetails.show(task.id_sub_details)).data
          console.log('detail ahs',detail)
          this.detailDetails = detail.filter(obj=>obj.id_structure == this.id_structure && 
                            obj.id_groups == this.id_groups && obj.id_sub == this.id_sub)
          console.log('filter detail ahs',this.detailDetails)
        }catch(err){
          console.log(err)
        }
      },
      async filterMaterials()
      {
        try{
            this.AHS = this.detailDetails.find(obj=>obj.id_structure == this.id_structure && 
                    obj.id_groups == this.id_groups && obj.id_sub == this.id_sub && obj.id_ahs == this.id_ahs)
          console.log('detail ahs',this.AHS)
          this.Material = (await ahsLokalDetails.getItem(this.AHS.id_ahs_lokal)).data
          console.log('materials of ahs',this.Material)
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
.table {
  font-family: Montserrat-Medium;
  font-size: 40px;
  /* color: #fff; */
  line-height: 1.4;
  text-transform: uppercase;

  /* background-color: #5f37e2; */
  color: aqua;
}
.borderAhsLokal{
  border-left: 4px solid #40C4FF
}
</style>