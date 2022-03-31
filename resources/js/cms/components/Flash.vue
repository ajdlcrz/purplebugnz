<template>
  <transition name="slide-fade">
    <div
      id="success"
      :class="`alert alert-${level} alert-flash`"
      role="alert"
      v-show="show"
    >
      <!-- <strong>{{level.charAt(0).toUpperCase() + level.slice(1)}}!</strong> -->
      {{ body }}
    </div>
  </transition>
</template>

<script>
export default {
  props: ["message", "status"],

  data() {
    return {
      body: "",
      level: "success",
      show: false,
    };
  },

  created() {
    if (this.message) {
      this.flash(this.message, this.status);
    }

    window.events.$on("flash", (data) => {
      this.flash(data.message, data.level);
    });
  },

  methods: {
    flash(message, level) {
      this.body = message;
      this.level = level;
      this.show = true;

      this.hide();
    },

    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    },
  },
};
</script>

<style>
.alert-flash {
  position: fixed;
  z-index: 9999;
  right: 25px;
  top: 100px;
}
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>
