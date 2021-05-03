export default function auth ({ next, store }){
    if(!store.getters.isLoggedIn){
        return next({
            name: 'loginForm'
        })
    }
    return next()
}