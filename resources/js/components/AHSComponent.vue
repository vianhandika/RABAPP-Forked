<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar dark color="light-blue accent-3">
        <v-toolbar-title>AHS</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <v-select
          hide-details
          label="Choose Task Group"
          class="hidden-sm-and-down"
          v-model="select"
          :items="taskTemp"
          item-text="name"
          item-value="id_sub"
          prepend-inner-icon="expand_more"
          single-line
          style="width:150px"
        >
        </v-select>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
          style="width:150px"
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" max-width="550px">
          <template v-slot:activator="{ on }">
            <v-btn color="green darken-1" elevation="8" rounded class="mb-2" @click="dialogAdd=true;dialogEdit=false;reset()" v-on="on">New</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline" v-if="dialogAdd">New AHS</span>
              <span class="headline" v-if="dialogEdit">Edit AHS</span>
            </v-card-title>
            
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
                  <v-select
                    v-model="AHS.id_sub"
                    label="Task Group"
                    :items="task"
                    item-text="name"
                    item-value="id_sub"
                    :return-object="false"
                    :rules="groupRules"
                  ></v-select>
                </v-layout>

                <v-layout v-if="dialogAdd" @click="filterTask(AHS.id_sub)">
                  <v-select
                    v-model="AHS.id_job"
                    label="Task"
                    :items="temp"
                    item-text="name"
                    item-value="id_job"
                    :return-object="false"
                    :rules="taskRules"
                  ></v-select>
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
                  <v-select
                    v-model="AHS.id_sub"
                    label="Task Group"
                    :items="task"
                    item-text="name"
                    item-value="id_sub"
                    :return-object="false" 
                  ></v-select>
                </v-layout>

                <v-layout v-if="dialogEdit" @click="filterTask(AHS.id_sub)">
                  <v-select
                    v-model="AHS.id_job"
                    label="Task"
                    :items="temp"
                    item-text="name"
                    item-value="id_job"
                    :return-object="false"
                  ></v-select>
                </v-layout>

                <v-btn
                  color="blue accent-4"
                  @click="tambah=true;filterMaterials()"
                  dark
                  elevation="8"
                >
                Add 
                </v-btn>
                
                <v-layout v-if="detailAHS">
                  <v-flex class="text-md-center" sm12 mt-2>
                    <v-card
                      v-for="(detail,index) in details"
                      :key="index"
                      elevation="5"
                      style="margin-top:4px"
                    > 
                    <v-card-title>
                    <v-btn 
                      icon
                      color="red"
                      dark @click="itemDetail(detail);dialogdeletedetail=true"
                    >
                    <v-icon>remove_circle</v-icon>
                    </v-btn>

                    <v-flex xs13 sm5 md5>
                      <v-select
                        label="Materials/Labor" 
                        class="pa-1"
                        v-model="detail.id_material"
                        item-text="name"
                        item-value="id_material"
                        :items="material"
                        readonly 
                      ></v-select>
                    </v-flex>

                    <v-flex xs13 sm5 md5>
                      <template>
                        <v-edit-dialog
                          @save="editList(detail)"
                          @cancel="cancel" 
                          lazy
                          large
                        >
                        <v-text-field
                          label="Coefficient*" 
                          class="pa-1"
                          v-model="detail.coefficient"
                          readonly
                        ></v-text-field>

                          <template v-slot:input>
                            <v-text-field
                              v-model="detail.coefficient"
                              label="Edit"
                              single-line
                              counter
                            ></v-text-field>
                          </template>
                        </v-edit-dialog>
                      </template>
                    </v-flex>
                    </v-card-title>
                    </v-card>
                  </v-flex>
                </v-layout>

                <v-layout v-if="tambah">
                  <v-flex class="text-md-center" sm12 mt-2>
                    <v-card elevation="8"> 
                      <v-card-title>
                      <v-btn 
                          icon
                          color="red"
                          dark @click="tambah=false"
                          >
                          <v-icon>remove_circle</v-icon>
                      </v-btn>
                      <v-btn 
                          icon
                          color="green"
                          dark @click="addList(); detailAHS=true"
                          >
                          <v-icon>add_circle</v-icon>
                      </v-btn>
                      <!-- buat pertama kali input data untuk addList -->
                      <v-flex xs13 sm5 md5>
                        <v-select
                          label="Materials/Labor" 
                          class="pa-1"
                          v-model="Material.id_material"
                          item-text="name"
                          item-value="id_material"
                          :return-object="false"
                          :items="filterMaterial"
                          :rules="materialsRules"                          
                        ></v-select>
                      </v-flex>

                      <v-flex xs13 sm5 md5>
                        <v-text-field
                        label="Coefficient" 
                        class="pa-1"
                        v-model="ahs_details.coefficient"
                        :rules="coefficientRules"
                        type="number"
                        ></v-text-field>
                      </v-flex>
                      </v-card-title>
                    </v-card>
                  </v-flex>
                </v-layout>
                  
                <v-layout >
                  <v-flex>
                    <v-text-field 
                      v-model="AHS.total" 
                      label="Total"
                      readonly
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>
              </v-card-text>
            </v-form>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" v-if="dialogAdd" rounded color="orange" :disabled="!valid" dark @click="addItem()">Save</v-btn>
              <v-btn class="ma-2" v-if="dialogEdit" rounded color="orange" :disabled="!valid" dark @click="updateItem(AHS.id_ahs)">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>

      <v-card elevation="10">
        <v-list-group v-for="data in filtered" :key="data.id_ahs" >
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <v-flex xs3>
                  <div class="caption grey--text">ID AHS</div>
                  <div>{{ data.kode }}</div>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">Task Group</div>
                  <div style>{{ data.name_sub }}</div>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">Task</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">Total of Labor</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:90px">{{ Number(data.total_labor).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">Total of Materials</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:90px">{{ Number(data.total_material).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs3>
                  <div class="caption grey--text">HSP</div>
                  <v-layout>
                    <div style="text-align:left;width:25px">Rp.</div>
                    <div style="text-align:right;width:90px">{{ Number(data.total).toLocaleString('id-ID') }}</div>
                  </v-layout>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Actions</div>
                  <v-icon color="green" @click="itemHandler(data);dialogEdit=true;dialog=true;dialogAdd=false;detailAHS=true;detailTable=false">edit</v-icon>
                  <v-icon color="red" @click="itemHandler(data);dialogDelete=true;detailTable=false">delete</v-icon>
                  <v-icon color="blue" @click="itemHandler(data);dialogCopy=true;detailTable=false">file_copy</v-icon>
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
                :items="data.ahs_details.data"
                v-if="detailTable"
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

              <template v-slot:item.coefficient="props">
                <v-edit-dialog
                  :return-value.sync="props.item.coefficient"
                  @save="updateDetail(props)"
                  @cancel="cancel"
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

              <template v-slot:item.action="{ item }">
                <v-dialog v-model="dialogDetail" max-width="290px">
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
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
                          <v-btn color="green darken-1" text @click="dialogDetail = false; deleteDetail(ahs_details.id_ahs_details)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="dialogDetail = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                </v-dialog>
              </template>
              </v-data-table>
            </div>
          </template>
        </v-list-group>
      </v-card>
      
      <template>
        <v-dialog v-model="dialogDelete" max-width="290px">
          <v-card>
            <v-card-title class="headline">Confirmation</v-card-title>
              <v-card-text>Are you sure want to delete this AHS?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(AHS.id_ahs)">Yes</v-btn>
              <v-btn color="red darken-1" text @click="dialogDelete = false">No</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>

      <template>
        <v-dialog v-model="dialogCopy" max-width="290px">
          <v-card>
            <v-card-title class="headline">Confirmation</v-card-title>
              <v-card-text>Are you sure want to copy this AHS?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialogCopy = false; copyItem()">Yes</v-btn>
              <v-btn color="red darken-1" text @click="dialogCopy = false">No</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>

      <template>
        <v-dialog v-model="dialogdeletedetail" max-width="290px">
          <v-card>
            <v-card-title class="headline">Confirmation</v-card-title>
              <v-card-text>Are you sure want to delete this detail?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="dialogdeletedetail = false; deleteList(ahs_details)">Yes</v-btn>
              <v-btn color="red darken-1" text @click="dialogdeletedetail = false">No</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>

      <div>
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
      </div>
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
import detailController from './../service/Details'
import task from './../service/TaskSub'
  export default {
    data: () => ({
      current_page: 1,
      total_pages: 0,
      valid: true,

      snack: false,
      y: 'top',
      snackColor: '',
      snackText: '',
      
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

      search:'',
      select: '',
      id_ahs: '',
      
      ahs: [],
      ahsAll:[],
      job: [],
      material:[],
      details:[],
      detailsData:[],
      detailsTemp:[],
      task : [],
      taskTemp:[],
      filter:[],
      temp:[],
      filterMaterial:[],
      pagination: [],

      AHS:{
        kode:'',
        id_ahs:'',
        id_job: '',
        id_sub:'', 
        total_labor: 0,
        total_material: 0,
        total: 0
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
        {text: 'ID Materials/Labor', align: 'left', sortable: false, value: 'kode',width:'15%'},
        {text: 'Type', align: 'left', sortable: true, value: 'status',width:'15%'},
        {text: 'Item', align: 'left', sortable: false, value: 'name',width:'15%'},
        {text: 'Price', align: 'left', sortable: false, value: 'price', width:'10%'},
        {text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient', width:'15%', align: 'center'},
        {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total', width:'10%'},
        {text: 'Actions', align: 'left', sortable: false, value: 'action', width:'15%'},
      ],
      //validation
      groupRules: [
        v => !!v || 'Task Group is required'
      ],
      taskRules: [
        v => !!v || 'Task is required'
      ],
      materialsRules: [
        v => !!v || 'Materials is required'
      ],
      coefficientRules: [
        v => !!v || 'Coefficient is required',
        v => (v && !v.numeric) || 'Coefficient must be numeric'
      ]
    }),
    mounted(){
      this.getallAHS()
      this.getallItem()
      this.getallItemMaterial()
      this.getTask()
      this.getTaskTemp()
      this.getallDetails()
      this.getPagination()
      this.getKode()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
            if(this.select != '')
            {
              if(this.select == '-1')
              {
                if(this.search == '')
                  return data
                else{
                  return (data.name.match(this.search) ||
                    data.kode.match(this.search))
                }
              }
              else if(this.select == data.id_sub)
              {
                if(this.search == '')
                  return data
                else{
                  return (data.name.match(this.search) ||
                    data.kode.match(this.search))
                }
              }
            }else{
              return (data.name.match(this.search) ||
                data.kode.match(this.search))
            }
        });
      },
    },
    methods: {
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
      copy(){
        this.snack = true
        this.snackColor = 'green darken-1'
        this.snackText = 'Data Copy Successfully'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      async filterTask(id)
      {
        this.getallItem()
        this.filter = this.job
        for(let ahs of this.ahsAll)
        {
          if(ahs.id_sub == id)
          {
            for(let job of this.job)
            {
              if(ahs.id_job == job.id_job)
                this.filter.splice(this.filter.indexOf(job),1)
            }
          }
        }
        this.filter=[...this.filter]
        this.temp = this.filter
        console.log('hai')
        console.log(this.temp)
      },
      filterMaterials()
      {
        this.filterMaterial = this.material
        let m = this.material
        for(let detail of this.details)
        {
          this.filterMaterial = m.filter(obj=>obj.id_material != detail.id_material)
          m = this.filterMaterial
        }
      },
      itemHandler(item){
        this.details=[]
        this.tambah=false

        this.AHS = item
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
        this.temp = this.job  
      },
      itemDetail(item){
        this.ahs_details = item
      },
      async addList()
      {
        let data = this.material.find(obj=>obj.id_material == this.Material.id_material)
        let detail = {
          id_ahs_details : null,
          id_material : this.Material.id_material,
          coefficient : this.ahs_details.coefficient,
          sub_total : data.price * this.ahs_details.coefficient
        }
        this.details.push(detail)
        this.sumOfTotal(data,detail)
       
        this.tambah = false
        this.Material.id_material= ''
        this.ahs_details.coefficient=''
        console.log('Detail AHS')
        console.log(this.details)
      },
      sumOfTotal(material,detail)
      {
        if(material.status == "material")
          this.AHS.total_material += detail.sub_total 
        if(material.status == "labor")
          this.AHS.total_labor += detail.sub_total
        this.AHS.total= this.AHS.total_labor + this.AHS.total_material
      },
      delOfTotal(material,detail)
      {
        if(material.status == "material")
          this.AHS.total_material -= detail.sub_total
        if(material.status == "labor")
          this.AHS.total_labor -= detail.sub_total
        this.AHS.total = parseInt(this.AHS.total - detail.sub_total,10)
      },
      editList(data)
      {
        let material = this.material.find(obj=>obj.id_material == data.id_material)
        this.delOfTotal(material,data)

        let newDetail = {
          id_ahs_details: data.id_ahs_details,
          id_material : data.id_material,
          coefficient : data.coefficient,
          sub_total : data.coefficient * material.price
        }
        this.details.splice(this.index,1,newDetail)

        let newMaterial = this.material.find(obj=>obj.id_material == newDetail.id_material)
        this.sumOfTotal(newMaterial,newDetail)
        this.update()
      },
      deleteList(data){
        let material = this.material.find(obj=>obj.id_material == data.id_material)
        this.delOfTotal(material,data)
        this.details.splice(this.details.indexOf(data),1)
        this.details=[...this.details]

        console.log('This Details')
        console.log(this.details)
        // this.delete()
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getTaskTemp()
      {
        try{
          this.taskTemp = (await task.get()).data
          let each = {
            id_sub: -1,
            name: 'All'
          }
          this.taskTemp.push(each)
          console.log("task")
          console.log(this.taskTemp)
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
      async getKode()
      {
        try{
          this.ahsAll = (await ahsController.getall()).data
          this.AHS.kode = 'AHS-'+(this.ahsAll.length+1)
        }catch(err){
          console.log(err)
        }
      },
      async getPagination()
      {
        try{
            await ahsController.get(this.current_page).then(response =>{
            this.current_page = response.meta.pagination.current_page
            this.ahs = response.data
            this.total_pages = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            kode            : this.AHS.kode,
            id_job          : this.AHS.id_job,
            id_sub          : this.AHS.id_sub,
            total_labor     : this.AHS.total_labor,
            total_material  : this.AHS.total_material,
            total           : this.AHS.total,
            detail          : this.details
          }
          await ahsController.addItem(payload)
          this.close()
          this.save()
        }catch(err){
          console.log(err)
        }
      },
      async updateItem(id){
        try{
            const payload = {
              kode            : this.AHS.kode,
              id_sub          : this.AHS.id_sub,
              id_job          : this.AHS.id_job,
              total           : this.AHS.total,
              total_labor     : this.AHS.total_labor,
              total_material  : this.AHS.total_material,
              detail          : this.details
            } 
            await ahsController.updateItem(payload,id)
            this.close()
            // this.getPagination()
            this.update()
        }catch(err){
          console.log(err);
        }
      },
      async copyItem()
      {
        const payload = {
          id_ahs: this.AHS.id_ahs
        }
        try{
          await ahsController.copy(payload)
          this.getallAHS()
          this.copy()
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
            this.getItem(props.item.id_ahs)
            // this.getPagination()
            this.close()
            this.update()
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
          console.log(this.detailsData)
          let ahs = this.detailsData.find(obj=>obj.id_ahs_details == id)
          await detailController.deleteItem(id).data
          this.getItem(ahs.id_ahs)
          this.getallAHS()
          this.delete()
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
        this.$refs.form.reset()
        this.$refs.form.resetValidation()
        this.details=[]
        this.tambah = false
      },
      close () {
        this.dialog = false
        this.details=[]
        this.getPagination()
        this.AHS = Object.assign({},this.AHSDefault)
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