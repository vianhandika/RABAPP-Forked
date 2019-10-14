<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      color="white"
    >
      <v-list dense>
        <v-list-item @click="">
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
              <v-icon>label</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Job</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>home</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Materials</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>payment</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Transaction</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="">
          <v-list-item-action>
            <v-btn icon>
              <v-icon>settings</v-icon>
            </v-btn>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Settings</v-list-item-title>
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
      <v-toolbar-title>VCP</v-toolbar-title>
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
        }
    }
  }
</script>