// resources/js/bootstrap.js

// Lodash (optional helper library)
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our back-end. This library automatically handles sending the CSRF token
 * as a header based on the value of the "XSRF-TOKEN" cookie.
 */
try {
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
} catch (e) {
    console.error('Error loading axios or lodash', e);
}

// Bootstrap's JS (optional, requires popper if using dropdowns/tooltips)
try {
    require('bootstrap');
} catch (e) {
    // Non-fatal if bootstrap JS not present
}

// Setup CSRF token for axios from Laravel's default meta tag if present
const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.warn('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
