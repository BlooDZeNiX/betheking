<template>
  <PageComponent title="">
    <div>
      <div class="rounded-lg flex justify-center overflow-hidden">
        <img :src="`${img}`" :alt="`${name}`" />
      </div>
      <br />
      <div class="rounded-lg flex justify-center overflow-hidden">
        <button
          v-on:click="voteGame"
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
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();

const voteGames = {
  voter: "",
  name: "",
  gameVoted: "",
};
let show = true;
let message = "";
function voteGame(ev) {
  ev.preventDefault();
  voteGames.voter =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "voter"
    );
  voteGames.gameVoted =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "game_id"
    );
  voteGames.name =
    ev.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
      "name"
    );
  store.dispatch("voteGame", voteGames).then((data) => {
    if (typeof data == "number") {
      message = "You cannot vote Games before " + parseInt(data) + " minutes.";
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
  name: "GamesVoteAds",
  data: function () {
    return {
      img: "",
      name: "",
    };
  },
  components: {},
  methods: {
    getGame: function () {
      store.dispatch("getGame", this.$route.params.game_id).then((data) => {
        this.img = data.data[0]["box_art_url"];
        this.name = data.data[0]["name"];
      });
    },
    ads(ev) {
      ev.preventDefault();
      console.log(this);
    },
  },
  mounted() {
    this.getGame();
  },
};
</script>
