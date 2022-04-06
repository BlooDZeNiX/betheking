<template>
  <PageComponent title="Streamers">
    <div class="grid2" id="topStreamers">
      <div
        v-for="topStream in listOfStreamers"
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
            <div class="text-center bg-gray-200 rounded-b-lg">
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
                  class="
                    border border-black-600
                    rounded-lg
                    px-4
                    text-white
                    bg-gray-800
                    font-semibold
                    leading-relaxed
                    hover:bg-teal-700
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
import { computed } from "vue";
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
    }
  });

  console.log(ev.target.id, ev.target.name, store.state.user.data.id);
}

</script>

<script>
import fecth from "cross-fetch";
export default {
  name: "Streamers",
  data: function () {
    return {
      listOfStreamers: [],
    };
  },
  components: {},
  methods: {
    fetchStreamers: function () {
      let fetchLink = "https://api.twitch.tv/helix/streams?first=100";
      fecth(fetchLink, {
        method: "get",
        headers: {
          Authorization: "Bearer e1wlww25qpoew82axu3m566feqzvaz",
          "Client-Id": "xd72gmt643nbmegt9990z4c4iuvmc1",
        },
      })
        .then(function (response) {
          return response.json();
        })
        .then((data) => {
          console.log(data.data);
          this.listOfStreamers = data.data;
          this.listOfStreamers.forEach((element) => {
            element.thumbnail_url = element.thumbnail_url
              .replace("{width}", "262")
              .replace("{height}", "147");
          });
        });
    },
  },
  mounted() {
    this.fetchStreamers();
  },
};
</script>
