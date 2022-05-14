<template>
  <PageComponent title="Kings">
    <Modal v-show="show" class="w-1/3 absolute top-30 left-1/2" @close="closeModal" id="modalMessage">
      <p>{{message}}</p>
    </Modal>
    <div>
      <div class="grid3">
        <div class="pr-1">
          <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400 overflow-x-auto shadow-md sm:rounded-lg"
          >
            <thead
              class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400 shadow-md sm:rounded-lg"
            >
              <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Streamer</th>
                <th scope="col" class="px-6 py-3">Votes</th>
              </tr>
            </thead>
            <tbody v-for="votes in topVoted.streamers" :key="votes.id">
              <tr
                :class="{
                  'bg-teal-700 border-b text-white text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 1,
                  'bg-custom-greenwater border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 2,
                  'bg-zinc-400 border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 3,
                  'bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-500 dark:text-white':
                    votes.position > 3,
                }"
              >
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                  {{ votes.position }}
                </th>
                <td class="px-6 py-4">{{ votes.streamer_voted }}</td>
                <td class="px-6 py-4">{{ votes.votes }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="pr-1">
          <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md sm:rounded-lg"
          >
            <thead
              class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400 shadow-md sm:rounded-lg"
            >
              <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Game</th>
                <th scope="col" class="px-6 py-3">Votes</th>
              </tr>
            </thead>
            <tbody v-for="votes in topVoted.games" :key="votes.id">
              <tr
                :class="{
                  'bg-teal-700 border-b text-white text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 1,
                  'bg-custom-greenwater border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 2,
                  'bg-zinc-400 border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 3,
                  'bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-500 dark:text-white':
                    votes.position > 3,
                }"
              >
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                  {{ votes.position }}
                </th>
                <td class="px-6 py-4">{{ votes.game_voted }}</td>
                <td class="px-6 py-4">{{ votes.votes }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="pr-1">
          <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400 overflow-x-auto shadow-md sm:rounded-lg"
          >
            <thead
              class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400 shadow-md sm:rounded-lg"
            >
              <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Voter</th>
                <th scope="col" class="px-6 py-3">Votes</th>
              </tr>
            </thead>
            <tbody v-for="votes in topVoted.voters" :key="votes.voter">
              <tr
                :class="{
                  'bg-teal-700 border-b text-white text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 1,
                  'bg-custom-greenwater border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 2,
                  'bg-zinc-400 border-b dark:bg-gray-800 dark:border-gray-700 text-white dark:text-white text-base shadow-md sm:rounded-lg':
                    votes.position == 3,
                  'bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-500 dark:text-white':
                    votes.position > 3,
                }"
              >
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                  {{ votes.position }}
                </th>
                <td class="px-6 py-4">{{ votes.voter }}</td>
                <td class="px-6 py-4">{{ votes.votes }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import Modal from "../src/components/Modal.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

store.dispatch("getUser").then(() => {
  return store.state.user.data.id;
});
</script>

<script>
export default {
  name: "Home",
  data: function () {
    return {
      topVoted: {
        streamers: [],
        games: [],
        voters: [],
      },
      show: false,
      message: '',
    };
  },
  components: {},
  methods: {
    getTopVoted: function () {
      if (this.$route.redirectedFrom) {
        if (Object.keys(this.$route.redirectedFrom.params).length) {
          this.show = true;
          this.message = this.$route.redirectedFrom.params.message;
          setTimeout(() => this.show = false, 5000);
        }
      }
      store.dispatch("getTopVoted").then((data) => {
        this.topVoted.streamers = data.data.topStreams;
        this.topVoted.games = data.data.topGames;
        this.topVoted.voters = data.data.topVoters;
      });
    },
    closeModal: function () {
      this.show = false;
    }
  },
  mounted() {
    this.getTopVoted();
  },
};
</script>
