<template>
  <PageComponent title="Games">
    <div class="grid" id="topGames">
      <div v-for="topGame in topGames" :key="topGame.id">
        <div class="rounded-lg flex justify-center overflow-hidden m-1">
          <card>
            <a href="#">
              <img
                class="rounded-t-lg"
                :src="`${topGame.box_art_url}`"
                :alt="`${topGame.name}`"
              />
            </a>
            <div class="rounded-b-lg justify-center">
              <div class="text-center bg-gray-200 rounded-b-lg">
                <div class="">
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
                    {{ topGame.name.trim().slice(0, 16)
                    }}<span v-if="topGame.name.length > 17">...</span>
                  </p>
                </div>
                <button
                  v-on:click="voteGameAds"
                  :id="`${topGame.id}`"
                  :name="`${topGame.name}`"
                  class="
                    border border-black-600
                    rounded-lg
                    px-4
                    text-white
                    bg-gray-800
                    font-semibold
                    leading-relaxed
                    hover-greenwater
                    mb-2
                  "
                >
                  Vote
                </button>
              </div>
            </div>
          </card>
        </div>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";


const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");

store.dispatch("getUser").then(() => {
  return store.state.user.data.id;
});

function voteGameAds(ev) {
  ev.preventDefault();
  router.push({
    name: "GamesVoteAds",
    params: {
      game_id: ev.target.id,
      title: "Voting " + ev.target.name,
      voter: store.state.user.data.id,
    },
  });
}
</script>
<script>
export default {
  name: "Games",
  data: function () {
    return {
      topGames: [],
    };
  },
  components: {},
  methods: {
    getTopGames: function () {
      store.dispatch("getTopGames").then((data) => {
        this.topGames = data;
      });
    },
  },
  mounted() {
    this.getTopGames();
  },
};
</script>
