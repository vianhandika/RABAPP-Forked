<template>
  <div class="ahs">
    <v-toolbar dark color="cyan">
      <v-toolbar-title>AHS Lokal</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>

      <v-select
        flat
        solo-inverted
        hide-details
        label="Choose Project"
        class="hidden-sm-and-down"
        color="blue"
        v-model="select"
        :items="project"
        item-text="name"
        item-value="id_project"
        dense
        prepend-inner-icon="expand_more"
      >
      </v-select>
      <v-spacer></v-spacer>

      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        label="Search"
        class="hidden-sm-and-down"
        color="blue"
        v-model="search"
        dense
      >
      </v-text-field>
    
      <div class="flex-grow-1"></div>
      <v-dialog v-model="dialog" max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn color="blue" dark class="mb-2" @click="reset" v-on="on">New</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">New AHS Adjust</span>
          </v-card-title>
          
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="AHS.kode"
                    label="ID"
                ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-select
                    v-model="AHS.id_project"
                    label="Project"
                    :items="project"
                    item-text="name"
                    item-value="id_project"
                    :return-object="false"
                    @change="filterAHS(AHS.id_project)"
                ></v-select>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-select
                  v-model="AHS.id_ahs"
                  label="AHS"
                  :items="filter"
                  item-text="name"
                  item-value="id_ahs"
                  :return-object="false"
                  @change="getDetails(AHS.id_ahs)"
                ></v-select>
              </v-layout>

              <v-flex class="text-md-center" sm12 mt-2 v-if="tambah">
                <div>
                  <v-data-table
                    :headers="headersAHS"
                    sortBy="status"
                    update: sort-desc
                    class="elevation-1"
                    :items="detailsDefault"
                  >
                  <template v-slot:item.sub_adjustment="props">
                    <v-edit-dialog
                      :return-value.sync="props.item.sub_adjustment"
                      @save="save(props)"
                      @cancel="cancel"
                      lazy
                      persistent
                      dark
                    > {{ props.item.sub_adjustment }}
                      <template v-slot:input>
                        <v-text-field
                          v-model="props.item.sub_adjustment"
                          label="Edit"
                          single-line
                          counter
                        ></v-text-field>
                      </template>
                    </v-edit-dialog>
                  </template>
                  </v-data-table>

                  <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
                    {{ snackText }}
                    <v-btn text @click="snack = false">Close</v-btn>
                  </v-snackbar>
                  
                </div>
              </v-flex>

                <v-layout >
                  <v-flex>
                    <v-text-field 
                      v-model="AHS.adjustment" 
                      label="Adjustment*"
                      required
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>
                
                <v-layout >
                  <v-flex>
                    <v-text-field 
                      v-model="AHS.total" 
                      label="Total"
                      required
                    >
                    </v-text-field>
                  </v-flex>
                </v-layout>
            </v-card-text>
          </v-form>

          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
            <v-btn class="ma-2" rounded color="orange" :disabled="!valid" dark @click="addItem()">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>

    <v-expansion-panels accordion>
      <v-expansion-panel v-for="data in filtered" :key="data.id_ahs_adjust"  :search="search">
          <v-expansion-panel-header>
            <v-layout row wrap :class="`pa-3 ahs`">
              <v-flex xs1>
                <div class="caption grey--text">ID</div>
                <div>{{ data.kode }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Project</div>
                <div>{{ data.project }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Task Group</div>
                <div>{{ data.name_sub }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Task</div>
                <div>{{ data.name }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Adjustment</div>
                <div>{{ data.adjustment }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Total of Labor</div>
                <div>Rp. {{ data.total_labor }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Total of Materials</div>
                <div>Rp. {{ data.total_material }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Total</div>
                <div>Rp. {{ data.total }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Actions</div>
                <v-icon color="green" @click="itemEdit(data);dialog5=true">edit</v-icon>
                <v-icon color="red" @click="dialog2=true">delete</v-icon>
              </v-flex>
            </v-layout>
            
            <template v-slot:actions>
              <v-icon color="cyan" @click="getItem(data.id_ahs_adjust)">expand_more</v-icon>
            </template>

            <!-- template dialog delete ahs -->
            <template>
              <v-dialog v-model="dialog2" max-width="290px">
                <v-card>
                  <v-card-title class="headline">Confirmation</v-card-title>
                    <v-card-text>Are you sure want to delete this AHS Adjustment?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(data.id_ahs_adjust)">Yes</v-btn>
                    <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </template>
            <!-- template dialog edit ahs -->
            <template>
            </template>

            <v-dialog v-model="dialog5" max-width="600px">
              <v-card>
                <v-card-title>
                  <span class="headline">Edit AHS Adjust</span>
                </v-card-title>

                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-card-text>
                    <v-layout>
                      <v-flex>
                        <v-text-field
                          v-model="AHS.kode"
                          label="ID"
                      ></v-text-field>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex>
                        <v-select
                          v-model="AHS.id_project"
                          label="Project"
                          :items="project"
                          item-text="name"
                          item-value="id_project"
                          :return-object="false"
                          @change="filterAHS(AHS.id_project)"
                      ></v-select>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-select
                        v-model="AHS.id_job"
                        label="AHS"
                        :items="job"
                        item-text="name"
                        item-value="id_job"
                        :return-object="false"
                        disabled
                      ></v-select>
                    </v-layout>

                    <v-flex class="text-md-center" sm12 mt-2 v-if="tambah">
                      <div>
                        <v-data-table
                          :headers="headersAHS"
                          sortBy="status"
                          update: sort-desc
                          class="elevation-1"
                          :items="details"
                        >
                        <template v-slot:item.sub_adjustment="props">
                          <v-edit-dialog
                            :return-value.sync="props.item.sub_adjustment"
                            @save="save(props)"
                            @cancel="cancel"
                            lazy
                            persistent
                            dark
                          > {{ props.item.sub_adjustment }}
                            <template v-slot:input>
                              <v-text-field
                                v-model="props.item.sub_adjustment"
                                label="Edit"
                                single-line
                                counter
                              ></v-text-field>
                            </template>
                          </v-edit-dialog>
                        </template>
                        </v-data-table>

                        <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
                          {{ snackText }}
                          <v-btn text @click="snack = false">Close</v-btn>
                        </v-snackbar>
                        
                      </div>
                    </v-flex>

                      <v-layout >
                        <v-flex>
                          <v-text-field 
                            v-model="AHS.adjustment" 
                            label="Adjustment*"
                            required
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>
                      
                      <v-layout >
                        <v-flex>
                          <v-text-field 
                            v-model="AHS.total" 
                            label="Total"
                            required
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>
                  </v-card-text>
                </v-form>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                  <v-btn class="ma-2" rounded color="orange" :disabled="!valid" dark @click="updateItem(AHS.id_ahs)">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text">
            <template>
              <div>
                <v-data-table
                  :headers="headers"
                  sortBy="status"
                  update: sort-desc
                  class="elevation-1"
                  :items="details"
                >
                <template v-slot:item.sub_adjustment="props">
                  <v-edit-dialog
                    :return-value.sync="props.item.sub_adjustment"
                    @save="editSub(props)"
                    @cancel="cancel"
                    lazy
                    persistent
                    dark
                    large
                  > {{ props.item.sub_adjustment }}
                    <template v-slot:input>
                      <v-text-field
                        v-model="props.item.sub_adjustment"
                        label="Edit"
                        single-line
                        counter
                      ></v-text-field>
                    </template>
                  </v-edit-dialog>
                </template>

                <template v-slot:item.action="{ item }">
                  <v-dialog v-model="dialog6" max-width="290px">
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
                            <v-btn color="green darken-1" text @click="dialog6 = false; deleteDetail(item.id_ahs_details_adjust)">Yes</v-btn>
                            <v-btn color="red darken-1" text @click="dialog6 = false">No</v-btn>
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
  </div>
</template>

<script>
import Controller from './../service/Job'
import materialController from './../service/Material'
import ahsController from './../service/AHSAdjust'
import ahs from './../service/AHS'
import detailController from './../service/AHSAdjustDetails'
import task from './../service/TaskSub'
import project from './../service/Project'

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
        id_ahs_adjust:'',
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
        id_ahs_details_adjust:'',
        id_ahs_adjust:'',
        id_material: '',
        price_ahs: '',
        sub_adjustment: 0,
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
          text: 'Price AHS', align: 'left', sortable: false, value: 'price_ahs',
        },
        { 
          text: 'Sub Adjustment', align: 'left', sortable: false, value: 'sub_adjustment',
        },
        { 
          text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total',
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
                    data.kode.match(this.search) ||
                    data.volume.toLocaleString().match(this.search))
                }
              }
            }else{
              return (data.name.match(this.search) ||
                data.kode.match(this.search) ||
                data.volume.toLocaleString().match(this.search))
            }
        });
      }
    },
    methods: {
      editSub (props) {
        this.updateDetail(props)
        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Data saved'
      },
      save (props) {
        // this.updateDetail(props)
        console.log('cek details before push')
        console.log(this.detailsDefault)
        console.log('cek props')
        console.log(props.item)

        let temp = 0
        let count = 0
        let sub_total = 0
        this.AHS.total = 0

        let details = []
        this.details=[]

        details = this.detailsDefault
        console.log(details)

        for(let detail of details)
        {
          if(detail.status == "labor")
            sub_total = detail.sub_total * detail.sub_adjustment
          else
            sub_total = detail.sub_total * detail.sub_adjustment
          
          temp = parseInt(temp) + parseInt(detail.sub_adjustment)
          count = parseInt(count+1,10)

          this.AHS.total += sub_total

          let each_detail = {
            id_material   : detail.id_material,
            price_ahs     : detail.sub_total,
            sub_adjustment: detail.sub_adjustment,
            sub_total     : sub_total,
          }
          this.details.push(each_detail)
        }
       
        console.log('Total AHS before adjustment')
        console.log(this.AHS.total)
        this.AHS.adjustment = temp/count

        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Data saved'

        console.log('details asli')
        console.log(this.details)
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      itemEdit(item){
        this.AHS = item
        this.details = item.ahs_details_adjust.data
        // this.getDetails(item.id_job)
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
      getSelectedIndex(){
        this.index = this.material.map(function(e) { return e.id_material; }).indexOf(this.Material.id_material);
        console.log(this.index)
      },
      getSelectedIndexD(){
        this.index = this.material.map(function(e) { return e.id_material; }).indexOf(this.detail.id_material);
        console.log(this.index)
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
      async addItem(){
        let total_labor=0
        let total_material=0
        for(let detail of this.details)
        {
          let material = this.material.find(obj=>obj.id_material == detail.id_material)
          console.log('ini material')
          console.log(material)
          if(material.status == "labor")
            total_labor += detail.sub_total
          if(material.status == "material")
            total_material += detail.sub_total 
        }
        try{
          const payload = {
            kode            : this.AHS.kode,
            id_project      : this.AHS.id_project,
            id_job          : this.AHS.id_job,
            id_sub          : this.AHS.id_sub,
            // volume          : this.AHS.volume,
            adjustment      : this.AHS.adjustment,
            total_labor     : total_labor,
            total_material  : total_material,
            total           : this.AHS.total,
            detail          : this.details
          }
          await ahsController.add(payload)
          this.close()
        }catch(err){
          console.log(err)
        }
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
      async updateDetail(props){
        try{
          console.log(props.item)
            const payload = {
              sub_adjustment   : props.item.sub_adjustment,
            } 
            await detailController.updateDetail(payload,props.item.id_ahs_details_adjust)
            this.getItem(props.item.id_ahs_adjust)
            this.close()
            console.log('cek')
        }catch(err){
          console.log(err);
        }
      }, 
      async deleteItem(id){
        try{
          await ahsController.delete(id).data
          this.getallAHS()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          let ahs = this.details.find(obj=>obj.id_ahs_details_adjust == id)
          await detailController.deleteItem(id).data
          this.getItem(ahs.id_ahs_adjust)
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
</style>