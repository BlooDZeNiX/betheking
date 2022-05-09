<template>
    <div class="bg-white flex grow">
      <aside class="w-32" aria-label="Sidebar">
        <div
          class="overflow-y-auto bg-gray-800 rounded dark:bg-gray-900 h-full"
        >
          <div class="hidden md:block">
            <div class="w-full py-4 px-0.5 flex flex-col items-center items-baseline">
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
</script>

<script>

const dashboardNavigation = [
  { name: "Dashboard", to: { name: "Dashboard" }},
  { name: "Users", to: { name: "UsersDashboard" }},
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
  methods: {

  },
  mounted() {
  },
  setup() {
    return {
    };
  },
};
</script>


