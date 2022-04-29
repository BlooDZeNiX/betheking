<template>
<PageComponent title="Games Management">
  <Administration>

  </Administration>
</PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import Administration from "../src/components/Administration.vue";
import Modal from "../src/components/Modal.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");
</script>

<script>
export default {
  name: "Dashboard",
  data: function () {
    return {

    };
  },
  components: {},
  methods: {

  },
  mounted() {

  },
};
</script>
