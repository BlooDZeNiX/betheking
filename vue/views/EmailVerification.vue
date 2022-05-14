<template>
  <PageComponent title="Verify Your Email">
    <div class="bg-white">
      <div class="container mx-auto p-5 bg-white">
        <div class="md:flex no-wrap rounded-lg">
          <!-- Left Side -->
          <div class="w-full md:mx-2 shadow-lg">
            <!-- Profile Card -->
            <div class="bg-white p-3">
              <form method="post" enctype="multipart/form-data">
                <ul class="text-gray-600 px-3 mt-3 divide-y rounded">
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Your Email
                    </span>
                    <input
                      v-model="email.email"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="email"
                      name="actual"
                      id="actual"
                    />
                  </li>
                  <li class="flex justify-center py-3">
                    <button
                      v-on:click="verifyEmail"
                      :id="``"
                      :name="``"
                      :title="``"
                      class="
                        border border-black-600
                        rounded-lg
                        px-4
                        text-white
                        bg-gray-800
                        font-semibold
                        leading-relaxed
                        hover-greenwater
                        h-12
                      "
                    >
                      Send email verification
                    </button>
                  </li>
                </ul>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../src/components/PageComponent.vue";

</script>

<script>
import { LockClosedIcon } from "@heroicons/vue/solid";
import { ref } from "vue";
import store from "../src/store";
import { useRouter } from "vue-router";
const router = useRouter();

export default {
  name: "EmailVerification",
  data: function () {
    return {
      email: {
        id: store.state.user.data.id,
        username: store.state.user.data.username,
        email: store.state.user.data.email,
      },
      user: {},
    };
  },
  components: {},
  methods: {
    getUserInfo() {
       store.dispatch("getUser");
    },
    verifyEmail(ev) {
      ev.preventDefault();
      store.dispatch("verifyEmail", this.email);
    }
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>

<style scoped>
input:focus {
  border-color: #24728a;
  z-index: 10;
}
</style>
