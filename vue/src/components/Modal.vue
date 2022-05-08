<template>
  <Transition name="fade">
    <div
      class="
        absolute
        transform
        lg:-translate-x-1/2 lg:-translate-y-1/2
        lg:w-1/2
        lg:h-1/2
        lg:h-screen
        flex
        items-center
        justify-center
        h-full
        w-full
        lg:text-base
        text-xs
      "
      @click.self="close"
    >
      <div class="relative w-full bg-white shadow-lg rounded-lg p-8">
        <button
          aria-label="close"
          class="absolute top-0 right-0 font-medium text-xl text-gray-500 my-2 mx-4"
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
    showing(value) {
    },
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
};
</script>
