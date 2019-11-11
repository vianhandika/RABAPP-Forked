<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      color="white"
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
              <v-icon>build</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Project</v-list-item-title>
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

      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="light-blue accent-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer">
        <v-icon>reorder</v-icon>
      </v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 100px"
      >
        VCP
      </v-toolbar-title>
      
      <!-- <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer> -->

       <!-- <div class="logout" >
          <v-btn @click="logoutHandler">
            <v-icon>logout</v-icon>
          </v-btn>
        </div> -->
    </v-app-bar>

    <v-content>
      <router-view></router-view>
    </v-content>
    
    <v-footer
      color="blue lighten-1"
      app
    >
      <span class="white--text">&copy; copyright 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
    methods: {
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
        this.$router.push({name: 'analisa'})
      }
    }
  }
</script>