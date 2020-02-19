import Http from './Http'

export default {
    reports(id){
        return new Promise((resolve, reject) => {
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
}