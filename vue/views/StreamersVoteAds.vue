<template>
  <PageComponent title="">
    <div>
      <div
        id="1"
        v-on:click="ads"
        class="rounded-lg flex justify-center overflow-hidden"
      >
        <iframe
          :src="`https://player.twitch.tv/?channel=${name}&parent=betheking.online&autoplay=false`"
          height="320"
          width="640"
          allowfullscreen
        >
          <div
            v-on:click="ads"
            class="rounded-lg flex justify-center overflow-hidden"
          ></div>
        </iframe>
      </div>
      <br />
      <div class="rounded-lg flex justify-center overflow-hidden">
        <button
          v-on:click="voteStreamer"
          class="border border-black-600 rounded-lg px-4 text-white bg-gray-800 font-semibold leading-relaxed hover-greenwater"
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

const router = useRouter();

const voteStream = {
  voter: "",
  streamerVoted: "",
  streamerLogin: "",
};

let show = true;
let message = '';

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
  voteStream.streamerLogin =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "login"
    );
  store.dispatch("voteStreamer", voteStream).then((data) => {
    if (typeof data == "number") {
      message =
        "You cannot vote Streamers before " + parseInt(data) + " minutes.";
    } else {
      message = "Vote realized.";
    }
    router.push({
      name: "Home",
      params: {
        show,
        message,
      },
    });
  });
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
      store
        .dispatch("getStreamer", this.$route.params.streamer_id)
        .then((data) => {
          console.log(data);
          this.img = data.data["offline_image_url"];
          this.name = data.data["display_name"];
        });
    },
    ads(ev) {
      ev.preventDefault();
      console.log(this);
    },
  },
  mounted() {
    this.getStreamer();
  },
};
</script>
