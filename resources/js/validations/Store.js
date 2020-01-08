import { required, minLength, maxLength, numeric } from 'vuelidate/lib/validators'

export default {
    Store : {
        kode:{
            required,
            minLength: minLength(4),
            maxLength: maxLength(4)
        },
        name: {
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        address : {
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        type : {
            required,
            minLength: minLength(5),
            maxLength: maxLength(255),
        },
        no_telp: {
            required,
            numeric,
            minLength: minLength(10),
            maxLength: maxLength(15)
        },
        phone: {
            required,
            numeric,
            minLength: minLength(10),
            maxLength: maxLength(15)
        },
        owner:{
            required,
            minLength: minLength(10),
            maxLength: maxLength(255)
        }
    }
}