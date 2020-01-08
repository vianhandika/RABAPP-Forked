
const state = {
    isLoggedIn: !!localStorage.getItem('access_token')
}
const mutations = {
    loginUser (state) {
        state.isLoggedIn = true
    },
    logoutUser (state) {
        state.isLoggedIn = false
    }
}
