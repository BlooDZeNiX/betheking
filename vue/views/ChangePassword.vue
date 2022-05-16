<template>
  <PageComponent title="Change your password">
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
                      Actual Password
                    </span>
                    <input
                      v-model="changePassword.actual_password"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="actual_password"
                      id="actual_password"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      New Password
                    </span>
                    <input
                      v-model="changePassword.new_password"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="new_password"
                      id="new_passwor"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Repeat New Password
                    </span>
                    <input
                      v-model="changePassword.new_password_confirmation"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="new_password_confirmation"
                      id="new_password_confirmation"
                    />
                  </li>
                  <li class="flex flex-col items-center py-3">
                    <div>
                      <Alert
                        v-if="Object.keys(errors).length"
                        class="
                          flex-col
                          items-stretch
                          text-sm
                          rounded-lg
                          text-red
                          border-2 border-red-900
                        "
                      >
                        <div v-for="(field, i) of Object.keys(errors)" :key="i">
                          <div
                            v-for="(error, ind) of errors[field] || []"
                            :key="ind"
                          >
                            * {{ error.trim() }}
                          </div>
                        </div>
                      </Alert>
                    </div>
                    <div class="mt-4">
                      <button
                        v-on:click="editUserPassword"
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
                        Change Password
                      </button>
                    </div>
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
import Alert from "../src/components/Alert.vue";
</script>

<script>
import { LockClosedIcon } from "@heroicons/vue/solid";
import { ref } from "vue";
import store from "../src/store";
import { RouterLink, useRouter } from "vue-router";

const router = useRouter();
let errors = ref("");
let show = false;
let message = "";

export default {
  name: "EditProfile",
  data: function () {
    return {
      changePassword: {
        user_id: store.state.user.data.id,
        actual_password: "",
        new_password: "",
        new_password_confirmation: "",
      },
      user: {},
    };
  },
  components: {},
  methods: {
    getUserInfo() {
      store.dispatch("getUser");
    },
    toHome() {},
    editUserPassword(ev) {
      ev.preventDefault();
      store
        .dispatch("editUserPassword", this.changePassword)
        .then((response) => {
          if (response) {
            show = true;
            message = "Password Changed";
            this.$router.push({
              name: "Home",
              params:{
                show,
                message,
              }
            })
          }
        })
        .catch((error) => {
          if (error) {
            if (error.response.status === 422) {
              errors.value = error.response.data.errors;
              this.getUserInfo();
            }
          }
        });
    },
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
