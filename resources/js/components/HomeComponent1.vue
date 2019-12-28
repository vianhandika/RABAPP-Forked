<template>
  <v-row justify="center">
    <v-expansion-panels accordion>
      <v-expansion-panel>
        <v-expansion-panel-header >
          <v-data-table
          :headers="headers"
          :items="ahs"
          sort-by="date"
          class="elevation-1"
          >
          </v-data-table>
          </v-expansion-panel-header>
      
          <template v-slot:item.action="{ item }">
            <v-dialog v-model="dialog3" max-width="500px">
              <template v-slot:activator="{ on }">
                
              </template>
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
                    Add Material
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
                          <v-flex>
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
                            
                            <v-flex xs12 sm4 md4>
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
                          <v-flex>
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
                            
                              <v-flex xs12 sm4 md4>
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
              <template v-slot:activator="{ on }">
                <v-icon
                  small
                  color="red"
                  v-on="on"
                  @click="itemHandler2(item)"
                >
                  delete
                </v-icon>
              </template>
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
          </template>

          <v-expansion-panel-content>
            <v-data-table
              :headers="headers2"
              class="elevation-1"
              :items="detailsData"
            ></v-data-table>
          </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </v-row>
</template>

<script>
import Controller from './../service/Job'
import materialController from './../service/Material'
import ahsController from './../service/AHS'

  export default {
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      menu: false,
      tambah: false,
      select: null,
      search:'',
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
      items: [
        'm',
        'm2',
        'm3',
        'unit',
        'ls'
      ],
      headers: [
        {
          text : 'ID',
          sortable: false,
          value : 'kode'
        },
        {
          text: 'Task',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Total', 
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
          text: 'ID Material/Labor', align: 'left', sortable: false, value: 'kode',
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
      ],
    }),
    mounted(){
      this.getallDetails()
      this.getallAHS()
      this.getallItem()
      this.getallItemMaterial()
    },
    computed: {
      
    },
    methods: {
      itemHandler(item){
        this.ahs_details = item.ahs_details.data
        console.log(this.ahs_details)
      },
      itemHandler2(item){
        this.AHS = item
        this.AHS.total = 0
        //this.details = item.ahs_details.data;
      },
      async addList()
      {
        this.err = false
        var object = this.Material
        let data = this.material.find(obj=>obj.id_material == this.Material.id_material)
        console.log(data)
        object.id_material = this.material[this.index].id_material
        object.coefficient = this.ahs_details.coefficient
        object.sub_total   = data.price * object.coefficient
        this.AHS.total     = parseInt(object.sub_total + this.AHS.total,10)

        this.details.push(JSON.parse(JSON.stringify(object)))
        this.tambah = false
        this.Material.id_material=""
        this.ahs_details.coefficient=0
        this.ahs_details.sub_total = 0
      },
      deleteList(id){
        let data = this.details.find(obj=>obj.id_material == id)
        console.log(data)
        this.AHS.total = parseInt(this.AHS.total - data.sub_total,10)
        
        let filter = this.details.filter(function( obj ) {
            return obj.id_material !== id;
        });
        this.details=filter
      },
      getSelectedIndex(){
        this.index = this.material.map(function(e) { return e.id_material; }).indexOf(this.Material.id_material);
        console.log(this.index)
      },
      async getallDetails(){
        try{
          this.detailsData = (await ahsController.getallDetails()).data
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
            kode    : this.AHS.kode,
            id_job  : this.AHS.id_job,
            total   : this.AHS.total,
            detail  : this.details
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
              id_job  : this.AHS.id_job,
              total   : this.AHS.total,
              detail  : this.details
            } 
            await ahsController.updateItem(payload,id)
            this.getallAHS()
            this.close()
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
      refresh(){
        this.AHS.kode             =''
        this.AHS.id_job           =''
        this.AHS.total            =0
        this.details              =''
        this.Material.id_material =''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>