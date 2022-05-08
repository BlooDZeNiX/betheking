<template>
  <PageComponent title="Streamers">
    <div class="grid2" id="topStreamers">
      <div
        v-for="topStream in topList"
        :key="topStream.id"
        class="rounded-lg flex justify-center overflow-hidden"
      >
        <card>
          <a href="#">
            <img
              :src="`${topStream.thumbnail_url}`"
              :alt="`${topStream.user_name}`"
              class="rounded-t-lg"
            />
          </a>
          <div class="rounded-b-lg justify-center pb-2">
            <div class="text-center bg-zinc-200 rounded-b-lg">
              <div class="pb-2">
                <p
                  class="
                    text-gray-800
                    whitespace-nowrap
                    font-bold
                    px-1
                    pt-2
                    pb-2
                    text-ellipsis
                  "
                >
                  {{ topStream.user_name.trim() }}
                </p>
                <button
                  v-on:click="voteStreamerAds"
                  :id="`${topStream.user_id}`"
                  :name="`${topStream.user_name}`"
                  :title="`${topStream.user_login}`"
                  class="
                    border border-black-600
                    rounded-lg
                    px-4
                    text-white
                    bg-gray-800
                    font-semibold
                    leading-relaxed
                    hover-greenwater
                  "
                >
                  Vote
                </button>
              </div>
            </div>
          </div>
        </card>
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
      login: ev.target.title,
      title: "Voting " + ev.target.name,
      voter: store.state.user.data.id,
    },
  });
}
</script>

<script>
export default {
  name: "Streamers",
  data: function () {
    return {
      topList: [],
    };
  },
  components: {},
  methods: {
    getTopStreams: function () {
      store.dispatch("getTopStreams").then((data) => {
        this.topList = data;
      });
    },
  },
  mounted() {
    this.getTopStreams();
  },
};
</script>
