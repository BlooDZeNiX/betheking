<template>
  <PageComponent title="">
    <div>
      <div class="rounded-lg flex justify-center overflow-hidden">
        <!-- <img :src="`${img}`" alt="" /> -->
        <iframe
          :src="`https://player.twitch.tv/?channel=${name}&parent=localhost&autoplay=false`"
           height="320"
           width="640"
    allowfullscreen>
</iframe>
        <!-- <p>{{name}}</p> -->
      </div>
      <br />
      <div class="rounded-lg flex justify-center overflow-hidden">
        <button
          v-on:click="voteStreamer"
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
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const voteStream = {
  voter: "",
  streamerVoted: "",
};

let loading = ref(false);
let errorMsg = ref("");

function voteStreamer(ev) {
  ev.preventDefault();
  voteStream.voter =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "voter"
    );
  voteStream.streamerVoted =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "streamer_id"
    );
    console.log(voteStream)
    store.dispatch("voteStreamer", voteStream).
    then(() => {

    })
}
</script>

<script>
import fecth from "cross-fetch";
export default {
  name: "StreamersVoteAds",
  data: function () {
    return {
      img: "",
      name: "",
    };
  },
  components: {},
  methods: {
    clip: function () {
      let fetchLink =
        "https://api.twitch.tv/helix/users?id=" +
        this.$route.params.streamer_id;
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
          console.log(data.data[0])
          this.img = data.data[0]["profile_image_url"];
          this.name = data.data[0]["display_name"];
        });
    },
  },
  mounted() {
    this.clip();
  },
};
</script>

