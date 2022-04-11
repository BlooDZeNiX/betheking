<template >
  <PageComponent title="">
    <div  >
      <div id="1" v-on:click="ads" class="rounded-lg flex justify-center overflow-hidden">
        <iframe
          :src="`https://player.twitch.tv/?channel=${name}&parent=localhost&autoplay=false`"
           height="320"
           width="640"
    allowfullscreen>
      <div v-on:click="ads" class="rounded-lg flex justify-center overflow-hidden">
      </div>
</iframe>
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
    store.dispatch("voteStreamer", voteStream).
    then(() => {
      console.log('voto realizado');
    })
}
</script>

<script>
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
    getStreamer: function () {
      store.dispatch('getStreamer',  this.$route.params.streamer_id)
        .then((data) => {
          this.img = data.data["offline_image_url"];
          this.name = data.data["display_name"];
        });
    },
    ads (ev){
      ev.preventDefault();
    console.log(this);
    }
  },
  mounted() {
    this.getStreamer();
  },
};
</script>

