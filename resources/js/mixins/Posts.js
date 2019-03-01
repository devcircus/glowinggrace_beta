import { isEmpty } from 'lodash';
import Post from 'Services/Post';

export default {
    data () {
        return {
            loading: false,
        }
    },
    store: ['posts'],
    methods: {
        getPosts () {
            this.loading = true;
            return Post.all().then( () => {
                this.loading = false;
            }).catch( () => {
                this.loading = false;
            });
        },
        numberOfPosts () {
            return this.posts.length;
        }
    },
    computed: {
        postsAvailable () {
            return ! isEmpty(this.posts);
        },
        postsNotAvailable () {
            return ! this.postsAvailable;
        }
    },
}