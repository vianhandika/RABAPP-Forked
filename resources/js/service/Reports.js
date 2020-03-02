import Http from './Http'

export default {
    ahs(id){
        new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }
            const errorCallback = (err) => {
                reject(err)
            }
            Http.download('/api/analisa_task/'+id, successCallback, errorCallback)
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
            Http.download('/api/report_rab/'+id, successCallback, errorCallback)
        })
    }
}