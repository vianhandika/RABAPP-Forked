<template>
  <v-app class="blue lighten-4">
    <v-container>
      <v-layout row="ma-4"></v-layout>
      <v-app v-if="Access('R-Dashboard-R')==true" style="background-color: grey lighten-2" class="elevation-8">
        <v-container>
          <v-layout row wrap>
            <v-flex sm3>
              <v-card class="ma-3">
                <v-list-item>
                  <v-list-item-avatar
                    tile
                    class="mt-n7"
                  >
                  <v-sheet color="green darken-3" width="80" height="80" elevation="10">
                    <v-icon dark large>home</v-icon>
                  </v-sheet>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <div class="overline text-right">Proyek</div>
                    <v-list-item-title class="headline mb-1 text-right">{{countP}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm3>
              <v-card class="ma-3">
                <v-list-item>
                  <v-list-item-avatar
                    tile
                    class="mt-n7"
                  >
                  <v-sheet color="light-blue accent-4" width="80" height="80" elevation="10">
                    <v-icon dark large>waves</v-icon>
                  </v-sheet>
                  </v-list-item-avatar>

                  <v-list-item-content>
<<<<<<< Updated upstream
                    <div class="overline text-right">Bahan/Tenaga Kerja</div>
=======
                    <div class="overline text-right">Bahan/Tenaga</div>
>>>>>>> Stashed changes
                    <v-list-item-title class="headline mb-1 text-right">{{countM}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm3>
              <v-card class="ma-3">
                <v-list-item>
                  <v-list-item-avatar
                    tile
                    class="mt-n7"
                  >
                  <v-sheet color="cyan accent-4" width="80" height="80" elevation="10">
                    <v-icon dark large>money</v-icon>
                  </v-sheet>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <div class="overline text-right">AHS Master</div>
                    <v-list-item-title class="headline mb-1 text-right">{{countahs}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm3>
              <v-card class="ma-3">
                <v-list-item>
                  <v-list-item-avatar
                    tile
                    class="mt-n7"
                  >
                  <v-sheet color="teal accent-4" width="80" height="80" elevation="10">
                    <v-icon dark large>payment</v-icon>
                  </v-sheet>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <div class="overline text-right">RAB</div>
                    <v-list-item-title class="headline mb-1 text-right">{{countrab}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
        <v-col class="body-2 grey--text"><h1>Laporan</h1></v-col>
        <v-row>
          <v-col cols="12" sm="6" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="5" align-center v-if="select==null">
                    <v-card-title class="headline light-green accent-2--text">RAB</v-card-title>
                  </v-col>
                  <v-col cols="5" align-center v-if="select=='1'">
                    <v-card-title class="headline light-green accent-2--text">BOQ</v-card-title>
                  </v-col>
                  <v-col cols="5" align-center v-if="select=='2'">
                    <v-card-title class="headline light-green accent-2--text">KB</v-card-title>
                  </v-col>
                  <v-col cols="5" align-center v-if="select=='3'">
                    <v-card-title class="headline light-green accent-2--text">RAP</v-card-title>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="5" style="margin-left:10px">
                    <v-select
                      label="Pilih"
                      v-model="select"
                      :items="items"
                      item-text="name"
                      item-value="value"
                      append-icon="expand_more"
                      single line
                      hide-details
                      color="green darken-3"
                    ></v-select>
                  </v-col>
                  <v-col cols="3">
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label="Cari"
                      single-line
                      hide details    
                      color="green darken-3"
                      @keyup.enter="searchRAB"
                    >
                    </v-text-field>
                  </v-col>
                  <v-col cols="3">
                    <v-layout>
                      <v-text-field
                        v-model="ppn"
                        label="PPN (%)"
                        color="green darken-3"
                        v-if="select==null"
                        type="number"
                      >
                      </v-text-field>

                      <v-text-field
                        v-model="jasa"
                        label="Jasa (%)"
                        color="green darken-3"
                        v-if="select==null"
                        type="number"
                        style="margin-left:10px"
                      >
                      </v-text-field>  
                    </v-layout>

                    <v-text-field
                      v-model="rap"
                      label="RAP (%)"
                      color="green darken-3"
                      v-if="select==3"
                      type="number"
                      style="width:50px"
                    >
                    </v-text-field>
                    <v-select
                      label="Pilih"
                      v-model="selectMR"
                      :items="itemsMR"
                      item-text="name"
                      item-value="value"
                      append-icon="expand_more"
                      color="green darken-3"
                      v-if="select==2"
                    ></v-select>
                  </v-col>
                </v-row>
                <!-- RAB Report -->
                <v-list v-if="select==null">
                  <v-list-item v-for="data in RAB" :key="data.id_rab">
                    <v-list-item-avatar color="green darken-3">
                      <v-icon dark @click="generateRAB(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{data.project}}</v-list-item-title>
                          </template>
                          <span>{{data.project}}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">Nominal</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">{{ Number(data.total).toLocaleString('id-ID') }}</v-list-item-title>
                          </template>
                          <span>{{ Number(data.total).toLocaleString('id-ID') }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <div>
                  <v-pagination
                    v-model="current_page_rab"
                    class="my-4"
                    :length="total_pages_rab"
                    prev-icon="arrow_left"
                    next-icon="arrow_right"
                    circle
                    @input="getPagination"
                    :total-visible="5"
                    color="green darken-3"
                    v-if="select==null"
                  >
                  </v-pagination>
                </div>
                <!-- BQ Report -->
                <v-list v-if="select=='1'">
                  <v-list-item v-for="data in RAB" :key="data.id_rab">
                    <v-list-item-avatar color="green">
                      <v-icon dark @click="generaterabBQ(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{data.project}}</v-list-item-title>
                          </template>
                          <span>{{data.project}}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">Nominal</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">0</v-list-item-title>
                          </template>
                          <span>0</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <div>
                  <v-pagination
                    v-model="current_page_rab"
                    class="my-4"
                    :length="total_pages_rab"
                    prev-icon="arrow_left"
                    next-icon="arrow_right"
                    circle
                    @input="getPagination"
                    :total-visible="5"
                    color="green"
                    v-if="select=='1'"
                  >
                  </v-pagination>
                </div>
                <!-- Materials Requirements Report -->
                <v-list v-if="select=='2'">
                  <v-list-item v-for="data in RAB" :key="data.id_rab">
                    <v-list-item-avatar color="green accent-4">
                      <v-icon dark @click="generaterabMR(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{data.project}}</v-list-item-title>
                          </template>
                          <span>{{data.project}}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">Nominal</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">{{ Number(data.total).toLocaleString('id-ID') }}</v-list-item-title>
                          </template>
                          <span>{{ Number(data.total).toLocaleString('id-ID') }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <div>
                  <v-pagination
                    v-model="current_page_rab"
                    class="my-4"
                    :length="total_pages_rab"
                    prev-icon="arrow_left"
                    next-icon="arrow_right"
                    circle
                    @input="getPagination"
                    :total-visible="5"
                    color="green accent-4"
                    v-if="select=='2'"
                  >
                  </v-pagination>
                </div>
                <!-- RAP Report -->
                <v-list v-if="select=='3'">
                  <v-list-item v-for="data in RAB" :key="data.id_rab">
                    <v-list-item-avatar color="green darken-2">
                      <v-icon dark @click="generaterabRAP(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{data.project}}</v-list-item-title>
                          </template>
                          <span>{{data.project}}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">Nominal</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">{{ Number(data.total).toLocaleString('id-ID') }}</v-list-item-title>
                          </template>
                          <span>{{ Number(data.total).toLocaleString('id-ID') }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <div>
                  <v-pagination
                    v-model="current_page_rab"
                    class="my-4"
                    :length="total_pages_rab"
                    prev-icon="arrow_left"
                    next-icon="arrow_right"
                    circle
                    @input="getPagination"
                    :total-visible="5"
                    color="green darken-2"
                    v-if="select=='3'"
                  >
                  </v-pagination>
                </div>
              </v-card>
            </v-container>
          </v-col>
          <v-col cols="12" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="5" align-center v-if="selectahs==null">
                    <v-card-title class="headline blue darken-3--text">AHS Master</v-card-title>
                  </v-col>
                  <v-col cols="5" align-center v-if="selectahs=='1'">
                    <v-card-title class="headline light-blue accent-4--text">AHS Lokal</v-card-title>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="5" style="margin-left:10px">
                    <v-select
                      label="Pilih"
                      v-model="selectahs"
                      :items="itemsahs"
                      item-text="name"
                      item-value="value"
                      append-icon="expand_more"
                      single line
                      hide-details
                      color="blue darken-3"
                    ></v-select>
                  </v-col>

                  <v-col cols="4">
                    <v-text-field
                      v-model="searchAHS"
                      append-icon="search"
                      label="Cari"
                      single-line
                      hide details    
                      color="blue darken-3"
                      @keyup.enter="searchAllAHS"
                      v-if="selectahs==null"
                    >
                    </v-text-field>
                    <v-text-field
                      v-model="searchAHSLokal"
                      append-icon="search"
                      label="Cari"
                      single-line
                      hide details    
                      color="blue darken-3"
                      @keyup.enter="searchAllAHSLokal"
                      v-if="selectahs==1"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>
                <!-- AHS -->
                <v-list v-if="selectahs==null">
                  <v-list-item v-for="data in ahs" :key="data.id_ahs">
                    <v-list-item-avatar color="blue darken-3">
                        <v-btn icon dark @click="generateAHS(data.id_ahs)" :loading="load">
                          <v-icon>picture_as_pdf</v-icon> 
                        </v-btn>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{ data.name }}</v-list-item-title>
                          </template>
                          <span>{{ data.name }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>

                    <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">HSP</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">{{ Number(data.total).toLocaleString('id-ID') }}</v-list-item-title>
                          </template>
                          <span>{{ Number(data.total).toLocaleString('id-ID') }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <div>
                <v-pagination
                  v-model="current_page_ahs"
                  class="my-4"
                  :length="total_pages_ahs"
                  prev-icon="arrow_left"
                  next-icon="arrow_right"
                  circle
                  @input="getPaginationAHS"
                  :total-visible="5"
                  color="blue darken-3"
                  v-if="selectahs==null"
                >
                </v-pagination>
              </div>
              <!-- AHS Lokal  -->
              <v-list v-if="selectahs=='1'">
                <v-list-item v-for="data in ahs_lokal" :key="data.id_ahs_lokal">
                  <v-list-item-avatar color="light-blue accent-4">
                      <v-btn icon dark @click="generateAHSLokal(data.id_ahs_lokal)" :loading="load">
                        <v-icon>picture_as_pdf</v-icon> 
                      </v-btn>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>{{data.project}}</v-list-item-subtitle>
                    <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on">{{ data.name }}</v-list-item-title>
                          </template>
                          <span>{{ data.name }}</span>
                        </v-tooltip>
                      </v-layout>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content>

                  <v-list-item-content>
                      <v-list-item-subtitle style="text-color:white">.</v-list-item-subtitle>
                      <v-list-item-title align="right">Rp.</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-subtitle align="right">HSP</v-list-item-subtitle>
                      <v-layout>
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" align="right">{{ Number(data.HP_Adjust).toLocaleString('id-ID') }}</v-list-item-title>
                          </template>
                          <span>{{ Number(data.HP_Adjust).toLocaleString('id-ID') }}</span>
                        </v-tooltip>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                </v-list-item>
              </v-list>
              <div>
                <v-pagination
                  v-model="current_page_ahs_lokal"
                  class="my-4"
                  :length="total_pages_ahs_lokal"
                  prev-icon="arrow_left"
                  next-icon="arrow_right"
                  circle
                  @input="getPaginationAHSLokal"
                  :total-visible="5"
                  color="light-blue accent-4"
                  v-if="selectahs=='1'"
                >
                </v-pagination>
              </div>
              </v-card>
            </v-container>
          </v-col>
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
        </v-row>
      </v-app>
    </v-container>
  </v-app>
</template>
  

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
import Controller from './../service/Project'
import RAB from './../service/RAB'
import ahs from './../service/AHS'
import ahsLokal from './../service/AHSLokal'
import Http from '../service/Http'
import project from './../service/Project'
import materials from './../service/Material'

  export default {
    props: {
      source: String,
    },
    data: () => ({
      current_page_ahs: 1,
      current_page_ahs_lokal: 1,
      current_page_rab: 1,
      total_pages_rab: 0,
      total_pages_ahs: 0,
      total_pages_ahs_lokal: 0,

      dialog2: false,
      dialog3: false,
      snack: false,
      load: false,
      overlay: false,

      search:'',
      searchAHS:'',
      searchAHSLokal:'',
      rap:0,
      ppn:0,
      jasa:0,
      adjustment:0,
      select : null,
      selectahs:null,
      selectMR:1,

      countP:0,
      countM:0,
      countahs:0,
      countrab:0,

      materials:[],
      RAB:[],
      ahs:[],
      ahs_lokal:[],
      project:[],

      items:[
        {name:'Laporan RAB',value:null},
        {name:'Laporan RAP',value:'3'},
        {name:'Laporan BOQ',value:'1'},
        {name:'Laporan KB',value:'2'},
      ],
      itemsahs:[
        {name:'AHS Master',value:null},
        {name:'AHS Lokal',value:'1'}
      ],
      itemsMR:[
        {name:'Semua',value:1},
        {name:'Gedung',value:2},
        {name:'Lantai',value:3},
      ],
      //validaton
      rapRules:[
        v => !!v.rap || 'RAP harus diisi'
      ]
    }),
    mounted() {
      this.countRAB()    
      this.countAHS()
      this.countProject()
      this.countMaterials()  
      this.getPagination()
      this.getPaginationAHS()
      this.getPaginationAHSLokal()
    },
    computed: {
      ...mapState({
          loading: state => state.Token.loading,
          error: state => state.Token.error,
          token: state => state.Token.token,
        }),
      ...mapGetters({
          nama: 'LoggedUser/Name',
          jabatan: 'LoggedUser/Jabatan',
          divisi: 'LoggedUser/Divisi',
          akses:'LoggedUser/Akses',
      }),
    },
    methods: {
      Access(codeAccess){
        var x;
        for(x in this.akses.data){
            if (codeAccess.includes(this.akses.data[x].Fitur)) {
                return true
            } 
        }
        return false  
      },
      ...mapActions({
        destroyToken: 'Token/deleteToken',
      }),

      ...mapGetters({
        loggedIn: 'Token/loggedIn',
      }),

      save (props) {
        this.snack = true
        this.snackColor = 'green'
        this.snackText = 'Loading Data'
      },
      async countProject()
      {
        try{
          this.project = (await project.getallItem()).data
          this.countP = this.project.length
        }catch(err){
          console.log(err)
        }
      },
      async countMaterials()
      {
        try{
          this.materials = (await materials.getallItem()).data
          this.countM = this.materials.length
        }catch(err){
          console.log(err)
        }
      },
      async countRAB(){
        try{
          let rab = (await RAB.getall()).data
          this.countrab = rab.length
        }catch(err){
          console.log(err)
        }
      },
      async countAHS()
      {
        try{
          let AHS = (await ahs.getall()).data
          this.countahs = AHS.length
        }catch(err){
          console.log(err)
        }
      },
      async getPagination()
      {
        try{
          await RAB.pagination(this.current_page_rab).then(response => {
            this.current_page_rab = response.meta.pagination.current_page
            this.RAB = response.data
            this.total_pages_rab = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      async getPaginationAHS()
      {
        try{
          await ahs.getahswodetails(this.current_page_ahs).then(response => {
            this.current_page_ahs = response.meta.pagination.current_page
            console.log(this.current_page_ahs)
            this.ahs = response.data
            console.log(this.ahs)
            this.total_pages_ahs = response.meta.pagination.total_pages
            console.log(this.total_pages_ahs)
          })
        }catch(err){
          console.log(err)
        }
      },
      async getPaginationAHSLokal()
      {
        try{
            await ahsLokal.paginationnotnull(this.current_page_ahs_lokal).then(response =>{
            this.current_page_ahs_lokal = response.meta.pagination.current_page
            this.ahs_lokal = response.data
            this.total_pages_ahs_lokal = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      async logout() {
        await this.destroyToken()
        this.$router.push({ name : 'login' })
      },
      async generateAHS(id)
      {
        try{
          this.overlay = true
          Http.download('/api/ahs_master_report/'+id).then(() => {
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async generateAHSLokal(id)
      {
        try{
          this.overlay = true
          Http.download('/api/ahs_lokal_report/'+id).then(()=>{
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async generateRAB(id)
      {
        try{
          this.overlay = true
          Http.download('/api/rab_report/'+id+'/'+this.ppn+'/'+this.jasa).then(() => {
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async generaterabBQ(id)
      {
        try{
          this.overlay = true
          Http.download('/api/rab_bq_report/'+id).then(()=>{
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async generaterabMR(id)
      {
        try{
          this.overlay = true
          Http.download('/api/rab_mr_report/'+id+'/'+this.selectMR).then(()=>{
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async generaterabRAP(id)
      {
        try{
          this.overlay = true
          const rap = this.rap
          Http.download('/api/rab_rap_report/'+id+'/'+rap+'').then(()=>{
            this.overlay = false
          })
        }catch(err){
          this.overlay = false
          console.log(err)
        }
      },
      async searchAllAHS()
      {
        try{
          if(this.searchAHS=='')
            this.getPaginationAHS()
          else
          {
            await ahs.search(this.searchAHS).then(response=>{
              this.current_page_ahs = response.meta.pagination.current_page
              this.ahs = response.data
              this.total_pages_ahs = response.meta.pagination.total_pages
            })
          } 
        }catch(err){
          console.log(err)
        }
      },
      async searchAllAHSLokal()
      {
        try{
          if(this.searchAHSLokal=='')
            this.getPaginationAHSLokal()
          else
          {
            await ahsLokal.search(this.searchAHSLokal).then(response=>{
              this.current_page_ahs_lokal = response.meta.pagination.current_page
              this.ahs_lokal = response.data
              this.total_pages_ahs_lokal = response.meta.pagination.total_pages
            })
          } 
        }catch(err){
          console.log(err)
        }
      },
      async searchRAB()
      {
        try{
          if(this.search=='')
            this.getPagination()
          else
          {
            await RAB.search(this.search).then(response=>{
              this.current_page_rab = response.meta.pagination.current_page
              this.RAB = response.data
              this.total_pages_rab = response.meta.pagination.total_pages
            })
          } 
        }catch(err){
          console.log(err)
        }
      },
    }
  }
</script>

<style>
</style>
