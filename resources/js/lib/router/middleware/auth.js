export default function auth ({ to, next, store }) {
    let token = localStorage.getItem('token');

    if (token !== null) {
        next();
    } else {
        return next({
            name: 'login',
            query: {
                redirect: to.name,
            }
        });
    }
}