<template>
  <div
    v-if="store.state.user.data.rol == 'admin'"
    class="justify-between lg:flex md:flex lg:grow md:grow h-full"
  >
    <aside
      class="lg:w-32 lg:flex md:flex block md:w-32 w-full mb-2"
      aria-label="Sidebar"
    >
      <div class="overflow-y-auto bg-gray-800 rounded dark:bg-gray-900 h-full">
        <div class="">
          <div
            class="
              w-full
              py-4
              px-0.5
              flex
              lg:flex-col
              md:flex-col
              flex-row
              items-center items-baseline
            "
          >
            <router-link
              v-for="item in dashboardNavigation"
              :key="item.name"
              :to="item.to"
              active-class=""
              :class="[
                1 === item.to.name
                  ? 'bg-gray-700 text-white border-2 border-teal-700 w-full'
                  : 'text-gray-300 hover:bg-gray-700 hover:text-white w-full',
                'px-3 py-2 rounded-md text-sm font-medium w-full',
              ]"
              >{{ item.name }}</router-link
            >
          </div>
        </div>
      </div>
    </aside>
    <div class="w-full">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../store";
import { useRouter } from "vue-router";
const router = useRouter();
if (store.state.user.data.rol != "admin") {
  let show = true;
  let message = "You cannot access this page";
  router.push({
    name: "Home",
    params: {
      show,
      message,
    },
  });
}
</script>

<script>
const dashboardNavigation = [
  { name: "Dashboard", to: { name: "Dashboard" } },
  { name: "Users", to: { name: "UsersDashboard" } },
  { name: "Streamers", to: { name: "StreamersDashboard" } },
  { name: "Games", to: { name: "GamesDashboard" } },
];

export default {
  name: "Administration",
  data: function () {
    return {
      user: {},
      dashboardNavigation,
      dashboard: {
        users: {},
        streamers: {},
        games: {},
      },
    };
  },
  components: {},
  methods: {},
  mounted() {},
  setup() {
    return {};
  },
};
</script>


