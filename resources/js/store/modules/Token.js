import axios from "axios"
import Http from '../../service/Http'
import Cookie from 'js-cookie'
import Store from '../modules'

const state = {
    token : localStorage.getItem('access_token') ||  null,
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
        return new Promise((resolve, reject) => {
            axios.post('/api/authenticate',{
                username   : credentials.username,
                password   : credentials.password,
            })
            .then(response => {
                console.log(response.data)
                const token = response.data.access_token
                localStorage.setItem('access_token', token)
                resolve(response)
            })
            .catch(error => {
                console.log(error)
                // alert('Username atau Password salah')
                reject(error)
            })
        })
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