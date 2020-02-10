<template>
  <div class="ahs">
    <v-toolbar dark color="cyan">
      <v-toolbar-title>AHS</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>

      <v-select
        flat
        solo-inverted
        hide-details
        label="Choose Task Group"
        class="hidden-sm-and-down"
        color="blue"
        v-model="select"
        :items="task"
        item-text="name"
        item-value="id_sub"
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
            <span class="headline">New AHS</span>
          </v-card-title>
          
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text>
              <v-layout>
                <v-flex>
                  <v-text-field 
                    v-model="AHS.kode" 
                    label="ID AHS"
                  >
                  </v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
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

              <v-layout>
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

              <VBtn
                depressed
                color="primary"
                @click="tambah=true"
              >
              Add 
              </VBtn>

              <v-flex class="text-md-center" sm12 mt-2>
                  <VCard
                  v-for="(detail,index) in details"
                  :key="index"
                  > 
                    <v-card-title>
                    <v-btn 
                        icon
                        color="red"
                        dark @click="deleteList(detail)"
                        >
                        <v-icon>remove_circle</v-icon>
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
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>

                      <v-flex xs13 sm5 md5>
                          <v-text-field
                          label="Coefficient*" 
                          class="pa-1"
                          v-model="detail.coefficient"
                          required
                          ></v-text-field>
                      </v-flex>
                    </v-card-title>
                  </Vcard>
                </v-flex>
                
                <v-layout v-if="tambah">
                    <VCard> 
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
                        dark @click="addList()"
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
                          :items="material"
                          required 
                          @change="getSelectedIndex"
                        ></v-select>
                      </v-flex>

                      <v-flex xs13 sm5 md5>
                        <v-text-field
                        label="Coefficient*" 
                        class="pa-1"
                        v-model="ahs_details.coefficient"
                        required
                        ></v-text-field>
                      </v-flex>
                    </v-card-title>
                  </Vcard>
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
      <v-expansion-panel v-for="data in filtered" :key="data.id_ahs" :search="search" @click="getItem(data.id_ahs)">
          <v-expansion-panel-header>
            <v-layout row wrap :class="`pa-3 ahs`">
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
                <div>Rp. {{ data.total_labor }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Total of Materials</div>
                <div>Rp. {{ data.total_material }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Total</div>
                <div>Rp. {{ data.total }}</div>
              </v-flex>
              <v-flex xs1>
                <div class="caption grey--text">Actions</div>
                <v-icon color="green" @click="itemEdit(data);dialog5=true">edit</v-icon>
                <v-icon color="red" @click="dialogDelete=true">delete</v-icon>
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
                    <v-btn color="green darken-1" text @click="dialogDelete = false; deleteItem(data.id_ahs)">Yes</v-btn>
                    <v-btn color="red darken-1" text @click="dialogDelete = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </template>
            <!-- template dialog edit ahs -->
            <template>
              <v-dialog v-model="dialog5" max-width="600px">
                <v-card>
                  <v-card-title>
                    <span class="headline">Edit AHS</span>
                  </v-card-title>

                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                      <v-layout>
                        <v-flex>
                          <v-text-field 
                            v-model="AHS.kode" 
                            label="ID AHS"
                          >
                          </v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="AHS.id_sub"
                          label="Task Group"
                          :items="task"
                          item-text="name"
                          item-value="id_sub"
                          disabled
                          :return-object="false"
                        ></v-select>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="AHS.id_job"
                          label="Task"
                          :items="job"
                          item-text="name"
                          item-value="id_job"
                          disabled
                          :return-object="false"
                        ></v-select>
                      </v-layout>

                    <VBtn
                      depressed
                      color="primary"
                      @click="tambah=true"
                    >
                    Add 
                    </VBtn>

                    <v-flex class="text-md-center" sm12 mt-2>
                        <VCard
                          v-for="detail in details"
                          :key="detail.id_material"
                        > 
                          <v-card-title>
                          <v-btn 
                              icon
                              color="red"
                              dark @click="deleteList(detail)"
                              >
                              <v-icon>remove_circle</v-icon>
                          </v-btn>
                            <v-flex xs13 sm5 md5>
                              <v-select
                                label="Material" 
                                class="pa-1"
                                v-model="detail.id_material"
                                item-text="name"
                                item-value="id_material"
                                :items="material"
                                @change="getSelectedIndex"
                                required 
                              ></v-select>
                            </v-flex>
                            
                            <v-flex xs13 sm5 md5>
                                <v-text-field
                                label="Coefficient*" 
                                class="pa-1"
                                v-model="detail.coefficient"
                                required
                                ></v-text-field>
                              </v-flex>
                          </v-card-title>
                        </Vcard>
                      </v-flex>
                      
                        <V-layout v-if="tambah">
                          <VCard> 
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
                              dark @click="addList()"
                              >
                              <v-icon>add_circle</v-icon>
                          </v-btn>
                            <v-flex xs13 sm5 md5>
                              <v-select
                                label="Material" 
                                class="pa-1"
                                v-model="Material.id_material"
                                item-text="name"
                                item-value="id_material"
                                :return-object="false"
                                :items="material"
                                required 
                                @change="getSelectedIndex"
                              ></v-select>
                            </v-flex>
                            
                            <v-flex xs13 sm5 md5>
                              <v-text-field
                              label="Coefficient*" 
                              class="pa-1"
                              v-model="ahs_details.coefficient"
                              required
                              ></v-text-field>
                            </v-flex>
                          </v-card-title>
                        </Vcard>
                      </v-layout>

                      <v-layout>
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
            </template>

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
                            <v-btn color="green darken-1" text @click="dialog6 = false; deleteDetail(item.id_ahs_details)">Yes</v-btn>
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
import ahsController from './../service/AHS'
import detailController from './../service/Details'
import task from './../service/TaskSub'

  export default {
    data: () => ({
      valid: true,

      snack: false,
      snackColor: '',
      snackText: '',
      
      dialog: false,
      dialogDelete: false,
      dialog5: false,
      dialog6: false,
      tambah: false,

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

      detail: {
        id_material:'',
        coefficient:'',
        sub_total:''
      },
      
      AHS:{
        kode:'',
        id_ahs:'',
        id_job: '',
        id_sub:'', 
        total_labor: 0,
        total_material: 0,
        total: 0
      },
      ahs_details:{
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
      this.getallDetails()
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
      itemEdit(item){
        this.AHS = item
        this.details = item.ahs_details.data
      },
      async addList()
      {
        var object = this.ahs_details
        let data = this.material.find(obj=>obj.id_material == this.Material.id_material)
        object.id_material = this.material[this.index].id_material
        object.coefficient = this.ahs_details.coefficient
        object.sub_total   = data.price * this.ahs_details.coefficient
        
        if(data.status == "material")
          this.AHS.total_material += object.sub_total 
        if(data.status == "labor")
          this.AHS.total_labor += object.sub_total

        this.AHS.total = parseInt(this.AHS.total_material) + parseInt(this.AHS.total_labor)

        this.details.push(JSON.parse(JSON.stringify(object)))
        console.log('Detail AHS')
        console.log(this.details)
        this.tambah = false
        this.Material.id_material=''
        this.ahs_details.coefficient=0
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
        }catch(err){
          console.log(err)
        }
      },
      async getItem(id){
        try{
          this.details  = (await detailController.getItem(id)).data
        }catch(err){
          console.log(err)
        }
      },
      reset () {
        this.$refs.form.reset()
        this.details=[]
      },
      close () {
        this.dialog = false
        this.dialog5 = false
        this.dialog6 = false
        this.details=[]
        this.getallAHS()
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