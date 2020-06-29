<template>
  <v-app id="inspire">
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="light-blue accent-3"
                dark
                flat
              >
                <v-toolbar-title>Login</v-toolbar-title>
                <div class="flex-grow-1"></div>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    v-model="username"
                    label="nama pengguna"
                    name="username"
                    prepend-inner-icon="people"
                    type="text"
                    color="blue"
                    :rules="usernameRules"
                    @keyup.enter="login"
                  ></v-text-field>

                  <v-text-field
                    v-model="password"
                    id="password"
                    label="kata sandi"
                    name="kata sandi"
                    prepend-inner-icon="lock"
                    type="password"
                    color="blue"
                    :rules="passwordRules"
                    @keyup.enter="login"
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn 
                  color="light-blue accent-2"
                  @click="login"
                  rounded
                  :loading="load"
                >
                Login
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
        <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
          <v-icon dark>warning</v-icon>
          {{ snackText }}
        </v-snackbar>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'

  export default {
    name: 'LoginComponent',
    data () {
      return{
        username:'',
        password: '',
        load: false,
        snack: false,
        snackColor: '',
        snackText: '',
        y: 'top',
        //validation
        usernameRules:[
          v => !!v || 'Username is required'
        ],
        passwordRules:[
          v => !!v || 'Password is required'
        ]
      }
    },
    props: {
      source: String,
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
        retrieveToken: 'Token/retrieveToken',
        authenticate: 'Token/authenticate'
      }),
      async login(){
        try {
          const data = {
            username : this.username,
            password : this.password,
          }
          this.load = true
          await this.retrieveToken(data)
          .then(response=>{
            this.load = false
            this.$router.push({name: 'dashboard'})
          })
        } catch (err) {
          this.load = false
          console.log(err)
          this.snackbar()
        }
      },
      snackbar()
      {
        this.snack = true
        this.snackColor = 'red'
        this.snackText = "Incorrect username or password"
      },
    },
  }
</script>

<style>
</style>