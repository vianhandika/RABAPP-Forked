import Http from '../http'

export default {
    deleteItem(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.delete('/api/ahs_adjust_details/delete/'+id, successCallback, errorCallback)
        })
    },
    getItem(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/ahs_adjust_details/show/'+id, successCallback, errorCallback)
        })
    },
    updateDetail(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.patch('/api/ahs_adjust_details/update/'+id, payload, successCallback, errorCallback)
        })
    },
}
