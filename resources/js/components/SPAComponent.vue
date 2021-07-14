<template>
  <v-app>
    <v-navigation-drawer 
      v-model="drawer"
      app
      dark
      color="blue darken-2"
    >
      <v-list dense>
        <v-list-item v-for="link in links" :key="link.title" router :to="link.route" v-bind:class="{'visible':Access(link.access)==false}"  active-class="border">
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
      <v-toolbar-title>Beranda</v-toolbar-title>

      <!-- <v-flex class="padding">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-icon dark v-on="on">account_circle</v-icon>
          </template>
          <span>Profile</span>
        </v-tooltip>
      </v-flex> -->
      
      <v-flex class="padding">
        <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-icon dark v-on="on" @click="dialog=true">power_settings_new</v-icon>
        </template>
        <span>Log Out</span>
      </v-tooltip>
      </v-flex>
    </v-app-bar>
    <v-content>
      <router-view></router-view>
    </v-content>

    <template>
      <v-dialog v-model="dialog" max-width="290px">
        <v-card>
          <v-card-title class="headline">Konfirmasi</v-card-title>
            <v-card-text>Anda yakin ingin keluar dari sistem?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog = false; logout()">Ya</v-btn>
            <v-btn color="red darken-1" text @click="dialog = false">Tidak</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </template>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
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
      dialog:false,
      overlay:false,
      links : [
<<<<<<< Updated upstream
        {icon: 'dashboard', title: 'Beranda', route: '/dashboard'},
        {icon: 'post_add', title: 'Detail Referensi', route: '/reference'},
        {icon: 'home_work', title: 'Proyek', route: '/project'},
        {icon: 'store', title: 'Toko', route: '/store'},
        {icon: 'work', title: 'Pekerjaan', route: '/task'},
        {icon: 'waves', title: 'Bahan/Tenaga Kerja', route: '/materials'},
        {icon: 'money', title: 'AHS Master', route: '/analisa'},
        {icon: 'payment', title: 'RAB', route: '/rab'},
        {icon: 'trending_up', title: 'AHS Lokal', route: '/analisa_lokal'},
        {icon: 'account_balance_wallet', title: 'Kalkulator', route: '/calculate'},
=======
        {icon: 'dashboard', title: 'Beranda', route: '/dashboard',
          access:[
              'Panel',
              'R-Dashboard-R'
          ]
        },
        {icon: 'post_add', title: 'Detail Referensi', route: '/reference',
          access:[
            'R-DetailReferensi-C',
            'R-DetailReferensi-R',
            'R-DetailReferensi-U',
            'R-DetailReferensi-D',
          ]
        },
        {icon: 'home_work', title: 'Proyek', route: '/project',
          access:[
            'R-Proyek-C',
            'R-Proyek-R',
            'R-Proyek-U',
            'R-Proyek-D',
          ]
        },
        {icon: 'store', title: 'Toko', route: '/store',
          access:[
            'R-Toko-C',
            'R-Toko-R',
            'R-Toko-U',
            'R-Toko-D',
          ]
        },
        {icon: 'work', title: 'Pekerjaan', route: '/task',
          access:[
            'R-Pekerjaan-C',
            'R-Pekerjaan-R',
            'R-Pekerjaan-U',
            'R-Pekerjaan-D',
          ]
        },
        {icon: 'waves', title: 'Bahan/Tenaga Kerja', route: '/materials',
          access:[
            'R-BahanTenagaKerja-C',
            'R-BahanTenagaKerja-R',
            'R-BahanTenagaKerja-U',
            'R-BahanTenagaKerja-D',
          ]
        },
        {icon: 'money', title: 'AHS Master', route: '/analisa',
           access:[
            'R-AHSMaster-C',
            'R-AHSMaster-R',
            'R-AHSMaster-U',
            'R-AHSMaster-D',
          ]
        },
        {icon: 'payment', title: 'RAB', route: '/rab',
          access:[
            'R-RAB-C',
            'R-RAB-R',
            'R-RAB-U',
            'R-RAB-D',
          ]
        },
        {icon: 'trending_up', title: 'AHS Lokal', route: '/analisa_lokal',
           access:[
            'R-AHSLokal-C',
            'R-AHSLokal-R',
            'R-AHSLokal-U',
            'R-AHSLokal-D',
          ]
        },
        {icon: 'account_balance_wallet', title: 'Kalkulator', route: '/calculate',
          access:[
            'R-Kalkulator-R',
          ]
        },
>>>>>>> Stashed changes
      ],
      rab : [
        {icon: 'home',title: 'Building', route:''},
        {icon: 'group_work',title: 'Floor', route:''},
        {icon: 'work',title: 'Task Group', route:''},
      ]
    }),
    computed: {
      ...mapState({
          loading: state => state.Token.loading,
          error: state => state.Token.error,
          token: state => state.Token.token,
      }),
      ...mapGetters({
          // id: 'LoggedUser/id',
          nama: 'LoggedUser/Name',
          jabatan: 'LoggedUser/Jabatan',
          divisi: 'LoggedUser/Divisi',
          akses:'LoggedUser/Akses',

          username: 'LoggedUser/Username',
          // role: 'LoggedUser/role'
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
        this.overlay = true
        await this.destroyToken()
        this.$router.push({ name : 'login' })
      },
      Access(codeAccess){
            // console.log(this.akses)
            // console.log(Akses)

            var x;
            if(codeAccess.includes("Panel")){
                // console.log("TRUE Panel")
                return true
            }
            else{
                for(x in this.akses.data){
                    if (codeAccess.includes(this.akses.data[x].Fitur)) {
                        console.log(this.akses.data[x].Fitur," TRUE AKSES")

                        return true
                    } 
                }
                console.log("FALSE AKSES")

                return false
            }
        }
    }
  }
</script>

<style>
.border{
  border-left: 4px solid rgb(4, 110, 180);
}
.padding{
  padding-left: 82%
}
.visible{
    display: none !Important;
}
</style>
