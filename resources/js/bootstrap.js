import axios from 'axios';
window.axios = axios;

import jQuery from 'jquery';
window.$ = jQuery;

import * as Popper from '@popperjs/core';
window.Popper = Popper;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
