<template>
  <PageComponent title="About Us">

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
