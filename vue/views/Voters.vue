<template>
  <PageComponent title="Voters"> </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");

store.dispatch("getUser").then(() => {
  return store.state.user.data.id;
});

function voteStreamerAds(ev) {
  ev.preventDefault();
  router.push({
    name: "StreamersVoteAds",
    params: {
      streamer_id: ev.target.id,
      login: ev.target.id,
      title: "Voting " + ev.target.name,
      voter: store.state.user.data.id,
    },
  });
}
</script>

<script>
export default {
  name: "Voters",
  data: function () {
    return {};
  },
};
</script>
