<template>
  <PageComponent title="">
    <div class="bg-white">
      <div class="container mx-auto p-5 bg-white">
        <div class="md:flex no-wrap rounded-lg">
          <!-- Left Side -->
          <div class="w-full md:w-6/12 md:mx-2 shadow-lg">
            <!-- Profile Card -->
            <div class="bg-white p-3">
              <form method="post" enctype="multipart/form-data">
                <ul class="text-gray-600 px-3 mt-3 divide-y rounded">
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Actual Password
                    </span>
                    <input
                      v-model="changePassword.actual"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="actual"
                      id="actual"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      New Password
                    </span>
                    <input
                      v-model="changePassword.new"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="new"
                      id="new"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      New Password
                    </span>
                    <input
                      v-model="changePassword.new_repeat"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="password"
                      name="new_repeat"
                      id="new_repeat"
                    />
                  </li>
                  <li class="flex justify-center py-3">
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

<script>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import { ref } from "vue";
import store from "../src/store";
import { useRouter } from "vue-router";
const router = useRouter();

export default {
  name: "EditProfile",
  data: function () {
    return {
      changePassword: {
        user_id: store.state.user.data.id,
        actual: "",
        new: "",
        new_repeat: "",
      },
      user: {},
    };
  },
  components: {},
  methods: {
    getUserInfo() {
       store.dispatch("getUser");
       console.log(store.state.user.data, this.changePassword)
    },
    editUserPassword(ev) {
      ev.preventDefault();
      store.dispatch("editUserPassword", this.changePassword).then((data) =>{
        console.log(data);
      });
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
