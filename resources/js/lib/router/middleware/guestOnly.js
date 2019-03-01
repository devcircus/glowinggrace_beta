export default function auth ({ next, store }) {
    if (store.auth.loggedIn) {
        return next({
            name: 'home'
        });
    }

    next();
}