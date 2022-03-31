<template>
  <div class="upload-img-container" @click="chooseImage">
    <input ref="fileInput" type="file" @input="onSelectFile" hidden />

    <label class="preview-container" v-if="source">
      <img :src="source" class="preview-image" />

      <div class="preview-middle">
        <a href="javascript:void(0)" class="btn btn-purple-round">Upload</a>

        <div class="d-flex flex-column preview-infos">
          <small class="mt-3">Max of {{ max_size }} only</small>
          <small>{{ max_dimension }} px jpg or png</small>
          <small class="text-danger" v-text="validation"></small>
        </div>
      </div>
    </label>

    <div class="text-center d-flex flex-column" v-else>
      <a href="javascript:void(0)" class="btn btn-outline-purple-round"
        >Upload
      </a>

      <small class="mt-3">Max of {{ max_size }} only</small>
      <small>{{ max_dimension }} px jpg or png</small>
      <small class="text-danger" v-text="validation"></small>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    max_size: { type: String, required: true },
    max_dimension: { type: String, required: true },
    validation: { type: String, required: false },
    path: { type: String, required: false },
  },

  data() {
    return {
      imageData: "",
    };
  },

  created() {
    if (this.$attrs.value) {
      return (this.imageData = this.path
        ? `${this.path}/${this.$attrs.value}`
        : this.$attrs.value);
    } else if (this.imageData) {
      return this.imageData;
    }
  },

  computed: {
    source() {
      if (this.$attrs.value && !this.imageData.includes("data:image")) {
        return (this.imageData = this.path
          ? `${this.path}/${this.$attrs.value}`
          : this.$attrs.value);
      } else if (this.imageData) {
        return this.imageData;
      }

      return "";
    },
  },

  methods: {
    chooseImage() {
      this.$refs.fileInput.click();
    },

    onSelectFile() {
      const input = this.$refs.fileInput;
      const files = input.files;

      if (files && files[0]) {
        // create a new FileReader to read this image and convert to base64 format
        const reader = new FileReader();

        // Define a callback function to run, when FileReader finishes its job
        reader.onload = (evt) => {
          this.imageData = evt.target.result;
        };

        // Start the reader job - read file as a data url (base64 format)
        reader.readAsDataURL(files[0]);
        this.$emit("input", files[0]);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.upload-img-container {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid;
}

.preview-container {
  position: relative;
  width: 100%;
  height: 100%;
}

.preview-image {
  // opacity: 1;
  opacity: 0.7;
  height: 100%;
  width: 100%;
  display: block;
  object-fit: cover;
  transition: 0.5s ease;
}

.preview-middle {
  transition: 0.5s ease;
  // opacity: 0;
  opacity: 1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

/* .preview-container:hover .preview-image {
  opacity: 0.7;
}

.preview-container:hover .preview-middle {
  opacity: 1;
} */

.preview-infos {
  small {
    color: #fff;
    background-color: #0000005e;
    padding: 0 5px;
  }
}
</style>