import axios from 'axios';
import store from 'JS/store';
import { config } from 'Config';
import Service from 'Services/Service';

class Category extends Service {
    constructor () {
        if (! Category.instance) {
            super();
            Category.instance = this;
        }

        return Category.instance;
    }

    all () {
        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'GET',
                url: `${config.apiUrl}/categories`,
            };

            axios(requestOptions).then(response => {
                this.handleSuccessfulFetch(response.data);

                return resolve();
            }).catch(error => {
                this.handleUnsuccessfulFetch(error.response);

                return reject();
            });
        });
    }

    create ({ name }) {
        const formData = this.buildFormData(name);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/categories`,
                data: formData,
            };

            axios(requestOptions).then(response => {
                this.handleSuccessfulCreate(response.data.data);

                return resolve();
            }).catch(error => {
                this.handleUnsuccessfulCreate(error.response);

                return reject();
            });
        });
    }

    update ({ id, name }) {
        const formData = this.buildFormData(name);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/categories/edit/${id}`,
                data: formData,
            };

            axios(requestOptions).then(response => {
                this.handleSuccessfulUpdate(response.data);

                return resolve();
            }).catch(error => {
                this.handleUnsuccessfulUpdate(error.response);

                return reject();
            });
        });
    }

    buildFormData (name) {
        let formData = new FormData();
        formData.append('name', name);

        return formData;
    }

    handleSuccessfulCreate (category) {
        store.posts.push(category);
        this.orderPostsBy('created_at', 'desc');
    }

    handleUnsuccessfulCreate (error) {
        console.log(error);
    }

    handleSuccessfulUpdate (data) {
        this.updatePostData(data.category);
        this.orderPostsBy('created_at', 'desc');
    }

    handleUnsuccessfulUpdate (error) {
        console.log(error);
    }

    handleSuccessfulFetch (data) {
        store.posts = data.data;
    }

    handleUnsuccessfulFetch (error) {
        console.log(error);
    }

    orderCategoriesBy (property, direction) {
        store.categories = _.orderBy(store.categories, [property], [direction]);
    }

    updateCategoryData (category) {
        let index = _.findIndex(store.categories, { id: category.id });
        store.categories.splice(index, 1, category);
    }
}

const instance = new Category();

export default instance;