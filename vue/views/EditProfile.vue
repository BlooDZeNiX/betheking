<template>
  <PageComponent title="Profile">
    <div class="bg-gray-200">
      <div class="container mx-auto p-5">
        <div class="md:flex no-wrap rounded-lg">
          <!-- Left Side -->
          <div class="w-full md:w-6/12 md:mx-2">
            <!-- Profile Card -->
            <div class="bg-white p-3">
              <ul class="text-gray-600 px-3 mt-3 divide-y rounded shadow-sm">
                <li class="flex items-center justify-between">
                  <span class="text-gray-900 font-bold text-xl leading-8 my-1">
                    {{ user.name }}
                  </span>
                  <span
                    class="bg-teal-700 py-1 px-2 rounded text-gray-200 text-sm"
                    >edit</span
                  >
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
                  bg-gray-100
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
                <li class="flex items-center py-3">
                  <span>Gold</span>
                  <span class="ml-auto"
                    ><span
                      class="bg-teal-700 py-1 px-2 rounded text-white text-sm"
                      >0</span
                    ></span
                  >
                </li>
                <li class="flex items-center py-3">
                  <span>Favorites</span>
                  <span class="ml-auto">-</span>
                </li>
              </ul>
            </div>
          </div>
          <!-- Right Side -->
          <div class="w-full mt-2 h-35">
            <!-- About Section -->
            <div class="bg-white p-3 shadow-sm rounded-sm">
              <div
                class="
                  flex
                  items-center
                  space-x-2
                  font-semibold
                  text-gray-900
                  leading-8
                "
              >
                <span clas="text-green-500">
                  <svg
                    class="h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                </span>
                <span class="md:mt-1 rounded-lg">About</span>
              </div>
            </div>
            <!-- End of profile tab -->
          </div>
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
    return {
      user: computed(() => store.state.user.data),
    };
  },
};
</script>
