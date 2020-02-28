<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar dark color="light-blue accent-3">
        <v-toolbar-title>AHS Lokal</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>

          <v-select
            hide-details
            label="Choose Project"
            v-model="select"
            :items="project"
            item-text="project"
            item-value="id_project"
            prepend-inner-icon="expand_more"
            single-line
          >
          </v-select>
          <v-spacer></v-spacer>

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
        <v-list-group v-for="data in filtered" :key="data.id_ahs_lokal" @click="getItem(data.id_ahs_lokal)" active-class="borderAhsLokal">
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <v-flex xs2>
                  <div class="caption grey--text">Project</div>
                  <div>{{ data.project }}</div>
                </v-flex>
                <!-- <v-flex xs1>
                  <div class="caption grey--text">ID AHS</div>
                  <div>{{ data.id_ahs_lokal }}</div>
                </v-flex> -->
                <v-flex xs2>
                  <div class="caption grey--text">Task Group</div>
                  <div>{{ data.name_sub }}</div>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">Task</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex xs1>
                  <div class="caption grey--text">Adjust</div>
                  <div>{{ data.adjustment }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total of Labor</div>
                  <v-layout>
                    <div style="text-align:left;width:50px">Rp.</div>
                    <div style="text-align:right;width:50px">{{ Number(data.total_labor).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total of Materials</div>
                  <v-layout>
                    <div style="text-align:left;width:50px">Rp.</div>
                    <div style="text-align:right;width:50px">{{ Number(data.total_material).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total</div>
                  <v-layout>
                    <div style="text-align:left;width:50px">Rp.</div>
                    <div style="text-align:right;width:50px">{{ Number(data.HSP).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs1>
                  <div class="caption grey--text">Actions</div>
                  <!-- <v-icon color="green" @click="itemHandler(data);dialog5=true">edit</v-icon> -->
                  <v-icon color="red" @click="itemHandler(data);dialog6=true">delete</v-icon>
                </v-flex>
              </v-layout>
            </v-list-item-content>
            <v-icon color="light-blue accent-3">expand_more</v-icon>
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
            <div>
              <v-data-table
                :headers="headers"
                sortBy="status"
                update: sort-desc
                class="elevation-10"
                :items="data.detail.data"
              >
              <template v-slot:item.sub_total="{ item }">
                <v-layout>
                  {{ 'Rp. '}}
                  <v-spacer></v-spacer>
                  {{ Number(item.sub_total).toLocaleString('id-ID') }}
                </v-layout>
              </template>

              <template v-slot:item.price="{ item }">
                <v-layout>
                  {{ 'Rp. '}}
                  <v-spacer></v-spacer>
                  {{ Number(item.price).toLocaleString('id-ID') }}
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
                    >
                      delete
                    </v-icon>
                  </template>
                      <v-card>
                        <v-card-title class="headline">Confirmation</v-card-title>
                          <v-card-text>Are you sure want to delete this detail?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="green darken-1" text @click="dialog8 = false; deleteDetail(item.id_ahs_lokal_details)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="dialog8 = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                </v-dialog>
              </template>

              </v-data-table>

              <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
                {{ snackText }}
                <v-btn text @click="snack = false">Close</v-btn>
              </v-snackbar>
              
            </div>
          </template>
        </v-list-group>
      </v-card>
    </v-container>

    
  </v-app>
</template>

<script>
import Controller from './../service/Job'
import materialController from './../service/Material'
import ahsController from './../service/AHSAdjust'
import ahs from './../service/AHS'
import detailController from './../service/AHSLokalDetails'
import task from './../service/TaskSub'
import project from './../service/Project'
import rabdetails from './../service/RAB'

  export default {
    data: () => ({
      valid: true,

      snack: false,
      snackColor: '',
      snackText: '',
      
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      dialog5: false,
      dialog6: false,
      dialog7: false,
      dialog8: false,
      menu: false,
      tambah: false,

      search:'',
      select:'',
      
      ahs: [],
      ahsDefault:[],
      job: [],
      material:[],
      details:[],
      detailsData:[],
      detailsDefault:[],
      detailsTemp:[],

      task:[],
      project:[],
      temp:[],
      filter:[],

      detail: {
        id_material:'',
        coefficient:'',
        sub_total:''
      },

      Job: {
        name:'',
        satuan: '',
        details: '',
        id_job: '',
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
      AHSDefault:{
        kode:'',
        id_ahs:'',
        id_job: '',
        id_sub:'', 
        total_labor: 0,
        total_material: 0,
        total: 0
      },
      ahs_details:{
        id_ahs_lokal_details:'',
        id_material: '',
        coefficient: 0,
        adjustment: 0,
        sub_total : 0,
      },
      ahs_details_default:{
        id_ahs:'',
        id_ahs_details:'',
        id_material: '',
        coefficient: 0,
        sub_total : 0,
      },
      
      Material:{
        id_material:'',
      },
      headers: [
        { 
          text: 'ID', align: 'left', sortable: false, value: 'kode',
        },
        { 
          text: 'Type', align: 'left', sortable: false, value: 'status',
        },
        { 
          text: 'Item', align: 'left', sortable: false, value: 'name',
        },
        { 
          text: 'Price', align: 'left', sortable: false, value: 'price', width:'10%'
        },
        { 
          text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient', align:'center'
        },
        { 
          text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total', width:'10%'
        },
        { 
          text: 'Adjustment', align: 'left', sortable: false, value: 'adjustment', align: 'center'
        },
        {
          text: 'Actions', align: 'left', sortable: false, value: 'action'
        },
      ],
      headersAHS: [
        { 
          text: 'ID', align: 'left', sortable: false, value: 'kode',
        },
        { 
          text: 'Type', align: 'left', sortable: true, value: 'status',
        },
        { 
          text: 'Item', align: 'left', sortable: false, value: 'name',
        },
        { 
          text: 'Price', align: 'left', sortable: false, value: 'price',
        },
        {
          text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient'
        },
        {
          text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total'
        },
        { 
          text: 'Adjustment', align: 'left', sortable: false, value: 'sub_adjustment',
        },
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getall()
      this.getallItem()
      this.getallItemMaterial()
      this.getTask()
      this.getProject()
      this.getallAHSDefault()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
          if(this.select != '')
            {
              if(this.select == data.id_project)
              {
                if(this.search == '')
                  return data
                else{
                  return (data.name.match(this.search) ||
                    data.volume.toLocaleString().match(this.search))
                }
              }
            }else{
              return (data.name.match(this.search) ||
                data.volume.toLocaleString().match(this.search))
            }
        });
      }
    },
    methods: {
      save () {
        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Data saved'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      itemHandler(item){
        this.AHS = item
        this.ahs_details = item.detail.data
        console.log(this.ahs_details)
        this.tambah = true
      },
      itemHandlerAHS(item)
      {
        console.log('cek item')
        console.log(item)
        this.AHSDefault = item
        this.detailsDefault = item.ahs_details.data
        console.log('cek adjust details')
        console.log(this.detailsDefault)
        tambah=true
      },
      itemDetailHandler(item){
        this.detail = item
        console.log(this.detail)
      },
      getDetails(id)
      {
        let data = this.ahsDefault.find(obj=>obj.id_ahs == id)
        console.log(data)
        this.AHS.id_job = data.id_job
        this.AHS.id_sub = data.id_sub
        this.detailsDefault = data.ahs_details.data
        console.log(this.detailsDefault)
        this.tambah=true
      },
      filterAHS(id)
      {
        console.log(id)
        console.log('ahs')
        this.getallAHSDefault()
        this.temp=this.ahsDefault
        console.log(this.temp)
        for(let ahs of this.ahs)
        {
          if(ahs.id_project == id)
          {
            for(let ahsdefault of this.ahsDefault)
            {
              if(ahsdefault.id_job == ahs.id_job)
                this.temp.splice(this.temp.indexOf(ahsdefault),1)
            }
          }
          console.log(this.temp)
        }
        this.temp=[...this.temp]
        console.log('temp')
        console.log(this.temp)
        this.filter = this.temp
        console.log('filter')
        console.log(this.filter)
        
      },
      async addList()
      {
        var object 
        let data = this.material.find(obj=>obj.id_material == this.detail.id_material)
        console.log(data)
        object.id_material = this.detail.id_material
        object.coefficient = this.detail.coefficient
        object.sub_total   = data.price * object.coefficient
        
        if(data.status == "material")
        {
          this.AHS.total_material = parseInt(object.sub_total) + parseInt(this.AHS.total_material)
        }
        if(data.status == "labor")
        {
          this.AHS.total_labor = parseInt(object.sub_total) + parseInt(this.AHS.total_labor)
        }
        this.AHS.total     = parseInt(object.sub_total) + parseInt(this.AHS.total)
        console.log(this.AHS.total)

        this.details.push(JSON.parse(JSON.stringify(object)))
        console.log(this.details)
        this.tambah = false
        this.Material.id_material=""
        this.detail.coefficient=0
        this.detail.sub_total = 0
      },
      deleteList(data){
        if(data.status == "material")
          this.AHS.total_material -= data.sub_total
        if(data.status == "labor")
          this.AHS.total_labor -= data.sub_total

        this.AHS.total = parseInt(this.AHS.total - data.sub_total,10)
        this.details.splice(this.details.indexOf(data),1)
        this.details=[...this.details]
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getall(){
        try{
          this.detailsData = (await ahsController.getDetails()).data
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
          this.ahs = (await ahsController.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHSDefault()
      {
        try{
          this.ahsDefault = (await ahs.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getAHSDefaultFilter()
      {
        
      },
      // async updateItem(id){
      //   try{
      //       const payload = {
      //         kode    : this.AHS.kode,
      //         id_sub  : this.AHS.id_sub,
      //         total   : this.AHS.total,
      //         total_labor : this.AHS.total_labor,
      //         total_material  : this.AHS.total_material,
      //         detail  : this.details
      //       } 
      //       await ahsController.updateItem(payload,id)
      //       this.close()
      //   }catch(err){
      //     console.log(err);
      //   }
      // },
      async updateAdjustment(props){
        try{
            const payload = {
              adjustment   : props.item.adjustment,
            } 
            await detailController.updateDetail(payload,props.item.id_ahs_lokal_details)
            this.getItem(props.item.id_ahs_lokal_details)
            this.close()
            this.save()
        }catch(err){
          console.log(err);
        }
      }, 
      // async updateCoefficient(props)
      // {
      //   try{
      //     const payload = {
      //       coefficient : props.item.coefficient,
      //     }
      //     await detailController.(payload, props.item.id_ahs_lokal_details)
      //     this.getItem(props.item.id_ahs_lokal_details)
      //     this.close()
      //     this.save()
      //   }catch(err){
      //     console.log(err)
      //   }
      // },
      async deleteItem(id){
        try{
          await rabdetails.deleteDetail(id).data
          this.getallAHS()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          let ahs = this.details.find(obj=>obj.id_ahs_lokal_details == id)
          await detailController.deleteItem(id).data
          this.getItem(ahs.id_ahs_lokal)
          this.getallAHS()
          this.close()
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
      reset () {
        this.$refs.form.reset()
      },
      close () {
        this.dialog = false
        this.dialog3 = false
        this.dialog5 = false
        this.dialog6 = false
        this.dialog7 = false
        this.dialog8 = false
        this.details=[]
        this.getallAHS()
        this.getall()
        this.details=[]
        this.tambah = false
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