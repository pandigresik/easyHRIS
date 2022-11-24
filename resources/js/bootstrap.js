/* eslint-disable import/no-webpack-loader-syntax */
// @ts-nocheck
window._ = require('lodash')

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.Popper = require('popper.js').default
  window.$ = window.jQuery = require('jquery')
  window.moment = require('moment')
  window.toastr = require('toastr')
  window.bootbox = require('bootbox')
    
  require('bootstrap')
  window.coreui = require('@coreui/coreui')
  require('@coreui/icons')
  require('select2')
  // @ts-ignore
  require('bootstrap-daterangepicker')
  require('inputmask/lib/jquery.inputmask')
  require('inputmask/lib/extensions/inputmask.extensions')
  require('inputmask/lib/extensions/inputmask.date.extensions')
  require('inputmask/lib/extensions/inputmask.numeric.extensions')
  require('ladda')
  require('simplebar')
} catch (e) {}

window.$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function (x, status, error) {
      if(x.status != 0){
        bootbox.alert("An error occurred: " + status + "nError: " + error+ " status code "+x.status);            
      }            
    }
});
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
