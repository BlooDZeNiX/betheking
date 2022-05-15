<template>
  <PageComponent title="Use your gold">
    <div id="fill" class="bg-white h-full flex-shrink-0 flex-grow-0">
      <div class="container mx-auto p-5 bg-white">
        <div class="flex no-wrap">
          <!-- Left Side -->
          <div class="md:mx-2">
            <!-- Gold Card -->
            <div class="text-3xl font boldtext-gray-700">
              <h2
                >You have {{ store.state.user.data.gold }} Gold</h2
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
                <div>
                  <button
                      id="editProfile"
                      :name="``"
                      class="
                        border border-black-600
                        rounded-lg
                        mt-4
                        px-4
                        text-white
                        bg-gray-800
                        font-semibold
                        leading-relaxed
                        hover-greenwater
                        h-12
                      "
                    >
                      Get it
                    </button>
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


