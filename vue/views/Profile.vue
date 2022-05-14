<template>
  <PageComponent title="Profile">
    <div class="bg-white">
      <div class="container mx-auto p-5 bg-white">
        <div class="md:flex no-wrap rounded-lg">
          <!-- Left Side -->
          <div class="w-full lg:w-6/12 md:w-6/12 md:mx-2 shadow-lg">
            <!-- Profile Card -->
            <div class="bg-white p-3">
              <ul class="text-gray-600 px-3 mt-3 divide-y rounded shadow-sm">
                <li class="flex items-center justify-between">
                  <span class="font-bold text-xl leading-8 my-1">
                    {{ store.state.user.data.username }}
                  </span>
                  <button
                    v-on:click="editProfile"
                    class="bg-teal-700 py-1 px-2 rounded text-gray-200 text-sm"
                  >
                    Edit
                  </button>
                </li>
                <li class="flex items-center py-3 justify-between">
                  <span class="text-gray-400 text-s my-1">
                    {{ store.state.user.data.email }}
                  </span>
                   <button
                    v-on:click="verifyEmail"
                    v-if="!store.state.user.data.email_verified_at"
                    class="bg-red-900 py-1 px-2 rounded text-gray-200 text-sm"
                  >
                    Confirm me!
                  </button>
                  <button
                    v-else
                    disabled
                    class="bg-teal-700 py-1 px-2 rounded text-gray-200 text-sm"
                  >
                    Verified
                  </button>
                </li>
              </ul>
              <div class="image overflow-hidden">
                <img
                  class="h-auto w-1/2 mx-auto"
                  :src="store.state.user.data.imageUrl"
                  alt=""
                />
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
                  <span>Gold</span>
                  <span class="ml-auto"
                    ><span
                      class="bg-teal-700 py-1 px-2 rounded text-white text-sm"
                      >{{ store.state.user.data.gold }}</span
                    ></span
                  >
                </li>
                <li class="flex font-medium items-center py-3">
                  <span class="font-bold">Favorites</span>
                </li>
                <li class="flex items-center py-3">
                  <span class="font-medium">Game</span>
                  <span class="ml-auto"></span>
                </li>
                <li class="flex items-center py-3">
                  <span class="font-medium">Streamer</span>
                  <span class="ml-auto"></span>
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
                v-for="vote in store.state.user.votes.votes"
                :key="vote.id"
                class="text-gray-600 px-3 mt-3"
              >
                <li class="flex items-center justify-left">
                  <div class="border-2 p-2 w-full rounded-md border-gray-900 bg-gray-500 text-white">
                  You voted the <span v-if="vote.type == 'game'">
                    Game
                  </span>
                  <span v-if="vote.type == 'streamer'">Streamer </span>
                  {{ vote.name_voted }}
                  </div>
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



<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";

const router = useRouter();

 function editProfile(ev) {
    router.push({
      name: "EditProfile",
      params: {
        id: store.state.user.data.id,
        title: "Editing your data",
      },
    })
  }
  function verifyEmail(ev) {
    router.push({
      name: "EmailVerification",
      params: {
        title: "Email Verification",
      },
    })
  }
</script>

<script>
export default {
  name: "Profile",
  data: function () {
    return{
      user: {},
    }
  },
  components: {},
  methods: {
    getUserInfo: function () {
      store.dispatch("getUser");
      store.dispatch("getUserVotes", store.state.user.data).then((data) => {
        this.user = store.state.user;
      });
    },
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>


