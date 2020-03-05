<template>
  <v-app class="blue lighten-4">
    <v-container>
      <v-layout row="ma-4"></v-layout>
      <v-app style="background-color: grey lighten-2" class="elevation-8">
        <v-container>
          <v-layout row wrap>
            <v-flex sm6 xs12 md6 lg3>
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
                    <div class="overline text-right">Project</div>
                    <v-list-item-title class="headline mb-1 text-right" v-model="countP">{{countP}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
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
                    <div class="overline text-right">Materials/Labor</div>
                    <v-list-item-title class="headline mb-1 text-right" v-model="countM">{{countM}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
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
                    <div class="overline text-right">AHS</div>
                    <v-list-item-title class="headline mb-1 text-right" v-model="countAHS">{{countAHS}}</v-list-item-title>
                    <div><v-divider></v-divider></div>
                  </v-list-item-content> 
                </v-list-item>

                <v-card-actions>
                  <v-icon text class="ma-2">house</v-icon>
                  <div class="overline">Vastu Cipta Persada</div>
                </v-card-actions>
              </v-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
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
                    <v-list-item-title class="headline mb-1 text-right" v-model="countRAB">{{countRAB}}</v-list-item-title>
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
        <v-col class="body-2 grey--text"><h1>Reports</h1></v-col>
        <v-row>
          <v-col cols="12" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="4" align-center>
                    <v-card-title class="headline green darken-1--text">RAB</v-card-title>
                  </v-col>
                  
                  <v-col cols="7">
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label="Search"
                      single-line
                      hide details    
                      color="green darken-3"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>

                <v-list>
                  <v-list-item v-for="data in filtered" :key="data.id_rab">
                    <v-list-item-avatar color="green darken-3">
                      <v-icon dark @click="generateRAB(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-list-item-title>{{data.project}}</v-list-item-title>
                        <!-- <v-list-item-title style="margin-left:120px">Rp.</v-list-item-title> -->
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
                        <v-list-item-title align="right">{{ Number(data.total_rab).toLocaleString('id-ID') }}</v-list-item-title>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
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
                  color="green darken-3"
                >
                </v-pagination>
              </div>
            </v-container>
          </v-col>

          <v-col cols="12" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="4" align-center>
                    <v-card-title class="headline green darken-3--text">BQ RAB</v-card-title>
                  </v-col>
                  
                  <v-col cols="7">
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label="Search"
                      single-line
                      hide details    
                      color="green"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>

                <v-list>
                  <v-list-item v-for="data in filtered" :key="data.id_rab">
                    <v-list-item-avatar color="green">
                      <v-icon dark @click="generateRAB(data.id_rab)">picture_as_pdf</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-layout>
                        <v-list-item-title>{{data.project}}</v-list-item-title>
                        <!-- <v-list-item-title style="margin-left:120px">Rp.</v-list-item-title> -->
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
                        <v-list-item-title align="right">{{ Number(data.total_rab).toLocaleString('id-ID') }}</v-list-item-title>
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
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
                  color="green"
                >
                </v-pagination>
              </div>
            </v-container>
          </v-col>
          
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="4" align-center>
                    <v-card-title class="headline blue darken-3--text">AHS</v-card-title>
                  </v-col>
                  
                  <v-col cols="7">
                    <v-text-field
                      v-model="searchAHS"
                      append-icon="search"
                      label="Search"
                      single-line
                      hide details    
                      color="blue darken-3"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>

                <v-list>
                  <v-list-item v-for="data in filteredAHS" :key="data.id_ahs">
                    <v-list-item-avatar color="blue darken-3">
                        <v-btn icon dark @click="generateAHS(data.id_ahs)" :loading="loading">
                          <v-icon>picture_as_pdf</v-icon> 
                        </v-btn>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-list-item-title>{{data.name}}</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content align="right">
                      <v-list-item-subtitle>HSP</v-list-item-subtitle>
                      <v-layout>
                        <v-list-item-title style="padding-left:30px">Rp.</v-list-item-title>
                        <v-list-item-title align="right">{{ Number(data.total).toLocaleString('id-ID')}}</v-list-item-title>  
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>                    
                  </v-list-item>
                </v-list>
              </v-card>
            </v-container>
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
              >
              </v-pagination>
            </div>
          </v-col>
          <v-col cols="12" md="6">
            <v-container>
              <v-card>
                <v-row>
                  <v-col cols="4" align-center>
                    <v-card-title class="headline blue darken-1--text" dark>AHS Lokal</v-card-title>
                  </v-col>
                  
                  <v-col cols="7">
                    <v-text-field
                      v-model="searchAHS"
                      append-icon="search"
                      label="Search"
                      single-line
                      hide details    
                      color="blue"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>

                <v-list>
                  <v-list-item v-for="data in filteredAHS" :key="data.id_ahs">
                    <v-list-item-avatar color="blue">
                        <v-btn icon dark @click="generateAHS(data.id_ahs)" :loading="loading">
                          <v-icon>picture_as_pdf</v-icon> 
                        </v-btn>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>{{data.kode}}</v-list-item-subtitle>
                      <v-list-item-title>{{data.name}}</v-list-item-title>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>
                    <v-list-item-content align="right">
                      <v-list-item-subtitle>HSP</v-list-item-subtitle>
                      <v-layout>
                        <v-list-item-title style="padding-left:30px">Rp.</v-list-item-title>
                        <v-list-item-title align="right">{{ Number(data.total).toLocaleString('id-ID')}}</v-list-item-title>  
                      </v-layout>
                      <div><v-divider></v-divider></div>
                    </v-list-item-content>                    
                  </v-list-item>
                </v-list>
              </v-card>
            </v-container>
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
              >
              </v-pagination>
            </div>
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
import report from './../service/Reports'
import Http from '../service/Http'
import project from './../service/Project'
import materials from './../service/Material'

  export default {
    props: {
      source: String,
    },
    data: () => ({
      current_page: 1,
      total_pages: 0,
      current_page_ahs: 1,
      total_pages_ahs: 0,

      dialog2: false,
      dialog3: false,
      snack: false,
      loading: false,
      overlay: false,

      search:'',
      searchAHS:'',
      countP:0,
      countM:0,
      countAHS:0,
      countRAB:0,

      materials:[],
      RAB:[],
      ahs:[],
      project:[],

      panels:[
        {icon: 'home_work',title:'Project',count:'countP',color:'green',footer:'house',text:'Vastu Cipta Persada'},
        {icon: 'waves',title:'Materials/Labor',count:'materials',color:'#0091EA',footer:'house',text:'Vastu Cipta Persada'},
        {icon: 'money',title:'AHS',count:'ahs',footer:'house',color:'#00B8D4',text:'Vastu Cipta Persada'},
        {icon: 'payment',title:'Total RAB',count:'rab',footer:'house',color:'#00BFA5',text:'Vastu Cipta Persada'},
      ],
    }),
    mounted() {
      this.getRAB()    
      this.getAHS()  
      this.getPagination()
      this.getPaginationAHS()
      this.countProject()
      this.countMaterials()
    },
    computed: {
      ...mapState({
          loading: state => state.Token.loading,
          error: state => state.Token.error,
          token: state => state.Token.token,
        }),
      filtered:function(){
        return this.RAB.filter((data)=>{
          return data.project.match(this.search);
        });
      },
      filteredAHS:function(){
        return this.ahs.filter((data)=>{
          return data.name.match(this.searchAHS)
        })
      }
    },
    methods: {
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

      async getPagination()
      {
        try{
            await RAB.pagination(this.current_page).then(response => {
            this.current_page = response.meta.pagination.current_page
            this.RAB = response.data
            this.total_pages = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      async getPaginationAHS()
      {
        try{
            await ahs.get(this.current_page_ahs).then(response => {
            this.current_page_ahs = response.meta.pagination.current_page
            this.ahs = response.data
            this.total_pages_ahs = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      async logout() {
        await this.destroyToken()
        this.$router.push({ name : 'login' })
      },
      async getRAB(){
        try{
          this.RAB = (await RAB.getallItem()).data
          this.countRAB = this.RAB.length
        }catch(err){
          console.log(err)
        }
      },
      async getAHS()
      {
        try{
          this.ahs = (await ahs.getallItem()).data
          this.countAHS = this.ahs.length
        }catch(err){
          console.log(err)
        }
      },
      async generateAHS(id)
      {
        this.overlay = true
        Http.download('/api/analisa_task/'+id).then(() => {
          this.overlay = false
        })
        // try{
        //   await report.ahs(id).then(()=>{
        //     this.overlay = false
        //   })
        // }catch(err){
        //   console.log(err)
        // }
      },
      async generateRAB(id)
      {
        this.overlay = true
        Http.download('/api/report_rab/'+id).then(() => {
          this.overlay = false
        })
      }
    }
  }
</script>

<style>
.border{
  border-left: 4px solid rgb(4, 110, 180);
}
.rounded{
  border-radius: 30px
}
</style>