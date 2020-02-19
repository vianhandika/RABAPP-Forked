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
          :items="task"
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
            <v-btn color="green darken-1" elevation="8" rounded class="mb-2" @click="dialogAdd=true;dialogEdit=false" v-on="on">New</v-btn>
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
                    @change="filterTask(AHS.id_sub)"
                  ></v-select>
                </v-layout>

                <v-layout v-if="dialogAdd">
                  <v-select
                    v-model="AHS.id_job"
                    label="Task"
                    :items="temp"
                    item-text="name"
                    item-value="id_job"
                    :return-object="false"
                    @change="filterTask(AHS.id_sub)"
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
                    @change="filterTask(AHS.id_sub)"
                    readonly
                  ></v-select>
                </v-layout>

                <v-layout v-if="dialogEdit">
                  <v-select
                    v-model="AHS.id_job"
                    label="Task"
                    :items="temp"
                    item-text="name"
                    item-value="id_job"
                    :return-object="false"
                    @change="filterTask(AHS.id_sub)"
                    readonly
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
                
                <v-layout v-if="edit">
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
                      dark @click="deleteList(detail)"
                    >
                    <v-icon>remove_circle</v-icon>
                    </v-btn>
                    <v-btn 
                      icon
                      color="blue accent-2"
                      dark @click="editList(detail); detailAHS=true"
                    >
                      <v-icon>add_circle</v-icon>
                    </v-btn>
                    <!-- buat ditampilkan setelah di clik addList -->
                    <v-flex xs13 sm5 md5>
                      <v-select
                        label="Materials/Labor" 
                        class="pa-1"
                        v-model="detail.id_material"
                        item-text="name"
                        item-value="id_material"
                        :items="material"
                        required 
                      ></v-select>
                    </v-flex>

                    <v-flex xs13 sm5 md5>
                      <v-text-field
                        label="Coefficient" 
                        class="pa-1"
                        v-model="detail.coefficient"
                        required
                      ></v-text-field>
                    </v-flex>

                    </v-card-title>
                    </v-card>
                  </v-flex>
                </v-layout>

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
                      dark @click="deleteList(detail)"
                    >
                    <v-icon>remove_circle</v-icon>
                    </v-btn>
                    <v-btn
                      icon
                      color="green"
                      dark @click="detailAHS=false;edit=true;editHandler(index)"
                    >
                      <v-icon>edit</v-icon>
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
                      <v-text-field
                        label="Coefficient*" 
                        class="pa-1"
                        v-model="detail.coefficient"
                        readonly
                      ></v-text-field>
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
                          color="blue accent-2"
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
                          required 
                        ></v-select>
                      </v-flex>

                      <v-flex xs13 sm5 md5>
                        <v-text-field
                        label="Coefficient" 
                        class="pa-1"
                        v-model="ahs_details.coefficient"
                        required
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

      <v-expansion-panels accordion class="elevation-8">
        <v-expansion-panel v-for="data in filtered" :key="data.id_ahs" :search="search" @click="getItem(data.id_ahs)" active-class="border-ahs">
            <v-expansion-panel-header>
              <v-layout row wrap>
                <v-flex xs1>
                  <div class="caption grey--text">ID AHS</div>
                  <div>{{ data.kode }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Task Group</div>
                  <div style>{{ data.name_sub }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Task</div>
                  <div>{{ data.name }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total of Labor</div>
                  <div>Rp. {{ Number(data.total_labor).toLocaleString() }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total of Materials</div>
                  <div>Rp. {{ Number(data.total_material).toLocaleString() }}</div>
                </v-flex>
                <v-flex xs2>
                  <div class="caption grey--text">Total</div>
                  <div>Rp. {{ Number(data.total).toLocaleString() }}</div>
                </v-flex>
                <v-flex xs1>
                  <div class="caption grey--text">Actions</div>
                  <v-icon color="green" @click="itemHandler(data);dialogEdit=true;dialog=true;dialogAdd=false;detailAHS=true">edit</v-icon>
                  <v-icon color="red" @click="itemHandler(data);dialogDelete=true">delete</v-icon>
                </v-flex>
              </v-layout>
              
              <template v-slot:actions>
                <v-icon color="cyan" @click="getItem(data.id_ahs)">expand_more</v-icon>
              </template>
              <!-- template dialog delete ahs -->
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
              
            </v-expansion-panel-header>
            <v-expansion-panel-content class="grey--text">
              <template>
                <div>
                  <v-data-table
                    :headers="headers"
                    sortBy="status"
                    update: sort-desc
                    class="elevation-10"
                    :items="detailsData"
                  >
                  <template v-slot:item.sub_total="{ item }">
                    {{ 'Rp. '}}{{ Number(item.sub_total).toLocaleString() }}
                  </template>

                  <template v-slot:item.coefficient="props">
                    <v-edit-dialog
                      :return-value.sync="props.item.coefficient"
                      @save="save(props)"
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
                        >
                          delete
                        </v-icon>
                      </template>
                          <v-card>
                            <v-card-title class="headline">Confirmation</v-card-title>
                              <v-card-text>Are you sure want to delete this detail?</v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="green darken-1" text @click="dialogDetail = false; deleteDetail(item.id_ahs_details)">Yes</v-btn>
                              <v-btn color="red darken-1" text @click="dialogDetail = false">No</v-btn>
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
            </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <!-- <div>
        <v-pagination
          v-model="page"
          class="my-4"
          :length="5"
          prev-icon="arrow_left"
          next-icon="arrow_right"
        >
        </v-pagination>
      </div> -->
    </v-container>
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
      page: 1,

      valid: true,

      snack: false,
      snackColor: '',
      snackText: '',
      
      dialog: false,
      dialogAdd: false,
      dialogDelete: false,
      dialogEdit: false,
      dialogDetail: false,
      tambah: false,
      edit: false,
      detailAHS: false,

      search:'',
      select: '',
      
      ahs: [],
      job: [],
      material:[],
      details:[],
      detailsData:[],
      task:[],
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
        id_material: '',
        coefficient: 0,
        sub_total : 0,
      },
      Material:{
        id_material:'',
      },
      headers: [
        { 
          text: 'ID Materials/Labor', align: 'left', sortable: false, value: 'kode',
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
          text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient',
        },
        { 
          text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total',
        },
        {
          text: 'Actions', align: 'left', sortable: false, value: 'action'
        },
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getallItem()
      this.getallItemMaterial()
      this.getTask()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
            if(this.select != '')
            {
              if(this.select == data.id_sub)
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
      save (props) {
        this.updateDetail(props)
        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Data saved'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      filterTask(id)
      {
        this.getallItem()
        this.filter = this.job
        
        for(let ahs of this.ahs)
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
        console.log('THis Filter Material')
        console.log(this.filterMaterial)
      },
      itemHandler(item){
        this.AHS = item
        // this.details = item.ahs_details.data
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
        console.log(this.details)
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
        this.Material.id_material=''
        this.ahs_details.coefficient=0

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
      editHandler(data)
      {
        this.index = data
        // this.filterMaterials()
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
        this.edit = false
      },
      deleteList(data){
        let material = this.material.find(obj=>obj.id_material == data.id_material)
        this.delOfTotal(material,data)
        this.details.splice(this.details.indexOf(data),1)
        this.details=[...this.details]

        console.log('This Details')
        console.log(this.details)
      },
      async getTask()
      {
        try{
          this.task = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      // async getallDetails(){
      //   try{
      //     this.detailsData = (await detailController.getallItem()).data
      //   }catch(err){
      //     console.log(err)
      //   }
      // },
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
        }catch(err){
          console.log(err)
        }
      },
      async updateItem(id){
        try{
            const payload = {
              kode            : this.AHS.kode,
              id_sub          : this.AHS.id_sub,
              total           : this.AHS.total,
              total_labor     : this.AHS.total_labor,
              total_material  : this.AHS.total_material,
              detail          : this.details
            } 
            await ahsController.updateItem(payload,id)
            this.getItem(id)
            this.close()
        }catch(err){
          console.log(err);
        }
      },
      async updateDetail(props){
        try{
            const payload = {
              coefficient   : props.item.coefficient,
            } 
            await detailController.updateDetail(payload,props.item.id_ahs_details)
            this.getItem(props.item.id_ahs)
            this.close()
        }catch(err){
          console.log(err);
        }
      }, 
      async deleteItem(id){
        try{
          await ahsController.deleteItem(id).data
          this.getallAHS()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          let ahs = this.detailsData.find(obj=>obj.id_ahs_details == id)
          await detailController.deleteItem(id).data
          this.getItem(ahs.id_ahs)
          this.getallAHS()
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
        // this.AHS = ''
        this.$refs.form.reset()
        this.details=[]
        //this.AHS.total = 0
        // this.AHS.total_labor = 0
        // this.AHS.total_material = 0
      },
      close () {
        this.dialog = false
        this.dialogAdd = false
        this.dialogEdit = false
        this.dialogDetail = false
        this.details=[]
        this.getallAHS()
        this.AHS = Object.assign({},this.AHSDefault)
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
  border: 4px solid 
}
.border-ahs{
  border-left: 4px solid #0277BD
}
.border-material{
  border-left: 2px solid #448AFF
}
</style>