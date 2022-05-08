<template>
  <PageComponent title="Help">
<FAQ></FAQ>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import FAQ from "../src/components/FAQ.vue";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");

</script>
<script>
export default {
  name: "Help",
  data: function () {
    return {
    };
  },
  components: {FAQ},
  methods: {

  },
  mounted() {

  },
};
</script>
