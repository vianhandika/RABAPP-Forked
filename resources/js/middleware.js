import store from './store'
import authService from './service/Auth'

export async function auth(to, from, next) {
  if (!localStorage.getItem('access_token') || !localStorage.getItem('Id_Akun')  ) {
    next({ name: 'login' })
    return
  } else {
    try {
      // console.log(" DPET TOKEN")
        // console.log(localStorage.getItem('Id_Akun'))
        await authService.loggedUser(localStorage.getItem('Id_Akun'))
        // console.log(store.getters['LoggedUser/Akses'])
        let Akses = store.getters['LoggedUser/Akses']
        console.log('Akses :', Akses)
       
        var x;
        let aquired=false;
        if(to.meta.Akses.includes("Panel")){
          aquired=true;
          
          next()
        }
        else{
          for(x in Akses.data){
            if (to.meta.Akses.includes(Akses.data[x].Fitur)) {
              aquired=true;
              // console.log("DPET AKSES")
    
              next()
    
            } 
          }
        }
        
        if(aquired==false){
          // console.log("GA DPET AKSES")
  
          next({ name: 'Login' }) // Fallback if the role doesn't have any permission to access page
  
        }
        // if (to.meta.role.includes(role)) {
        //   next()
        // } else {
        //   next({ name: 'Dashboard' }) // Fallback if the role doesn't have any permission to access page
        // }
      } catch (err) {
        next({ name: 'Login' })
      }
  }
  // next()
}

export default function middleware(guards) {
  return (to, from, next) => {
    guards.forEach(async (guard) => {
        await guard(to, from, next)
    })
  }
}