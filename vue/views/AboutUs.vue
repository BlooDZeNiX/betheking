<template>
  <PageComponent title="About Us">
    <div class="text-center mb-20" data-v-f44d9bd4="">
      <h1
        class="
          text-3xl
          font-medium
          text-center
          title-font
          text-gray-900
          mb-4
        "
        data-v-f44d9bd4=""
      >
        What we do?
      </h1>
      <p
        class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto"
        data-v-f44d9bd4=""
      >
        We crown the new kings.
      </p>
    </div>
     <div class="text-center mb-20" data-v-f44d9bd4="">
      <h1
        class="
          text-3xl
          font-medium
          text-center
          title-font
          text-gray-900
          mb-4
        "
        data-v-f44d9bd4=""
      >
        What we offer to you?
      </h1>
      <p
        class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto"
        data-v-f44d9bd4=""
      >
        Help us by voting for the pretenders to become new kings and you will be able to purchase subscriptions to their channels.
      </p>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");
</script>
<script>
export default {
  name: "AboutUs",
  data: function () {
    return {
      topGames: [],
    };
  },
  components: {},
  methods: {},
  mounted() {},
};
</script>
