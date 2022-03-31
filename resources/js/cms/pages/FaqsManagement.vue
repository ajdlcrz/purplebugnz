<script>
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../mixins/Wysiwyg";

export default {
  components: {
    "tinymce-editor": Editor,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      form: {
        question: "",
        answer: "",
      },
      url: "/cms/faqs",
      method: "",
    };
  },

  methods: {
    editFaq(faq) {
      this.form.question = faq.question;
      this.form.answer = faq.answer;

      this.url = `/cms/faqs/${faq.id}`;
      this.method = "put";

      window.scroll({
        top: 0,
        behavior: "smooth",
      });
    },

    cancel() {
      Object.assign(this.$data, this.$options.data());
    },
  },
};
</script>