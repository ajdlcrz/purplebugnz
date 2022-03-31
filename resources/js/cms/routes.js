import VueRouter from 'vue-router'

let routes = [
    // SERVICES
    {
        path: "/cms/pages/services",
        name: 'ServicesIndex',
        component: require('./pages/services/ServicesIndex').default
    },
    {
        path: "/cms/pages/services",
        name: 'ServiceForm',
        component: require('./pages/services/ServiceForm').default,
        children: [
            { path: 'create', name: 'ServiceCreate' },
            { path: ':id/edit', name: 'ServiceEdit' }
        ]
    },
    // BLOGS
    {
        path: "/cms/pages/blogs",
        name: 'BlogsIndex',
        component: require('./pages/blogs/BlogsIndex').default
    },
    {
        path: "/cms/pages/blogs",
        name: 'BlogForm',
        component: require('./pages/blogs/BlogForm').default,
        children: [
            { path: 'create', name: 'BlogCreate' },
            { path: ':id/edit', name: 'BlogEdit' }
        ]
    },
    // INSIGHTS
    {
        path: "/cms/pages/insights",
        name: 'InsightsIndex',
        component: require('./pages/insights/InsightsIndex').default
    },
    {
        path: "/cms/pages/insights",
        name: 'InsightForm',
        component: require('./pages/insights/InsightForm').default,
        children: [
            { path: 'create', name: 'InsightCreate' },
            { path: ':id/edit', name: 'InsightEdit' },
        ]
    },
    {
        path: "/cms/pages/insights-report",
        name: 'InsightInquiry',
        component: require('./pages/insights/InsightInquiry').default
    },
    // CAREERS
    {
        path: "/cms/pages/careers",
        name: 'CareersIndex',
        component: require('./pages/careers/CareersIndex').default
    },
    {
        path: "/cms/pages/applicants",
        name: 'ApplicantsIndex',
        component: require('./pages/careers/ApplicantsIndex').default,
    },
    {
        path: "/cms/pages/jobs",
        name: 'JobsIndex',
        component: require('./pages/careers/JobsIndex').default
    },
    // Influencers
    {
        path: "/cms/pages/influencers",
        name: 'InfluencersIndex',
        component: require('./pages/influencers/InfluencersIndex').default
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        if (to.hash) {
            const element = document.querySelector(to.hash);

            return window.scrollTo({
                top: element.offsetTop,
                behavior: 'smooth'
            });
        }
    },
});
