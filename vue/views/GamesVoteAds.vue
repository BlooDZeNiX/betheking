<template >
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

const voteGames = {
  voter: "",
  gameVoted: "",
};

let loading = ref(false);
let errorMsg = ref("");
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
  console.log(voteGames);
  store.dispatch("voteGame", voteGames).then(() => {
    console.log("voto realizado");
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
        console.log(data.data);
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

