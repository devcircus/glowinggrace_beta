import axios from 'axios';
import store from 'JS/store';
import { config } from 'Config';
import Service from 'Services/Service';

class User extends Service {
    constructor () {
        if (!User.instance) {
            super();
            User.instance = this;
        }

        return User.instance;
    }

    login (email, password) {
        let formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/login`,
                data: formData,
            };

            axios(requestOptions).then(response => {
                this.handleSuccessfulLogin(response.data);

                return resolve();
            }).catch(error => {
                this.handleUnsuccessfulLogin();

                return reject(error.response);
            });
        });
    }

    logout () {
        const requestOptions = {
            method: 'POST',
            url: `${config.apiUrl}/logout`,
        };
        return axios(requestOptions).then(() => {
            this.handleSuccessfulLogout();

            return Promise.resolve();
        }).catch(error => {
            this.handleUnsuccessfulLogout();

            return Promise.reject(error.response);
        });
    }

    me () {
        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'GET',
                url: `${config.apiUrl}/me`,
            };
            axios(requestOptions).then(response => {
                this.setUser(response.data.data);

                return resolve(response.data.data);
            }).catch(error => {
                return reject(error.response);
            });
        });
    }

    changeProfileAvatar (avatar) {
        let formData = new FormData();
        formData.append('avatar', avatar);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/me/avatar`,
                data: formData,
            };
            axios(requestOptions).then( response => {
                return resolve(response.data.data);
            }).catch( error => {
                return reject(error.response);
            });
        });
    }

    clearAuthentication () {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        store.auth.token = null;
        store.auth.user = null;
        store.auth.loggedIn = false;
        axios.defaults.headers.common['Authorization'] = null;
    }

    fillAuthentication (data) {
        localStorage.setItem('user', data.data);
        localStorage.setItem('token', data.meta.token);
        store.auth.token = data.meta.token;
        store.auth.user = data.data;
        store.auth.loggedIn = true;
        axios.defaults.headers.common['Authorization'] = `Bearer ${data.meta.token}`;
    }

    handleSuccessfulLogin (data) {
        this.fillAuthentication(data);
    }

    handleUnsuccessfulLogin () {
        return this.clearAuthentication();
    }

    handleSuccessfulLogout () {
        return this.clearAuthentication();
    }

    handleUnsuccessfulLogout () {
        return;
    }

    setUser (user) {
        localStorage.setItem('user', user);
        store.auth.user = user;
    }
}

const instance = new User();

export default instance;
