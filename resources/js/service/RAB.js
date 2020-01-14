import Http from '../http'

export default {
    getTaskSub(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/task_sub', successCallback, errorCallback)
        })
    },
    getGroup(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/groups', successCallback, errorCallback)
        })
    },
    getallDetails(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/rab_details', successCallback, errorCallback)
        })
    },
    getallItem(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.get('/api/rabs', successCallback, errorCallback)
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
            Http.post('/api/rabs/store', payload, successCallback, errorCallback)
        })
    },
    addTaskSub(payload) {
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.post('/api/task_sub/store', payload, successCallback, errorCallback)
        })
    },
    addGroup(payload) {
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.post('/api/groups/store', payload, successCallback, errorCallback)
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

            Http.patch('/api/rabs/update/'+id, payload, successCallback, errorCallback)
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
            Http.delete('/api/rabs/delete/'+id, successCallback, errorCallback)
        })
    },
    deleteDetail(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.delete('/api/rab_details/delete/'+id, successCallback, errorCallback)
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

            Http.patch('/api/rab_details/update/'+id, payload, successCallback, errorCallback)
        })
    },
}
