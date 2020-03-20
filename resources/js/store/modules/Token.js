import axios from "axios"

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
            axios.post('/api/auth/login',{
                email       : credentials.email,
                password    : credentials.password,
            })
            .then(response => {
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
                axios.post('/api/auth/logout')
                .then(response => {
                    localStorage.removeItem('access_token')
                    context.commit('destroyToken')
                    resolve(response)
                })
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