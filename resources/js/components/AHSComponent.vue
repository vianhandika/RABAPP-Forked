<template>
  <div>
    <template>
      <v-toolbar flat color="cyan">
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
                    <!-- buat ditampilkan setelah di clik addList -->
                     <v-flex>
                        <v-select
                          label="Material/Labor" 
                          class="pa-1"
                          v-model="detail.id_material"
                          item-text="name"
                          item-value="id_material"
                          :items="material"
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>

                      <!-- <v-flex xs12 sm4 md4>
                        <v-select
                          label="Status" 
                          class="pa-1"
                          v-model="detail.id_material"
                          item-text="status"
                          item-value="id_material"
                          :return-object="false"
                          :items="material"
                          required 
                          @change="getSelectedIndex"
                          disabled
                        ></v-select>
                      </v-flex> -->
                      
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
                     <v-flex>
                        <v-select
                          label="Material/Labor" 
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

                      <!-- <v-flex xs12 sm4 md4>
                        <v-select
                          label="Status" 
                          class="pa-1"
                          v-model="Material.id_material"
                          item-text="status"
                          item-value="id_material"
                          :return-object="false"
                          :items="material"
                          required 
                          @change="getSelectedIndex"
                          disabled
                        ></v-select>
                      </v-flex> -->
                      
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

                
                <v-layout >
                  <!-- <v-flex xs12 sm4 md4>
                    <v-text-field 
                      v-model="AHS.total_labor" 
                      label="Total of Labor"
                      required
                    >
                    </v-text-field>
                  </v-flex>

                  <v-spacer></v-spacer>
                  <v-flex xs12 sm4 md4>
                    <v-text-field 
                      v-model="AHS.total_material" 
                      label="Total of Material"
                      required
                    >
                    </v-text-field>
                  </v-flex> -->

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
    </template>

    <v-dialog v-model="dialog3" max-width="500px">
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
                    disabled
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

    <v-dialog v-model="dialog4" max-width="600px">
      <template>
        <div>
          <v-data-table
            :headers="headers2"
            :items="ahs_details"
            class="elevation-1"
            hide-actions
          >
          </v-data-table>
        </div>
      </template>
    </v-dialog>

    <v-row justify="center">
      <v-expansion-panels accordion>
        <v-expansion-panel>
            <v-data-table 
              :headers="headers"
              :items="ahs"
              :search="search"
              class="my-data-table"
            >
            <template v-slot:item.action="{ item }">
              <v-expansion-panel-header>
              <v-dialog v-model="dialog3" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    class="mr-2"
                    color="green"
                    @click="itemHandler2(item)"
                    v-on="on"
                  >
                    edit
                  </v-icon>
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

              <v-icon
                small
                color="blue"
                @click="itemHandler(item)"
              >
                remove_red_eye
              </v-icon>
              </v-expansion-panel-header>
              
            </template>
            </v-data-table>
          <v-expansion-panel-content>
            <template>
              <div>
                <v-data-table
                  :headers="headers2"
                  :items="ahs_details"
                  sortBy="status"
                  update: sort-desc
                  class="elevation-1"
                >
                <template v-slot:item.coefficient="props">
                  <v-edit-dialog
                    :return-value.sync="props.item.coefficient"
                    @save="save"
                    @cancel="cancel"
                    @open="open"
                    @close="close"
                    lazy
                    large
                    persistent
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
                  <v-dialog v-model="dialog5" max-width="500px">
                    <template v-slot:activator="{ on }">
                      <v-icon
                        small
                        class="mr-2"
                        color="green"
                        @click="itemDetailHandler(item)"
                        v-on="on"
                      >
                        edit
                      </v-icon>
                    </template>

                    <v-card>
                      <v-card-title>
                        <span class="headline">Edit Detail</span>
                      </v-card-title>
                  
                      <Vform>
                        <v-card-text>
                          <!-- <v-layout>
                            <v-select
                              v-model="detail.id_material"
                              label="Material/Labor"
                              :items="material"
                              item-text="name"
                              item-value="id_material"
                              :return-object="false"
                              @change="getSelectedIndexD"
                              disabled
                            ></v-select>
                          </v-layout>

                          <v-layout>
                            <v-select
                              v-model="detail.id_material"
                              label="Price"
                              :items="material"
                              item-text="price"
                              item-value="id_material"
                              :return-object="false"
                              @change="getSelectedIndexD"
                              disabled
                            ></v-select>
                          </v-layout> -->
                        
                        <v-layout>
                          <v-flex>
                            <v-text-field 
                              v-model="detail.name" 
                              label="Materials/Labor"
                              required
                              disabled
                            >
                            </v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout>
                          <v-flex>
                            <v-text-field 
                              v-model="detail.price" 
                              label="Price"
                              required
                              disabled
                            >
                            </v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout>
                          <v-flex>
                            <v-text-field 
                              v-model="detail.coefficient" 
                              label="Coefficient"
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
                        <v-btn class="ma-2" rounded color="orange" dark @click="updateDetail(detail.id_ahs_details)">Save</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  
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
    </v-row>
  </div>
</template>

<script>
import Controller from './../service/Job'
import materialController from './../service/Material'
import ahsController from './../service/AHS'
import detailController from './../service/Details'

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
          text: 'Task',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Total of Labor', 
          value: 'total_labor'
        },
        { 
          sortable: false,
          text: 'Total of Materials', 
          value: 'total_material'
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
    },
    computed: {
      
    },
    methods: {
      save () {
        this.snack = true
        this.snackColor = 'success'
        this.snackText = 'Data saved'

      },
      cancel () {
        this.snack = true
        this.snackColor = 'error'
        this.snackText = 'Canceled'
      },
      open () {
        this.snack = true
        this.snackColor = 'info'
        this.snackText = 'Dialog opened'
      },
      close () {
        console.log('Dialog closed')
      },
      itemHandler(item){
        this.AHS = item
        this.ahs_details = item.ahs_details.data
        console.log(this.ahs_details)
        console.log('AHS')
        console.log(this.AHS)

      },
      itemHandler2(item){
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
      deleteList(id){
        let data = this.details.find(obj=>obj.id_material == id)
        console.log(data)
        if(data.status == "material")
        {
          this.AHS.total_material -= data.sub_total
        }
        if(data.status == "labor")
        {
          this.AHS.total_labor -= data.sub_total
        }
        this.AHS.total = parseInt(this.AHS.total - data.sub_total,10)
        console.log(this.AHS.total)
        let filter = this.details.filter(function( obj ) {
            return obj.id_material !== id;
        });
        this.details=filter
      },
      
      getSelectedIndex(){
        this.index = this.material.map(function(e) { return e.id_material; }).indexOf(this.Material.id_material);
        console.log(this.index)
      },
      getSelectedIndexD(){
        this.index = this.material.map(function(e) { return e.id_material; }).indexOf(this.detail.id_material);
        console.log(this.index)
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
              //id_job  : this.AHS.id_job,
              total   : this.AHS.total,
              total_labor     : this.AHS.total_labor,
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
      async updateDetail(id){
        try{
            const payload = {
              coefficient   : this.detail.coefficient,
              sub_total     : this.detail.sub_total,
            } 
            await detailController.updateDetail(payload,id)
            this.close()
            // this.getItem($id)
            this.getallAHS()
            // this.getallDetails()
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
      },
    }
  }
</script>