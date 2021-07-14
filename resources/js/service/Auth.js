import Http from './Http'
import Store from '../store'
import Cookie from 'js-cookie'
import { routes } from '../routes'

export default {
  // async authenticate ({ username, password }) {
  //   try {
  //     const res = await Http.post('/api/authenticate', {
  //       username,
  //       password
  //     })

  //     const accessToken = {
  //       username: res.data.data.Username,
  //       password: res.data.data.Password
  //     }
  //     // console.log(accessToken)
  //     Http.setHeader(accessToken)
  //     // console.log("2")

  //     Cookie.set('accessToken', accessToken)
  //     // console.log("3")


  //     Store.commit('LoggedUser/setLoggedUser', await this.token())
  //     // console.log("4")

  //   } catch (err) {
  //     throw new Error('username / password salah')
  //   }
  // },

  // async token () {
  //   try {
  //     const res = await Http.get('/api/token')
  //     console.log(res)

  //     return res.data.data
  //   } catch (err) {
  //     if (err.response.status === 401) {
  //       routes.push({ name: 'Login' })
  //     } else {
  //       throw new Error('Failed fetch authenticated user')
  //     }
  //   }
  // },

  // async refresh () {
  //   const accessToken = Cookie.get('accessToken')

  //   if (typeof accessToken === 'undefined') {
  //     throw new Error('Access token not exist')
  //   }

  //   Http.setHeader(JSON.parse(accessToken))
  //   Store.commit('LoggedUser/setLoggedUser', await this.token())
  //   // console.log("refresh?")

  // },

  // logout () {
  //   Store.commit('LoggedUser/setLoggedUser', {})
  //   Store.commit('LoggedUser/loggedOut')
  //   Cookie.remove('accessToken')
  // },

  // getToken () {
  //   // console.log("getToken?")
  //   return typeof Cookie.get('accessToken') !== 'undefined'
  // }

  async loggedUser (Id_Akun) {
    try {
      console.log(Id_Akun)
      const res = await Http.get('http://localhost:8000/api/akun/'+Id_Akun)
      // const res = await Http.get('http://vcp-qs.ip-dynamic.com/api/akun/'+Id_Akun)
      
      console.log(res)
      Store.commit('LoggedUser/setLoggedUser', res.data.data)
    
    } catch (err) {
    //   if (err.response.status === 401) {
    //     routes.push({ name: 'Login' })
    //   } else {
    //     throw new Error('Failed fetch authenticated user')
    //   }
    }
  },
}