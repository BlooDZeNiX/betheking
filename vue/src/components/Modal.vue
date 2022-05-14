<template>
  <Transition name="fade">
    <div
      class="
        bold
        font-medium
        absolute
        transform
        -translate-x-1/2 -translate-y-1/2
        lg:w-1/2
        md:w-1/2
        h-1/2 h-screen
        flex
        items-center
        justify-center
        h-full
        w-full
        text-base text-xs
      "
      @click.self="close"
    >
      <div class="relative lg:w-2/3 md:w-2/3 w-full bg-white shadow-lg rounded-lg p-8">
        <button
          aria-label="close"
          class="
            absolute
            top-0
            right-0
            font-medium
            text-xl text-gray-500
            my-2
            mx-4
          "
          @click.prevent="close"
        >
          ×
        </button>
        <slot />
      </div>
    </div>
  </Transition>
</template>

// script...

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>

<script>
export default {
  name: "Modal",
  props: {
    showing: {
      required: true,
      type: Boolean,
    },
  },
  watch: {
    showing(value) {},
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
};
</script>
