import './bootstrap';

Vue.component('flash', require('./cms/components/Flash').default);
Vue.component('careers', require('./components/Careers.vue').default);
Vue.component('inquire-form', require('./components/InquireForm.vue').default);
Vue.component('influencer-form', require('./components/InfluencerForm.vue').default);
Vue.component('career-form', require('./components/CareerForm.vue').default);
Vue.component('recent-blogs', require('./components/RecentBlogs.vue').default);
Vue.component('recent-insights', require('./components/RecentInsights.vue').default);
Vue.component('insight-inner', require('./components/InsightInner.vue').default);
Vue.component('insight-modal', require('./components/InsightModal.vue').default);
Vue.component('insight-latests', require('./components/InsightLatest.vue').default);
Vue.component('search-results', require('./components/SearchResults.vue').default);

const app = new Vue({
    el: '#app',
    data() {
        return {
            grecaptcha_sitekey: document.head.querySelector('meta[name="grecaptcha_sitekey"]').content
        };
    },
});

// == == == == ==

//service's inner page load more testimonials
$(".brand-testimonial").slice(2).hide();

$("#loadMore").on("click", function (e) {
    e.preventDefault();

    $(".brand-testimonial:hidden").slice(0, 1).slideDown();

    if ($(".brand-testimonial:hidden").length == 0) {
        $("#loadMore").text("No more to load").css("pointer-events", "none");
    }
});

/**
 * social btn share
 */
var popupSize = {
    width: 780,
    height: 550
};
$(document).on('click', '.social-button', function (e) {
    var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
        horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

    var popup = window.open($(this).prop('href'), 'social',
        'width=' + popupSize.width + ',height=' + popupSize.height +
        ',left=' + verticalPos + ',top=' + horisontalPos +
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

    if (popup) {
        popup.focus();
        e.preventDefault();
    }

});

/**
 * about-us page
 */
if (window.location.pathname == '/about-us' && window.location.hash == '#why') {
    document.querySelector('a[href="#approach"]').classList.remove("active");
    document.querySelector('#approach').classList.remove("active");

    document.querySelector('a[href="#why"]').classList.add("active");
    document.querySelector('#why').classList.add("active")
}

// numbers only
const contactNumber = document.querySelector('input[name=contact]');
if (contactNumber) {
    contactNumber.addEventListener('keypress', isNumberKey)
}

function isNumberKey(e) {
    const charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
        return false;
    }
    return true;
}
