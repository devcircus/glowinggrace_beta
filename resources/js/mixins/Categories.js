import { isEmpty } from 'lodash';
import Category from 'Services/Category';

export default {
    data () {
        return {
            loading: false,
        }
    },
    store: ['categories'],
    methods: {
        getCategories () {
            this.loading = true;
            return Category.all().then(() => {
                this.loading = false;
            });
        },
        numberOfCategories () {
            return this.categories.length;
        }
    },
    computed: {
        categoriesAvailable () {
            return ! isEmpty(this.categories);
        },
        categoriesNotAvailable () {
            return ! this.categoriesAvailable;
        }
    },
}