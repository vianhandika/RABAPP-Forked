import Http from '../http'

export default {
    getDetails(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/ahs_lokal_details', successCallback, errorCallback)
        })
    },
    deleteItem(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.delete('/api/ahs_lokal_details/delete/'+id, successCallback, errorCallback)
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
            Http.get('/api/ahs_lokal_details/show/'+id, successCallback, errorCallback)
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
            Http.patch('/api/ahs_lokal_details/update/'+id, payload, successCallback, errorCallback)
        })
    },
}
