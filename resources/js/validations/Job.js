import { required, minLength, maxLength, numeric } from 'vuelidate/lib/validators'

export default {
    Job: {
        kode: {
            required,
            minLength: minLength(4),
            maxLength: maxLength(255),
        },
        name: {
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        satuan : {
            required,
        },
        details:{
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        status : {
            required,
        },
    },
}
