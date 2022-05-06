import './bootstrap';
import VueRouter from 'vue-router'
import router from './cms/routes';
import moment from 'moment';

Vue.use(VueRouter)

Vue.prototype.moment = moment;

// Laravel's auth helper into a Vue instance  this.$auth
let authUser = (document.querySelector("meta[name='auth']").getAttribute('content'))
Vue.prototype.$auth = authUser ? JSON.parse(authUser) : '';

window.flash = function (message, level = "success") {
    window.events.$emit('flash', { message, level });
};

window.fetchData = function () {
    window.events.$emit('fetchData');
};

// components
Vue.component('flash', require('./cms/components/Flash').default);

// pages
Vue.component('my-account', require('./cms/pages/MyAccount').default);
Vue.component('faqs-management', require('./cms/pages/FaqsManagement').default);
Vue.component('activity-logs', require('./cms/pages/ActivityLogs').default);
Vue.component('user-management', require('./cms/pages/UserManagement').default);
Vue.component('homepage', require('./cms/pages/Homepage').default);
Vue.component('about', require('./cms/pages/About').default);
// Vue.component('teams', require('./cms/pages/Teams').default);
Vue.component('contact', require('./cms/pages/Contact').default);
Vue.component('footer-links', require('./cms/pages/FooterLinks').default);

Vue.component('cms-view', require('./cms/CmsView').default);

const app = new Vue({
    el: '#cms',
    router
});


//  == == == == == == == == == == == == ==

// Sidebar toggle
$("#cms-nav-btn-toggler").on('click', function () {
    $("#mySidenav").toggleClass('full-side-bar-menus');
    $(".sidebar-text").toggleClass('d-none ml-4');
    $(".sidebar-link").toggleClass('text-center');
});

// Prevent Bootstrap dialog from blocking focusin
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});

// collapse
$('.collapse').on('shown.bs.collapse', function () {
    $(this).prev().addClass('activeQuestion');
    // $(this).prev()[0].scrollIntoView({ behavior: "smooth" });

    $('html, body').animate({
        scrollTop: $('.activeQuestion').offset().top - 70
    }, 500);
});

$('.collapse').on('hidden.bs.collapse', function () {
    $(this).prev().removeClass('activeQuestion');
});
