import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Cache-Control'] = 'no-cache,no-store,must-revalidate,max-age=-1,private';
axios.defaults.headers.common['Content-Type'] = 'application/json';

let csrf = document.head.querySelector('meta[name="csrf-token"]');

if (csrf) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
