<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar dark color="light-blue accent-3">
        <v-toolbar-title>Calculate AHS</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>

          <v-text-field
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          >
          </v-text-field>
        </v-toolbar>
      <v-card>
        <template>
          <v-container>
            <v-row>
              <v-col cols="12" sm="1">
                <v-text-field
                  label="RAP (%)"
                  v-model="rap"
                  type="number"
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="1">
                <v-text-field
                  label="Volume"
                  v-model="volume_new"
                  readonly
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="1">
                <v-text-field
                  label="Total of Labor"
                  v-model="labor"
                  readonly
                > 
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="1">
                <v-text-field
                  label="Total of Materials"
                  v-model="material"
                  readonly
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="2">
                <v-text-field
                  label="HSP"
                  v-model="hsp"
                  readonly
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="2">
                <v-text-field
                  label="HP"
                  v-model="hp"
                  readonly
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="2">
                <v-text-field
                  label="HP Adjust"
                  v-model="hp_adjust"
                  readonly
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" sm="1">
                <v-btn 
                  rounded 
                  color="blue darken-3" 
                  dark 
                  elevation="3" 
                  small
                  @click="add"
                  style="margin-top:18px"
                  >Check</v-btn>
              </v-col>
              <v-col>
                <v-btn
                  dark
                  color="green darken-3"
                  elevation="3"
                  small
                  rounded
                  @click="reset"
                  style="margin-top:18px"
                >Done
                </v-btn>
              </v-col>
            </v-row>
            <div>
              <v-data-table
                :headers="headers"
                sortBy="status"
                update: sort-desc
                class="elevation-10"
                :items="filtered"
              >
              <template v-slot:item.HP="{ item }">
                <v-layout>
                  {{ 'Rp. '}}
                  <v-spacer></v-spacer>
                  {{ Number(item.HP).toLocaleString('id-ID') }}
                </v-layout>
              </template>

              <template v-slot:item.HP_Adjust="{ item }">
                <v-layout>
                  {{ 'Rp. '}}
                  <v-spacer></v-spacer>
                  {{ Number(item.HP_Adjust).toLocaleString('id-ID') }}
                </v-layout>
              </template>

              <template v-slot:item.HSP="{ item }">
                <v-layout>
                  {{ 'Rp. '}}
                  <v-spacer></v-spacer>
                  {{ Number(item.HSP).toLocaleString('id-ID') }}
                </v-layout>
              </template>

              <template v-slot:item.action="{ item }">
                <v-icon
                  small
                  color="green"
                  @click="itemHandler(item)"
                >
                  add_circle
                </v-icon>
              </template>
              </v-data-table>
            </div>
          </v-container>
        </template>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import rabDetails from './../service/AHSLokal'
import job from './../service/Job'

  export default {
    data: () => ({
      search:'',
      
      id_job:'',
      rap:0,
      volume_new:0,
      labor: 0,
      material: 0,
      hsp: 0,
      hp:0,
      hp_adjust:0,
      adjust:0,
      
      ahs: [],
      job:[],

      AHS:{
        kode:'',
        id_ahs_lokal:'',
        id_project: '',
        id_job: '',
        id_sub:'', 
        volume:0,
        adjustment:0,
        total_labor: 0,
        total_material: 0,
        HSP: 0,
        HP:'',
        HP_Adjust:''
      },
      AHSDefault:{
        kode:'',
        id_ahs_lokal:'',
        id_project: '',
        id_job: '',
        id_sub:'', 
        volume:0,
        adjustment:0,
        total_labor: 0,
        total_material: 0,
        HSP: 0,
        HP:'',
        HP_Adjust:''
      },
      headers: [
        {text: 'ID', align: 'left', sortable: false, value: 'id_rab', width: '10%'},
        {text: 'Project', align: 'left', sortable: false, value: 'project',},
        {text: 'Task Group', align: 'left', sortable: false, value: 'name_sub',},
        {text: 'Task', align: 'left', sortable: false, value: 'name', width: '10%'},
        // {text: 'Total of Labor', align: 'left', sortable: false, value: 'total_labor'},
        // {text: 'Total of Materials', align: 'left', sortable: false, value: 'total_material'},
        {text: 'HSP', align: 'left', sortable: false, value: 'HSP', width: '10%'},
        {text: 'Volume', align: 'left', sortable: false, value: 'volume'},
        {text: 'Adjust', align: 'left', sortable: false, value: 'adjustment'},
        {text: 'HP', align: 'left', sortable: false, value: 'HP', width: '15p%'},
        {text: 'HP Adjust', align: 'left', sortable: false, value: 'HP_Adjust', width: '1%'},
        {text: 'Actions', align: 'left', sortable: false, value: 'action'},
      ],
    }),
    mounted(){
      this.getallAHS()
      this.getJob()
    },
    computed: {
      filtered:function(){
        return this.ahs.filter((data)=>{
            if(this.search == '')
              return data
            else{
              return (data.name.match(this.search) || 
                data.project.match(this.search)) 
            }
        });
      }
    },
    methods: {
      itemHandler(data)
      {
        this.id_job = data.id_job
        this.volume_new = data.volume
        this.adjust = data.adjustment
        this.labor = data.total_labor
        this.material = data.total_material
        this.hsp = data.HSP
        this.hp = data.HP
        this.hp_adjust = data.HP_Adjust
      },
      update(){
        this.snack = true
        this.snackColor = 'teal darken-1'
        this.snackText = 'Data Update Successfully'
      },
      delete(){
        this.snack = true
        this.snackColor = 'red darken-1'
        this.snackText = 'Data Delete Successfully'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
      },
      async getallAHS()
      {
        try{
          this.ahs = (await rabDetails.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getJob()
      {
        try{
          this.job = (await job.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      add()
      {
        let volume
        let labor=0
        let material=0
        let hsp=0
        let hp
        let hp_adjust
        let job = this.job.find(obj=>obj.id_job == this.id_job)
        if(job.status == "Volume")
        {
          volume = (this.rap/100)*this.volume_new
          hp = this.hsp * volume
          hp_adjust = this.hsp * volume * this.adjust
        }else{
          volume = this.volume_new
          material = (this.rap/100)*this.material
          labor = (this.rap/100)*this.labor
          hsp = (this.rap/100)*this.hsp
          hp = hsp * volume
          hp_adjust = hsp * volume * this.adjust
        }
        this.volume_new = volume
        this.labor = parseFloat(this.labor-labor,2)
        this.material = parseFloat(this.material-material,2)
        this.hsp = parseFloat(this.hsp-hsp,2)
        this.hp = parseFloat(this.hp-hp,2)
        this.hp_adjust = parseFloat(this.hp_adjust-hp_adjust,2)
      },
      reset()
      {
        this.rap = 0
        this.volume_new = 0
        this.adjust = 0
        this.hsp = 0
        this.hp_adjust = 0 
        this.hp = 0
        this.labor = 0
        this.material = 0
      }
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
.borderAhsLokal{
  border-left: 4px solid #40C4FF
}
</style>