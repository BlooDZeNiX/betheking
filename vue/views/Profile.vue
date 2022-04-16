<template>
  <PageComponent title="Profile">
    <div class="bg-white">
      <div class="container mx-auto p-5 bg-white">
        <div class="md:flex no-wrap rounded-lg">
          <!-- Left Side -->
          <div class="w-full md:w-6/12 md:mx-2 shadow-lg">
            <!-- Profile Card -->
            <div class="bg-white p-3">
              <ul class="text-gray-600 px-3 mt-3 divide-y rounded shadow-sm">
                <li class="flex items-center justify-between">
                  <span class="font-bold text-xl leading-8 my-1">
                    {{ user.username }}
                  </span>
                  <button
                    class="bg-teal-700 py-1 px-2 rounded text-gray-200 text-sm"
                  >
                    edit
                  </button>
                </li>
                <li class="flex items-center py-3 justify-between">
                  <span class="text-gray-400 text-s my-1">
                    {{ user.email }}
                  </span>
                </li>
              </ul>
              <div class="image overflow-hidden">
                <img class="h-auto w-1/2 mx-auto" :src="user.imageUrl" alt="" />
              </div>
              <ul
                class="
                  bg-zinc-200
                  text-gray-600
                  hover:text-gray-700 hover:shadow
                  py-2
                  px-3
                  mt-3
                  divide-y
                  rounded
                  shadow-sm
                "
              >
                <li class="flex font-medium items-center py-3">
                  <span >Gold</span>
                  <span class="ml-auto"
                    ><span
                      class="bg-teal-700 py-1 px-2 rounded text-white text-sm"
                      >0</span
                    ></span
                  >
                </li>
                <li class="flex font-medium items-center py-3">
                  <span class="font-bold">Favorites</span>
                </li>
                <li class="flex items-center py-3">
                  <span class="font-medium">Game</span>
                  <span class="ml-auto">{{user.votes.favorites.game}}</span>
                  </li>
                <li class="flex items-center py-3">
                  <span class="font-medium">Streamer</span>
                  <span class="ml-auto">{{user.votes.favorites.streamer}}</span>
                </li>
              </ul>
            </div>
          </div>
          <!-- Right Side -->
          <div class="w-full md:w-6/12 md:mx-2 shadow-lg">

              <div class="bg-white p-3">
                <span
                  class="
                    text-gray-600
                    px-3
                    mt-3
                    rounded
                    font-bold
                    text-xl
                    leading-8
                    my-1
                  "
                  >Last Votes</span
                >
                <ul
                  v-for="vote in user.votes.votes"
                  :key="vote.id"
                  class="text-gray-600 px-3 mt-3"
                >
                  <li class="flex items-center justify-left">
                    You voted the &nbsp;<span v-if="vote.type == 'game'"> Game </span> <span v-if="vote.type == 'streamer'"> Streamer </span> &nbsp;{{ vote.name_voted }}
                  </li>
                </ul>
              </div>
            </div>
            <!-- End of profile tab -->
          </div>
        </div>
      </div>

  </PageComponent>
</template>

<script>
import PageComponent from "../src/components/PageComponent.vue";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRouter } from "vue-router";

export default {
  name: "Profile",
  data: function () {},
  components: {},
  methods: {},
  mounted() {},
  setup() {
    const store = useStore();
    const router = useRouter();
    store.dispatch("getUser");
    store.dispatch("getUserVotes", store.state.user.data);
    console.log(store.state.user)
    return {
      user: computed(() => store.state.user.data),
    };
  },
};
</script>

