import Http from './Http'

export default {
    ahs(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.download('/api/ahs_master_report/'+id, successCallback, errorCallback)
        })
    },
    ahs_lokal(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.download('/api/ahs_lokal_report/'+id, successCallback, errorCallback)
        })
    },
    rab(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.download('/api/rab_report/'+id, successCallback, errorCallback)
        })
    },
    rab_bq(id){
        return new Promise((resolve,reject)=>{
            const successCallback = (res) =>{
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) =>{
                reject(err)
            }
            Http.download('/api/rab_report_bq/'+id,successCallback,errorCallback)
        })
    }
}