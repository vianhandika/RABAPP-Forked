<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      dark
      color="cyan"
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
      <router-view></router-view>
    </v-content>
    
    <!-- <v-footer
      color="light-blue"
      app
    >
      <span class="white--text">&copy; copyright 2019</span>
    </v-footer> -->
  </v-app>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'

  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
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
      reports(){
        this.$router.push({name : 'reports'})
      }
    }
  }
</script>