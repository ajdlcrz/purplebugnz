<template>
  <div class="upload-file">
    <div class="upload-input">
      <label class="file-select">
        <span
          v-if="file"
          v-text="file.name"
          :title="file.name"
        ></span>
        <span v-else>Select File</span>

        <input
          name="file"
          type="file"
          ref="fileInput"
          accept=".pdf,.doc,.docx"
          @change="onFilePicked"
        />
      </label>

      <span
        class="remove-file"
        @click="removeFile"
      >
        <img
          src="/img/icon-close.svg"
          alt=""
        />
      </span>
    </div>

    <button
      class="btn btn-outline-purple"
      @click.prevent="onPickFile"
    >
      {{ file ? "Change" : "Upload" }}
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      file: null,
    };
  },

  methods: {
    onPickFile() {
      this.$refs.fileInput.click();
    },

    onFilePicked(event) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      this.file = files[0];
    },

    removeFile() {
      this.file = null;
      this.$refs.fileInput.value = null;
    },
  },
};
</script>

<style lang="scss" scoped>
.upload-file {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;

  @media (max-width: 500px) {
    flex-direction: column;

    .upload-input {
      justify-content: center;
      max-width: 100%;
      height: 50px;

      .remove-file {
        margin-left: unset;
      }
    }

    .btn {
      align-self: stretch;
    }
  }
}

.upload-input {
  border: 1px solid rgba(112, 112, 112, 0.25);
  border-radius: 7px;
  max-width: 230px;
  align-self: stretch;
  display: flex;
  align-items: center;

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

.file-select {
  margin: 0;
  padding: 7px 30px;
  white-space: nowrap;
  overflow: hidden;

  input[type="file"] {
    display: none;
  }
}
</style>
