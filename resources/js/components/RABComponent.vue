<template>
  <v-data-table
    :headers="headers"
    :items="RAB"
    sort-by="date"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>RAB</v-toolbar-title>
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
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" max-width="750px">
          <template v-slot:activator="{ on }">
            <v-btn color="blue" dark class="mb-2" v-on="on">New</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">New RAB</span>
            </v-card-title>
            
          <Vform> 
            <v-card-text>
              <v-layout>
                <v-text-field
                  v-model="rab.kode"
                  label="ID"
                >
                </v-text-field>
              </v-layout>

              <v-layout>
                <v-select
                  v-model="rab.id_project"
                  label="Project"
                  :items="project"
                  item-text="name"
                  item-value="id_project" 
                  :return-object="false"
                  ></v-select>
              </v-layout>

              <v-layout>
                <v-select
                  v-model="rab.id_group"
                  label="Sub Project"
                  :items="groupData"
                  item-text="name"
                  item-value="id_group" 
                  :return-object="false"
                  ></v-select>
              </v-layout>

              <VBtn
                depressed
                color="primary"
                @click="tambah=true"
              >
              Add AHS
              </VBtn>

              <v-flex class="text-md-center" sm12 mt-2>
                  <VCard
                   v-for="detail in details"
                   :key="detail.id_ahs"
                  > 
                    <v-card-title>
                    <v-btn 
                        icon
                        color="red"
                        dark @click="deleteList(detail.ahs)"
                        >
                        <v-icon>remove_circle</v-icon>
                    </v-btn>
                     <v-flex>
                        <v-select
                          label="AHS" 
                          class="pa-1"
                          v-model="detail.id_ahs"
                          item-text="name"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>
                      
                      <v-flex xs12 sm4 md4>
                        <v-select
                          label="Total" 
                          class="pa-1"
                          v-model="detail.id_ahs"
                          item-text="total"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                          disabled
                        ></v-select>
                      </v-flex>

                      <v-flex>
                        <v-text-field
                          v-model="rab_details.volume"
                          label="Volume"
                          class="pa-1"
                        >
                        </v-text-field>
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
                          label="AHS" 
                          class="pa-1"
                          v-model="AHS.id_ahs"
                          item-text="name"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>
                      
                      <v-flex xs12 sm4 md4>
                        <v-select
                          label="Total" 
                          class="pa-1"
                          v-model="AHS.id_ahs"
                          item-text="total"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          disabled
                          required 
                        ></v-select>
                      </v-flex>

                      <v-flex>
                        <v-text-field
                          v-model="rab_details.volume"
                          label="Volume"
                          class="pa-1"
                        >
                        </v-text-field>
                      </v-flex>
                      </v-card-title>
                  </Vcard>
                 </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="rab.total_rab"
                    label="Total RAB"
                  ></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="rab.coefficient"
                    label="Coefficient*"
                  ></v-text-field>
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

    <template v-slot:item.action="{ item }">
      <v-dialog v-model="dialog3" max-width="450px">
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
              <span class="headline">Edit RAB</span>
            </v-card-title>
          
            <Vform>
              <v-card-text>
              <v-layout>
                <v-text-field
                  v-model="rab.kode"
                  label="ID"
                >
                </v-text-field>
              </v-layout>

              <v-layout>
                <v-select
                  v-model="rab.id_project"
                  label="Project"
                  :items="project"
                  item-text="name"
                  item-value="id_project" 
                  :return-object="false"
                  ></v-select>
              </v-layout>

              <VBtn
                depressed
                color="primary"
                @click="tambah=true"
              >
              Add AHS
              </VBtn>

              <v-flex class="text-md-center" sm12 mt-2>
                  <VCard
                   v-for="detail in details"
                   :key="detail.id_ahs"
                  > 
                    <v-card-title>
                    <v-btn 
                        icon
                        color="red"
                        dark @click="deleteList(detail.ahs)"
                        >
                        <v-icon>remove_circle</v-icon>
                    </v-btn>
                     <v-flex>
                        <v-select
                          label="AHS" 
                          class="pa-1"
                          v-model="detail.id_ahs"
                          item-text="name"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>
                      
                      <v-flex xs12 sm4 md4>
                        <v-select
                          label="Total" 
                          class="pa-1"
                          v-model="detail.id_ahs"
                          item-text="total"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                          disabled
                        ></v-select>
                      </v-flex>

                      <v-flex>
                        <v-text-field
                          v-model="rab_details.volume"
                          label="Volume"
                          class="pa-1"
                        >
                        </v-text-field>
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
                          label="AHS" 
                          class="pa-1"
                          v-model="AHS.id_ahs"
                          item-text="name"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          required 
                        ></v-select>
                      </v-flex>
                      
                      <v-flex xs12 sm4 md4>
                        <v-select
                          label="Total" 
                          class="pa-1"
                          v-model="AHS.id_ahs"
                          item-text="total"
                          item-value="id_ahs"
                          :items="ahs"
                          @change="getSelectedIndex"
                          disabled
                          required 
                        ></v-select>
                      </v-flex>

                      <v-flex>
                        <v-text-field
                          v-model="rab_details.volume"
                          label="Volume"
                          class="pa-1"
                        >
                        </v-text-field>
                      </v-flex>
                      </v-card-title>
                  </Vcard>
                 </v-layout>
              
              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="rab.total_rab"
                    label="Total RAB"
                  ></v-text-field>
                </v-flex>
              </v-layout>
                 
              <v-layout>
                <v-flex>
                  <v-text-field
                    v-model="rab.coefficient"
                    label="Coefficient*"
                  ></v-text-field>
                </v-flex>
              </v-layout>

            </v-card-text>
            </Vform>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
              <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(rab.id_rab)">Save</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>

      <v-dialog v-model="dialog4" max-width="600px">
        <template v-slot:activator="{ on }">
          <v-icon
            small
            color="blue"
            v-on="on"
            @click="itemHandler(item)"
          >
            remove_red_eye
          </v-icon>
        </template>
            <template>
            <div>
              <v-data-table
                :headers="headers2"
                :items="rab_details"
                class="elevation-1"
              ></v-data-table>
            </div>
          </template>
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
                <v-card-text>Are you sure want to delete this project?</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(rab.id_rab)">Yes</v-btn>
                <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
              </v-card-actions>
            </v-card>
      </v-dialog>
    </template>
  </v-data-table>
</template>

<script>
import Controller from './../service/Project'
import ahsController from './../service/AHS'
import rabController from './../service/RAB'

  export default {
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      menu: false,
      tambah: false,
      details:[],
      project: [],
      ahs: [],
      RAB:[],
      detailsData: [],
      groupData: [],
      rab_details:{
        id_rab_details:'',
        id_rab:'',
        id_ahs:'',
        sub_total:0,
        volume: 1,
      },
      AHS:{
        total:0,
        id_ahs:'',
      },
      rab:{
        id_rab:'',
        id_project:'',
        id_ahs:'',
        coefficient: 1,
        total_rab:0,
        kode:'',
        id_group: '',
      },
      Project: {
        name:'',
        date: new Date().toISOString().substr(0, 10),
        address: '',
        contact: '',
        id_project: '',
        phone: '',
      },
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
        },
        {
          text: 'Project',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Coefficient', 
          value: 'coefficient'
        },
        { 
          sortable: false,
          text: 'Total', 
          value: 'total_rab'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      headers2: [
        { 
          text: 'ID AHS', align: 'left', sortable: false, value: 'kode_ahs',
        },
        { 
          text: 'Satuan', align: 'left', sortable: false, value: 'satuan',
        },
        { 
          text: 'Volume', align: 'left', sortable: false, value: 'volume',
        },
        { 
          text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total',
        },
      ],
    }),
    mounted(){
      this.getallItem()
      this.getallAHS()
      this.getallRAB()
      this.getallDetails()
      this.getGroup()
    },
    computed: {
    },
    methods: {
      itemHandler(item){
        this.rab_details = item.rab_details.data
        console.log(this.rab_details)
      },
      itemHandler2(item){
        this.rab = item
        this.rab.total_rab = 0
      },
      async addList()
      {
        var i = 0
        this.err = false
        var object = this.AHS
        let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
        console.log(data)
        object.id_ahs = this.ahs[this.index].id_ahs
        object.volume = this.rab_details.volume
        object.sub_total   = object.volume * data.total
        this.rab.total_rab = parseInt(object.sub_total + this.rab.total_rab,10);
        this.rab.id_ahs = object.id_ahs
        console.log(object.sub_total)
        this.details.push(JSON.parse(JSON.stringify(object)))
        console.log(this.details)
        this.tambah = false
        this.AHS.id_ahs=""
      },
      deleteList(id){
        this.rab_details.volume=0
        let data = this.details.find(obj=>obj.id_job == id)
        console.log(data)
        this.rab.total_rab = parseInt(this.rab.total_rab - data.sub_total,10)
        let filter = this.details.filter(function( obj ) {
            return obj.id_job !== id;
        });
        this.details=filter
      },
      getSelectedIndex(){
        this.index = this.ahs.map(function(e) { return e.id_ahs; }).indexOf(this.AHS.id_ahs);
        console.log(this.index)
      },
      async getGroup(){
        try{
          this.groupData = (await rabController.getGroup()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallDetails(){
        try{
          this.detailsData = (await rabController.getallDetails()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS(){
        try{
          this.ahs = (await ahsController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallRAB(){
        try{
          this.RAB = (await rabController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async addItem(){
        try{
          const payload = {
            id_project    : this.rab.id_project,
            id_ahs        : this.rab.id_ahs,
            kode          : this.rab.kode,
            coefficient   : this.rab.coefficient,
            total_rab     : this.rab.total_rab * this.rab.coefficient,
            detail        : this.details
          }
          await rabController.addItem(payload)
          this.getallRAB()
          this.refresh()
          this.close()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              id_project    : this.rab.id_project,
              id_ahs        : this.rab.id_ahs,
              kode          : this.rab.kode,
              coefficient   : this.rab.coefficient,
              total_rab     : this.rab.total_rab * this.rab.coefficient,
              detail        : this.details
            } 
            await rabController.updateItem(payload,id)
            this.getallRAB()
            this.close()
            this.refresh()
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await rabController.deleteItem(id).data
          this.getallRAB()
          this.refresh()
        }catch(err){
          console.log(err)
        }
      },
      refresh(){
        this.deleteList()
        // this.rab.id_project= ''
        // this.rab.id_ahs = ''
        // this.rab.kode = ''
        // this.rab.coefficient = ''
        // this.rab.total_rab = ''
        this.rab = ''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
      },
    },
  }
</script>