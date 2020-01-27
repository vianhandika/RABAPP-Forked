<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      dark
      color="cyan darken-1"
    >
      <v-list dense>
        <v-list-item @click="home">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>dashboard</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="project">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>home_work</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Project</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="store">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>store</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Store</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="job">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>work</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Task</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="materials">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>waves</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Materials/Labor</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="analisa">
          <v-list-item-action>
            <v-btn icon>
            <v-icon>money</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>AHS</v-list-item-title>
          </v-list-item-content>
        </v-list-item>


        <v-list-item @click="transaction">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>payment</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>RAB</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- <v-list-item @click="reports">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>file_copy</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Report</v-list-item-title>
          </v-list-item-content>
        </v-list-item> -->

      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="light-blue"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer">
        <v-icon>reorder</v-icon>
      </v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
      >
        <!-- Dashboard -->
          Vastu Cipta Persada
      </v-toolbar-title>
      
      <v-spacer></v-spacer>

       <div class="logout" >
          <v-btn @click="logout" outlined color="white">
            <v-icon>logout</v-icon>
            Log Out
          </v-btn>
        </div>
    </v-app-bar>

    <v-content>
      <div>
        <v-card color="white">
          <v-breadcrumbs :items="items"></v-breadcrumbs>
        </v-card> 

        <br>
        <v-container >
          <v-layout row wrap>
            <v-flex
              sm6
              xs12
              md6
              lg3
            >
            <v-card class="ma-3">
              <v-list-item>
                <v-list-item-avatar
                  tile
                  class="mt-n7"
                >
                <v-sheet color="green" width="80" height="80" elevation="10">
                  <v-icon dark large>home_work</v-icon>
                </v-sheet>
                </v-list-item-avatar>

                <v-list-item-content>
                  <div class="overline text-right">Project</div>
                  <v-list-item-title class="headline mb-1 text-right" v-for="projects in counter" :key="projects.count">{{ projects.count }}</v-list-item-title>
                  <div><v-divider></v-divider></div>
                </v-list-item-content> 
              </v-list-item>

              <v-card-actions>
                <v-icon text class="ma-2">house</v-icon>
                <div class="overline">Vastu Cipta Persada</div>
              </v-card-actions>
            </v-card>
            </v-flex>

            <v-flex
              sm6
              xs12
              md6
              lg3
            >
            <v-card class="ma-3">
              <v-list-item>
                <v-list-item-avatar
                  tile
                  class="mt-n7"
                >
                <v-sheet color="#F44336" width="80" height="80" elevation="10">
                      <v-icon dark large>store</v-icon>
                </v-sheet>
                </v-list-item-avatar>

                <v-list-item-content>
                  <div class="overline text-right">Store</div>
                  <v-list-item-title class="headline mb-1 text-right" v-for="counts in store" :key="counts.count">{{ counts.count }}</v-list-item-title>
                  <div><v-divider></v-divider></div>
                </v-list-item-content> 
              </v-list-item>

              <v-card-actions>
                <v-icon text class="ma-2">house</v-icon>
                <div class="overline">Vastu Cipta Persada</div>
              </v-card-actions>
            </v-card>
            </v-flex>

            <v-flex
              sm6
              xs12
              md6
              lg3
            >
              <v-card class="ma-3">
                <v-list-item>
                  <v-list-item-avatar
                    tile
                    class="mt-n7"
                  >
                  <v-sheet color="#03A9F4" width="80" height="80" elevation="10">
                        <v-icon dark large>money</v-icon>
                  </v-sheet>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <div class="overline text-right">RAB</div>
                    <v-list-item-title class="headline mb-1 text-right" v-for="counts in counter_rab" :key="counts.count">{{ counts.count }}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">VISA Card</div>
                </v-card-actions>
              </v-card>
            </v-flex>

          <v-flex
            sm6
            xs12
            md6
            lg3
          >
          <v-card class="ma-3">
            <v-list-item >
              <v-list-item-avatar
                tile
                class="mt-n7"
              >
              <v-sheet color="#FFC107" width="80" height="80" elevation="10">
                    <v-icon dark large>payment</v-icon>
              </v-sheet>
              </v-list-item-avatar>
              <v-list-item-content>
                <div class="overline text-right">Total RAB</div>
                <v-list-item-title class="headline mb-1 text-right" v-for="counts in rab" :key="counts.total">Rp. {{ counts.total }}</v-list-item-title>
                <div><v-divider></v-divider></div>
              </v-list-item-content> 
            </v-list-item>

            <v-card-actions>
              <v-icon text class="ma-2">folder</v-icon>
              <div class="overline">Prodect</div>
            </v-card-actions>
          </v-card>
          </v-flex>

          <!-- <v-flex xs12 sm6 md4 lg3>
            <v-card class="text-center ma-3">
              <v-responsive class="pt-4">
              </v-responsive>
              <v-card-text>
                <div class="subheading">{{person.count}}</div>
                <div class="grey--text">{{person.count}}</div>
              </v-card-text>
              <v-card-actions>
                  <v-btn outlined color="orange">
                      <v-icon small left >message</v-icon>
                      <span>Message</span>
                  </v-btn>
              </v-card-actions>
            </v-card>
          </v-flex> -->

          <!-- <v-flex>
            <v-card class="text-center ma-3">
              <v-card-title>
                What
              </v-card-title>
            </v-card>
          </v-flex> -->
          
          <v-flex>
            <v-card class="text-center ma-3">
              <v-card-title>
                Reports
              </v-card-title>

              <!-- <v-responsive class="pt-4">
                <v-data-table
                :headers="headers"
                :items="item">
                  <template v-slot:item.action="{ item }">
                    <v-dialog v-model="dialog3" max-width="450px">
                      <template v-slot:activator="{ on }">
                        <v-icon
                          small
                          class="mr-2"
                          color="green"
                          v-on="on"
                        >
                          picture_as_pdf
                        </v-icon>
                      </template>
                        <v-card>
                          <v-card-title>
                            <span class="headline">Edit Task</span>
                          </v-card-title>
                        
                          <Vform>
                            <v-card-text>
                              <v-layout>
                                <v-flex>
                                  <v-text-field 
                                    v-model="Job.kode" 
                                    label="ID Task"
                                    :error-messages="idErrors"
                                    @input="$v.Job.kode.$touch()"
                                    @blur="$v.Job.kode.$touch()"
                                  >
                                  </v-text-field>
                                </v-flex>
                              </v-layout>

                              <v-layout>
                                  <v-flex>
                                    <v-text-field 
                                      v-model="Job.name" 
                                      label="Name"
                                      :error-messages="nameErrors"
                                      @input="$v.Job.name.$touch()"
                                      @blur="$v.Job.name.$touch()"
                                    >
                                    </v-text-field>
                                  </v-flex>
                                </v-layout>

                                <v-container row>
                                  <v-select row
                                    v-model="Job.satuan"
                                    :items="satuan"
                                    item-text="name"
                                    item-value="name"
                                    label="Satuan"
                                    :error-messages="satuanErrors"
                                    @input="$v.Job.satuan.$touch()"
                                    @blur="$v.Job.satuan.$touch()"
                                  ></v-select>
                                  <v-btn 
                                    width="50px" 
                                    color="blue" 
                                    @click="dialog4=true"
                                  > 
                                  Add
                                  </v-btn>
                                </v-container>

                                <template>
                                <v-dialog v-model="dialog4" width="300px" style="color: blue">
                                  <v-card-text>
                                    <v-layout>
                                      <v-text-field
                                        label="Satuan"
                                        v-model="name"
                                      >
                                      </v-text-field>
                                    </v-layout>
                                    <div class="flex-grow-1"></div>
                                      <v-btn class="ma-2" rounded color="green" dark @click="dialog4=false">Cancel</v-btn>
                                      <v-btn class="ma-2" rounded color="orange" dark @click="addSatuan()">Save</v-btn>                  
                                  </v-card-text>
                                </v-dialog>
                                </template>

                                <v-radio-group v-model="Job.status" row> 
                                  <v-radio label="Volume" value="v"></v-radio>
                                  <v-radio label="Price" value="p"></v-radio>
                                </v-radio-group> 

                                <v-select row
                                    v-model="Job.status"
                                    :items="items"
                                    label="Status"
                                    :error-messages="statusErrors"
                                    @input="$v.Job.status.$touch()"
                                    @blur="$v.Job.status.$touch()"
                                  ></v-select>

                                <v-layout>
                                  <v-flex>
                                    <v-text-field 
                                      v-model="Job.details" 
                                      label="Spesification"
                                      :error-messages="detailsErrors"
                                      @input="$v.Job.details.$touch()"
                                      @blur="$v.Job.details.$touch()"
                                    >
                                    </v-text-field>
                                  </v-flex>
                                </v-layout>
                            </v-card-text>
                          </Vform>

                          <v-card-actions>
                            <div class="flex-grow-1"></div>
                            <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                            <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(Job.id_job)">Save</v-btn>
                          </v-card-actions> 
                        </v-card>
                    </v-dialog>

                    <v-dialog v-model="dialog2" max-width="290px">
                      <template v-slot:activator="{ on }">
                        <v-icon
                          small
                          color="red"
                          v-on="on"
                          @click="itemHandler(item)"
                        >
                          delete
                        </v-icon>
                      </template>
                          <v-card>
                            <v-card-title class="headline">Confirmation</v-card-title>
                              <v-card-text>Are you sure want to delete this task?</v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(Job.id_job)">Yes</v-btn>
                              <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
                            </v-card-actions>
                          </v-card>
                    </v-dialog>
                  </template>
                </v-data-table>
              </v-responsive>  -->
              <template>
                <v-expansion-panels focusable>
                  <v-expansion-panel
                    v-for="(item,i) in 5"
                    :key="i"
                  >
                    <v-expansion-panel-header>Item</v-expansion-panel-header>
                    <v-expansion-panel-content>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </template>
              
            </v-card>
          </v-flex>

          </v-layout>
        </v-container>
      </div>
    </v-content>

    <!-- <v-footer
      color="blue lighten-1"
      app
    >
      <span class="white--text">&copy; copyright 2019</span>
    </v-footer> -->
  </v-app>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
import Controller from './../service/Project'

  export default {
    name: 'team',
    counter:[],
    store:[],
    rab:[],
    counter_rab:[],
    props: {
      source: String,
    },
    data: () => ({
      dialog2: false,
      dialog3: false,
      items: [
      {
        text: 'Dashboard',
        disabled: false,
        href: 'transaction'
      },
      {
        text: 'Reports',
        disabled: false,
        href: 'reports'
      }
    ],
    headers: [
        {
          text : 'No',
          sortable: false,
          value : 'no'
        },
        {
          text: 'Name',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        {
          sortable: false,
          text: 'Cek',
          value: 'status'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      item:[
        {
          no: '1', name: 'Laporan Rencana Anggaran Biaya', sortable: false
        }
      ],
      drawer: null,
    }),
    mounted() {
      this.counter()
      this.counter_store()
      this.counter_rab()
      this.total()
    },
    computed: {
      ...mapState({
          loading: state => state.Token.loading,
          error: state => state.Token.error,
          token: state => state.Token.token,
        }),
    },
    methods: {
      ...mapActions({
        destroyToken: 'Token/deleteToken',
      }),

      ...mapGetters({
        loggedIn: 'Token/loggedIn',
      }),
      async logout() {
          await this.destroyToken()
          this.$router.push({ name : 'login' })
      },
      project (){
          this.$router.push({name: 'project'});
      },
      job () {
        this.$router.push({name: 'job'});
      },
      materials(){
        this.$router.push({name: 'materials'});
      },
      transaction(){
        this.$router.push({name: 'transaction'});
      },
      analisa(){
        this.$router.push({name: 'analisa'})
      },
      home(){
        this.$router.push({name: 'dashboard'})
      },
      store(){
        this.$router.push({name: 'store'})
      },
      async counter(){
        try{
          this.counter = (await Controller.count()).data
        }catch(err){
          console.log(err)
        }
      },
      async counter_store(){
        try{
          this.store = (await Controller.count_store()).data
        }catch(err){
          console.log(err)
        }
      },
      async total(){
        try{
          this.rab = (await Controller.total()).data
        }catch(err){
          console.log(err)
        }
      },
      async counter_rab(){
        try{
          this.counter_rab = (await Controller.count_rab()).data
        }catch(err){
          console.log(err)
        }
      }
    }
  }
</script>