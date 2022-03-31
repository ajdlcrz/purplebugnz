import BannerForm from "../components/BannerForm";
import SeoForm from "../components/SeoForm";

export default {
    components: {
        BannerForm,
        SeoForm,
    },

    data() {
        return {
            pageContents: [],
            contentsUrl: window.location.pathname
        };
    },

    async created() {
        await axios.get(this.contentsUrl).then(({ data }) => {
            this.pageContents = data.contents;
        });
    },

    computed: {
        bannerContents() {
            const banner = this.pageContents.find(
                (content) => content.section == "banner"
            );

            return banner.contents;
        },

        seoContents() {
            const seo = this.pageContents.find((content) => content.section == "seo");

            return seo.contents;
        },
    },
}