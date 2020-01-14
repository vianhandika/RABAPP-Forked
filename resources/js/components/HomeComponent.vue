<template>
    <div class="team">
    <h1 class="subheading grey--text">Dashboard</h1>
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
                <div class="overline text-right">Total RAB</div>
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
                <v-icon dark large>money</v-icon>
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

        </v-layout>
    </v-container>
    </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
import Controller from './../service/Project'

  export default {
    counter:[],
    store:[],
    rab:[],
    counter_rab:[],
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
    mounted() {
      this.counter()
      this.counter_store()
      this.counter_rab()
      this.total()
    },
    computed: {
     
    },
    methods: {
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