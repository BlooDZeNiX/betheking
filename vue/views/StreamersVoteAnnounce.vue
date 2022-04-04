<template>
  <PageComponent title="Announce">
    <div>
      <div class="rounded-lg flex justify-center overflow-hidden">
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
const vote = {
  voter: "",
  streamerVoted: "",
};

let loading = ref(false);
let errorMsg = ref("");

function voteStreamer(ev) {
  ev.preventDefault();
  router.push({
    name: "Games",
  });
}
</script>

<script>
</script>
