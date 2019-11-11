import { required, minLength, maxLength, numeric } from 'vuelidate/lib/validators'

export default {
    Project: {
        name: {
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        date: {
            required
        },
        address : {
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        contact:{
            required,
            minLength: minLength(10),
            maxLength: maxLength(255),
        },
        phone : {
            required,
            numeric,
            minLength: minLength(10),
            maxLength: maxLength(15),
        }
    },
}
