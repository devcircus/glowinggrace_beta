import axios from 'axios';
import store from 'JS/store';
import { config } from 'Config';
import Service from 'Services/Service';

class Post extends Service {
    constructor () {
        if (! Post.instance) {
            super();
            Post.instance = this;
        }

        return Post.instance;
    }

    all () {
        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'GET',
                url: `${config.apiUrl}/posts`,
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

    create ({ title, summary, body, featured_image, published_at }) {
        const formData = this.buildFormData(title, summary, body, featured_image, published_at);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/posts`,
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

    update ({ id, title, summary, body, featured_image, published_at }) {
        const formData = this.buildFormData(title, summary, body, featured_image, published_at);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/posts/edit/${id}`,
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

    deleteFeaturedImage (id) {
        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/posts/image/delete/${id}`,
            };

            axios(requestOptions).then(response => {
                this.handleSuccessfulImageDelete(response.data.post);

                return resolve();
            }).catch(error => {
                this.handleUnsuccessfulImageDelete(error.response);

                return reject();
            });
        });
    }

    buildFormData (title, summary, body, featured_image, published_at) {
        let formData = new FormData();
        formData.append('title', title);
        formData.append('summary', summary);
        formData.append('body', body);
        formData.append('featured_image', featured_image);
        formData.append('published_at', published_at);

        return formData;
    }

    handleSuccessfulCreate (post) {
        store.posts.push(post);
        this.orderPostsBy('created_at', 'desc');
    }

    handleUnsuccessfulCreate (error) {
        console.log(error);
    }

    handleSuccessfulUpdate (data) {
        this.updatePostData(data.post);
        this.orderPostsBy('created_at', 'desc');
    }

    handleUnsuccessfulUpdate (error) {
        console.log(error);
    }

    handleSuccessfulImageDelete (post) {
        let index = _.findIndex(store.posts, { id: post.id });
        store.posts[index].featured_image = null;
    }

    handleUnsuccessfulImageDelete (error) {
        console.log(error);
    }

    handleSuccessfulFetch (data) {
        store.posts = data.data;
    }

    handleUnsuccessfulFetch (error) {
        console.log(error);
    }

    orderPostsBy (property, direction) {
        store.posts = _.orderBy(store.posts, [property], [direction]);
    }

    updatePostData (post) {
        let index = _.findIndex(store.posts, { id: post.id });
        store.posts.splice(index, 1, post);
    }
}

const instance = new Post();

export default instance;