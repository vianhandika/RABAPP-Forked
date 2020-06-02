import Http from '../http'

export default {
    getKode(){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.get('/api/stores/code/',successCallback, errorCallback)
        })
    },
    // getItem(){
    //     return new Promise((resolve, reject) => {
    //         const successCallback = (res) => {
    //             const data = res.data
    //             resolve(data)
    //         }

    //         const errorCallback = (err) => {
    //             reject(err)
    //         }

    //         Http.get('/api/stores/show/'+id, payload, successCallback, errorCallback)
    //     })
    // },
    getallItem(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/stores', successCallback, errorCallback)
        })
    },
    addItem(payload) {
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.post('/api/stores/store', payload, successCallback, errorCallback)
        })
    },
    updateItem(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
            }

            Http.patch('/api/stores/update/'+id, payload, successCallback, errorCallback)
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
            Http.delete('/api/stores/delete/'+id, successCallback, errorCallback)
        })
    }
}
