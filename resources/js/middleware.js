import store from './store'

export async function auth(to, from, next) {
  if (!localStorage.getItem('access_token')) {
    next({ name: 'login' })
    return
  } 
  next()
}

export default function middleware(guards) {
  return (to, from, next) => {
    guards.forEach(async (guard) => {
        await guard(to, from, next)
    })
  }
}