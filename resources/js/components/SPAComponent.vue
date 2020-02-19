<template>
  <v-app>
    <v-navigation-drawer 
      v-model="drawer"
      app
      dark
      color="blue darken-2"
    >
    <v-layout column align-center>
      <v-flex class="mt-8 mb-6">
        <v-avatar dark width="100px">
          <!-- <v-icon>home_work</v-icon> -->
          <!-- <v-text>Vastu Cipta Persada</v-text> -->
        </v-avatar>
      </v-flex>
    </v-layout>
      <v-list dense>
        <v-list-item v-for="link in links" :key="link.title" router :to="link.route" active-class="border">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>{{link.icon}}</v-icon>
            </v-btn>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{link.title}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    
    <v-app-bar
      app
      color="blue accent-2"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer= !drawer">
        <v-icon>reorder</v-icon>
      </v-app-bar-nav-icon>
      <v-toolbar-title>Dashboard</v-toolbar-title>

      <v-flex class="padding">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-icon dark v-on="on">account_circle</v-icon>
          </template>
          <span>Profile</span>
        </v-tooltip>
      </v-flex>
      
      <v-flex>
        <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-icon dark v-on="on" @click="logout">power_settings_new</v-icon>
        </template>
        <span>Log Out</span>
      </v-tooltip>
      </v-flex>
    </v-app-bar>

    <v-content>
      <router-view></router-view>
    </v-content>
  </v-app>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
import Structure from '../service/Structure'

  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      expand: false,
      links : [
        {icon: 'dashboard', title: 'Dashboard', route: '/dashboard'},
        {icon: 'home_work', title: 'Project', route: '/project'},
        {icon: 'store', title: 'Store', route: '/store'},
        {icon: 'work', title: 'Task', route: '/job'},
        {icon: 'waves', title: 'Materials/Labor', route: '/materials'},
        {icon: 'money', title: 'AHS', route: '/analisa'},
        {icon: 'trending_up', title: 'AHS Lokal', route: '/analisa_lokal'},
        {icon: 'payment', title: 'RAB', route: '/rab'},
      ],
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
      
    }
  }
</script>

<style>
.border{
  border-left: 4px solid rgb(4, 110, 180);
}
.padding{
  padding-left: 77%
}
</style>