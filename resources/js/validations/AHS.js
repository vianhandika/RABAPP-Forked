import { required, minLength, maxLength, numeric } from 'vuelidate/lib/validators'

export default {
    AHS: {
        kode: {
            required,
            minLength: minLength(4),
            maxLength: maxLength(255),
        },
        id_job:{
            required,
        }    
    },
}
