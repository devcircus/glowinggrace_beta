import axios from 'axios';
import store from 'JS/store';
import User from 'Services/User';

let token = localStorage.getItem('token');
if (token !== null) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    store.auth.token = token;
    User.me().then(user => {
        store.auth.loggedIn = true;
    }).catch(error => {
        User.clearAuthentication();
    });
} else {
    User.clearAuthentication();
}