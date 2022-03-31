<template>
  <div class="align-items-center d-flex flex-column">
    <div class="upload-img-container mb-3">
      <input ref="fileInput" type="file" @input="onSelectFile" hidden />

      <label class="preview-container" v-if="source">
        <img :src="source" class="preview-image" />

        <div class="preview-middle">
          <div class="d-flex flex-column preview-infos">
            <small
              class="text-danger"
              v-if="errors.image"
              v-text="errors.image[0]"
            ></small>
          </div>
        </div>
      </label>

      <div class="text-center d-flex flex-column" v-else>
        <small>Max of 2mb only</small>
        <small>676x561 px jpg or png</small>
      </div>
    </div>

    <div class="upload-file" v-if="fileName">
      <div class="upload-input">
        <input
          class="border-0 p-0 px-3 upload-text"
          type=""
          v-model="fileName"
          readonly
        />

        <span class="remove-file" @click="deleteImage">
          <img src="/img/icon-close.svg" alt="" />
        </span>
      </div>
    </div>

    <a
      href="javascript:void(0)"
      class="btn btn-outline-purple-round"
      v-else
      @click="chooseImage"
      >Upload
    </a>
  </div>
</template>

<script>
export default {
  props: {
    validation: { type: String, required: false },
  },

  data() {
    return {
      imageData: "",
      fileName: "",
      errors: {},
    };
  },

  created() {
    if (this.$attrs.value) {
      this.fileName = this.$attrs.value.image;
      return `/storage/teams/photos/${this.$attrs.value.image}`;
    } else if (this.imageData) {
      return this.imageData;
    }
  },

  computed: {
    source() {
      if (this.$attrs.value && !this.imageData.includes("data:image")) {
        this.fileName = this.$attrs.value.image;
        return `/storage/teams/photos/${this.$attrs.value.image}`;
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

        this.fileName = files[0]["name"];

        // Start the reader job - read file as a data url (base64 format)
        reader.readAsDataURL(files[0]);
        this.$emit("input", files[0]);

        // UPLOAD IMAGE
        const formData = new FormData();
        formData.append("image", files[0]);

        axios
          .post(`/cms/pages/our-teams/add-photo`, formData)
          .then(({ data }) => {
            flash(data.success);
            this.fileName = data.photo.image;
            this.$emit("input", data.photo);
            this.$emit("uploadSuccess");
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
          });
      }
    },

    deleteImage() {
      axios
        .delete(`our-teams/${this.$attrs.value.id}/delete-photo`)
        .then(({ data }) => {
          flash(data.success);
          this.$emit("deletedPhoto");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.upload-img-container {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 0;
  height: 150px;
  width: 150px;
  background-color: #222f3e61;
  overflow: hidden;

  label {
    margin-bottom: 0;
  }
}

.preview-container {
  position: relative;
  width: auto;
  //   width: 100%;
  height: 100%;
}

.preview-image {
  opacity: 1;
  height: 100%;
  width: auto;
  //   width: 100%;
  display: block;
  object-fit: cover;
  transition: 0.5s ease;
}

.preview-middle {
  transition: 0.5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.preview-container:hover .preview-image {
  opacity: 0.7;
}

.preview-container:hover .preview-middle {
  opacity: 1;
}

.preview-infos {
  small {
    color: #fff;
    background-color: #e9ecefa6;
    padding: 0 5px;
  }
}

.upload-file {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.upload-input {
  border: 1px solid rgba(112, 112, 112, 0.25);
  border-radius: 7px;
  max-width: 230px;
  display: flex;
  align-items: center;

  .upload-text {
    width: 130px;
    font-size: 11px;

    &:focus {
      outline: none;
    }
  }

  .remove-file {
    cursor: pointer;
    position: relative;
    right: 10px;
    margin-left: auto;
    background-color: #fff;
    padding: 0 5px;

    img {
      width: 15px;
    }
  }
}
</style>