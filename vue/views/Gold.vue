<template>
  <PageComponent title="Use your gold">
    <div id="fill" class="bg-white h-full flex-shrink-0 flex-grow-0">
      <div class="container mx-auto p-5 bg-white">
        <div class="flex no-wrap">
          <!-- Left Side -->
          <div class="md:mx-2">
            <!-- Gold Card -->
            <div class="font-medium text-gray-700 p-3">
              <span
                >You have
                <span
                  class="bg-teal-700 py-1 px-2 rounded text-white text-sm"
                  >{{ store.state.user.data.gold }}</span
                >
                Gold</span
              >
            </div>
            <form action="">
              <h2 class="mt-6 mb-6 text-4xl font-extrabold text-teal-700">
                Select a channet to get a Twitch suscription:
              </h2>
              <div class="rounded-md -space-y-px">
                <div class="-space-y-px">
                  <label for="name" class="sr-only">Name</label>
                  <input
                    id="name"
                    name="name"
                    class="rounded"
                    type="text"
                    autocomplete="name"
                    required
                    v-model="user.name"
                    placeholder="Name"
                  />
                </div>
              </div>
            </form>
          </div>
          <!-- End of Gold tab -->
        </div>
      </div>
    </div>
  </PageComponent>
</template>

<style scoped>
input {
  color: darkslategray;
  border-color: gray;
  border-width: 1px;
  display: block;
  position: relative;
}
input:focus {
  border-color: #24728a;
  z-index: 10;
}

#fill{
  height:54.97vh;
}
</style>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
const router = useRouter();
</script>

<script>
export default {
  name: "Gold",
  data: function () {
    return {
      user: {},
    };
  },
  components: {},
  methods: {
    getUserInfo: function () {
      store.dispatch("getUser");
    },
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>


