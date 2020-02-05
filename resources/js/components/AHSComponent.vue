<template>
  <div class="ahs">
    <v-toolbar dark color="cyan">
      <v-toolbar-title>AHS</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>

      <v-text-field
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="search"
          label="Search"
          class="hidden-sm-and-down"
          color="blue"
          v-model="search"
      >
      </v-text-field>
    
      <div class="flex-grow-1"></div>
      <v-dialog v-model="dialog" max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn color="blue" dark class="mb-2" v-on="on">New</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">New AHS</span>
          </v-card-title>
          
          <Vform>
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
                ></v-select>
              </v-layout>

              <v-layout>
                <v-select
                    v-model="AHS.id_job"
                    label="Task"
                    :items="job"
                    item-text="name"
                    item-value="id_job"
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
          </Vform>

          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
            <v-btn class="ma-2" rounded color="orange" dark @click="addItem()">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>

    <v-expansion-panels accordion>
      <!-- <v-text-field
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="search"
          label="Search"
          class="hidden-sm-and-down"
          color="blue"
          v-model="search"
      >
      </v-text-field> -->
      
      <v-expansion-panel v-for="data in filtered" :key="data.name"  :search="search">
          <v-expansion-panel-header>
            <v-layout row wrap :class="`pa-3 ahs`">
              <v-flex >
                <div class="caption grey--text">ID AHS</div>
                <div>{{ data.kode }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Task Group</div>
                <div>{{ data.name_sub }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Task</div>
                <div>{{ data.name }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Total of Labor</div>
                <div>Rp. {{ data.total_labor }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Total of Materials</div>
                <div>Rp. {{ data.total_material }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Total</div>
                <div>Rp. {{ data.total }}</div>
              </v-flex>
              <v-flex>
                <div class="caption grey--text">Actions</div>
                <v-icon color="green" @click="itemHandler2(data);dialog5=true">edit</v-icon>
                <v-icon color="red" @click="itemHandler2(data);dialog2=true">delete</v-icon>
              </v-flex>
            </v-layout>
            
            <template v-slot:actions>
              <v-icon color="cyan" @click="itemHandler(data)">expand_more</v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text">
            <template>
              <div>
                <v-data-table
                  :headers="headers2"
                  sortBy="status"
                  update: sort-desc
                  class="elevation-1"
                  :items="ahs_details"
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
                        @click="itemDetailHandler(item)"
                      >
                        delete
                      </v-icon>
                    </template>
                        <v-card>
                          <v-card-title class="headline">Confirmation</v-card-title>
                            <v-card-text>Are you sure want to delete this detail?</v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialog6 = false; deleteDetail(detail.id_ahs_details)">Yes</v-btn>
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

    <v-dialog v-model="dialog5" max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Edit AHS</span>
        </v-card-title>

        <Vform>
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
                    dark @click="deleteList(detail.id_material)"
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
        </Vform>

        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
          <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(AHS.id_ahs)">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog2" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this AHS?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(AHS.id_ahs)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
      select: null,
      search:'',
      cari:'',
      id_job:'',
      id_ahs:'',
      id_material:'',
      name: '',
      total: 0,
      coefficient:0,
      ahs: [],
      ahsData:[],
      ahsdata:[],
      job: [],
      material:[],
      details:[],
      detailsData:[],
      task:[],

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
      temp:{
        id_ahs_details:'',
        id_material: '',
        coefficient: 0,
      },
      Material:{
        id_material:'',
      },
      headers: [
        {
          text : 'ID',
          sortable: false,
          value : 'kode'
        },
        {
          text: 'Task Group',
          align: 'left',
          sortable: false,
          value: 'name_sub'
        },
        {
          text: 'Task',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Total of Labor (Rp)', 
          value: 'total_labor'
        },
        { 
          sortable: false,
          text: 'Total of Materials (Rp)', 
          value: 'total_material'
        },
        { 
          sortable: false,
          text: 'Total (Rp)', 
          value: 'total'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      headers2: [
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
      this.getall()
      this.getallItem()
      this.getallItemMaterial()
      this.getTask()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
          return data.name.match(this.search);
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
      itemHandler(item){
        console.log('item')
        console.log(item)
        this.AHS = item
        this.ahs_details = item.ahs_details.data
        this.cari = AHS.kode
        // return this.ahs.filter((item)=>{
        //   return AHS.kode.match(this.cari);
        // });

        console.log(this.ahs_details)
        console.log('AHS')
        console.log(this.AHS)
      },
      itemHandler2(item){
        console.log("Ini AHS")
        this.AHS = item
        this.details = item.ahs_details.data
        console.log(this.AHS)
      },
      itemDetailHandler(item){
        this.detail = item
        console.log(this.detail)
      },
      async addList()
      {
        this.err = false
        var object = this.Material
        let data = this.material.find(obj=>obj.id_material == this.Material.id_material)
        object.id_material = this.material[this.index].id_material
        object.coefficient = this.ahs_details.coefficient
        object.sub_total   = data.price * object.coefficient
        
        if(data.status == "material")
        {
          this.AHS.total_material = object.sub_total + this.AHS.total_material
        }
        if(data.status == "labor")
        {
          this.AHS.total_labor = object.sub_total + this.AHS.total_labor
        }
        this.AHS.total     = parseInt(object.sub_total + this.AHS.total,10)
        console.log(this.AHS.total)

        this.details.push(JSON.parse(JSON.stringify(object)))
        console.log(this.details)
        this.tambah = false
        this.Material.id_material=""
        this.ahs_details.coefficient=0
        this.ahs_details.sub_total = 0
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
      async getallDetails(id){
        try{
          this.detailsData = (await detailController.getItem(id)).data
        }catch(err){
          console.log(err)
        }
      },
      async getall(){
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
          this.getallAHS();
          this.close();
          this.refresh();
        }catch(err){
          console.log(err)
        }
      },
      async updateItem(id){
        try{
            const payload = {
              kode    : this.AHS.kode,
              id_sub  : this.AHS.id_sub,
              total   : this.AHS.total,
              total_labor : this.AHS.total_labor,
              total_material  : this.AHS.total_material,
              detail  : this.details
            } 
            await ahsController.updateItem(payload,id)
            this.getallAHS()
            this.getall()
            this.close()
            this.refresh()
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
            this.close()
            this.getallAHS()
            this.getallDetails()
            this.refresh()
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
          await detailController.deleteItem(id).data
          // this.getallDetails(id)
          this.getall()
        }catch(err){
          console.log(err)
        }
      },
      async getItem(id){
        try{
          await detailController.getItem(id).data
        }catch(err){
          console.log(err)
        }
      },
      refresh(){
        this.AHS.kode             =''
        this.AHS.id_job           =''
        this.AHS.total            =0
        this.details              =''
        this.Material.id_material =''
        // window.location.reload()

      },
      close () {
        this.dialog = false
        this.dialog3 = false
        this.dialog5 = false
        this.dialog6 = false
        this.dialog7 = false
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