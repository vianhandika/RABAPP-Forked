import axios from "axios"
import Http from '../../service/Http'
import Cookie from 'js-cookie'
import Store from '../../store'


const state = {
    token : localStorage.getItem('access_token') ||  null,
    Id_Akun : localStorage.getItem('Id_Akun') ||  null,
    loading: true,
    error: null
}

const mutations = {
    retrieveToken(state, token){
        state.token = token
    }, 

    destroyToken(state){
        state.token = null
    }
}

const getters = {
    loggedIn(state){
        return state.token != null
    }
}

const actions = {
    async retrieveToken(context, credentials){
        // return new Promise((resolve, reject) => {
        //     axios.post('/api/authenticate',{
        //         username   : credentials.username,
        //         password   : credentials.password,
        //     })
        //     .then(response => {
        //         console.log(response.data)
        //         const token = response.data.access_token
        //         localStorage.setItem('access_token', token)
        //         // Store.commit('LoggedUser/setLoggedUser', await this.loggedUser(response.data.Id_Akun))
        //         resolve(response)
        //     })
        //     .catch(error => {
        //         console.log(error)
        //         // alert('Username atau Password salah')
        //         reject(error)
        //     })
        // })
        try {
            const res = await Http.post('/api/authenticate', {
                username   : credentials.username,
                password   : credentials.password,
            })
            const token = res.data.access_token
            localStorage.setItem('access_token', token)
            localStorage.setItem('Id_Akun', res.data.Id_Akun)

            // console.log(res.data)
            // Store.commit('LoggedUser/setLoggedUser', await loggedUser(res.data.Id_Akun))
            const res2 = await Http.get('http://localhost:8000/api/akun/'+res.data.Id_Akun)
            // const res2 = await Http.get('http://vcp-qs.ip-dynamic.com/api/akun/'+res.data.Id_Akun)
            console.log(res2.data.data)
            // const res2 = await axios.get('http://vcp-qs.ip-dynamic.com/api/akun/'+res.data.Id_Akun, {
            //     headers: {
            //       'Access-Control-Allow-Origin': '*',
            //     }
            // })


            Store.commit('LoggedUser/setLoggedUser', res2.data.data)
            
            return res
            
          } catch (err) {
            // throw new Error('username / password salah')
            throw err
          }
    },

    async loggedUser (Id_Akun) {
        try {
          console.log(Id_Akun)
          const res = await Http.get('http://localhost:8000/api/akun/'+Id_Akun)
        //   const res = await Http.get('http://vcp-qs.ip-dynamic.com/api/akun/'+Id_Akun)
        
          console.log(res)
          Store.commit('LoggedUser/setLoggedUser', res2.data.data)
        
        } catch (err) {
        //   if (err.response.status === 401) {
        //     routes.push({ name: 'Login' })
        //   } else {
        //     throw new Error('Failed fetch authenticated user')
        //   }
        }
      },

    async deleteToken(context){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token')

        if(localStorage.getItem('access_token')){
            return new Promise((resolve, reject) => {
                // axios.post('/api/logout')
                // .then(response => {
                    localStorage.removeItem('access_token')
                    context.commit('destroyToken')
                    resolve()
                // })
                .catch(error => {
                    console.log(error)
                    context.commit('destroyToken')
                    reject(error)
                })
            })
        }
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }