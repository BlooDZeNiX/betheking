<template>
  <PageComponent title="">
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
                      Username
                    </span>
                    <input
                      v-model="edit.username"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="text"
                      name="username"
                      id="username"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Real name
                    </span>
                    <input
                      v-model="edit.name"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="text"
                      name="name"
                      id="name"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Email
                    </span>
                    <input
                      v-model="edit.email"
                      class="border-2 border-gray-700 w-1/2 rounded-lg"
                      type="email"
                      name="email"
                      id="email"
                    />
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Password
                    </span>
                    <span
                      class="
                        w-1/2
                        border border-black-600
                        rounded-lg
                        px-4
                        py-2
                        text-white
                        text-center
                        bg-gray-800
                        font-semibold
                        leading-relaxed
                        hover-greenwater
                        pinter
                      "
                    >
                    <router-link  :to="'Edit/Password'">
                    Change Password
                    </router-link>
                    </span>
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Profile image
                    </span>
                    <div class="shrink-0">
                      <img
                        class="object-cover w-16 h-16 rounded-full"
                        :src="edit.imageUrl"
                        alt="profile photo"
                      />
                    </div>
                    <div v-if="edit.file">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M14 5l7 7m0 0l-7 7m7-7H3"
                        />
                      </svg>
                    </div>
                    <div v-if="edit.file" class="shrink-0">
                      <img
                        v-if="edit.file"
                        :src="edit.file"
                        id="actualImage"
                        class="object-cover w-16 h-16 rounded-full"
                        alt="profile photo"
                      />
                    </div>
                    <label class="block" >
                      <input
                        @change="onFileChange"
                        type="file"
                        accept="image/*"
                        class="
                          w-40
                          sm:w-40
                          text-sm text-gray-500
                          file:mr-4
                          file:py-2
                          file:px-4
                          file:rounded-lg
                          file:border-0
                          file:text-sm
                          file:font-semibold
                          file:bg-gray-800
                          file:text-white
                          hover:file:bg-cyan-700
                        "
                      />
                    </label>
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Account type
                    </span>
                    <span>{{ edit.rol }}</span>
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1">
                      Account created
                    </span>
                    <span>{{ edit.created_at }}</span>
                  </li>
                  <li class="flex items-center justify-between py-1">
                    <span class="font-bold text-xl leading-8 my-1"> Gold </span>
                    <span>{{ edit.gold }}</span>
                  </li>
                  <li class="flex justify-center py-3">
                    <button
                      v-on:click="editProfile"
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
                      Save
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
      edit: {
        id: store.state.user.data.id,
        username: store.state.user.data.username,
        name: store.state.user.data.name,
        email: store.state.user.data.email,
        imageUrl: store.state.user.data.imageUrl,
        rol: store.state.user.data.rol,
        created_at: store.state.user.data.created_at,
        gold: store.state.user.data.gold,
        file: null,
        image: null,
        file_name: "",
      },
    };
  },
  components: {},
  methods: {
    getUserInfo() {
      store.dispatch("getUser");
      store.dispatch("getUserVotes", store.state.user.data).then((data) => {
        this.edit.id = store.state.user.data.id;
        this.edit.name = store.state.user.data.name;
        this.edit.username = store.state.user.data.username;
        this.edit.email = store.state.user.data.email;
        this.edit.imageUrl = store.state.user.data.imageUrl;
        this.edit.rol = store.state.user.data.rol;
        this.edit.gold = store.state.user.data.gold;
        this.edit.created_at = store.state.user.data.created_at.slice(0,10);
      });
    },
    onFileChange(e) {
      if (e.target.files.length === 0) {
        this.edit.file = "";
      } else {
        const file = e.target.files[0];
        this.edit.image = file;
        this.edit.file = URL.createObjectURL(file);
      }
    },
    editProfile(ev) {
      ev.preventDefault();
      if (this.edit.image) {
        let formData = new FormData();
        formData.append("file", this.edit.image);
        formData.append("id", this.edit.id);
        store.dispatch("editUserImage", formData).then((data) => {
          this.file_name = data.data.file_name;
        });
      }
        store.dispatch("editUserData", this.edit).then((data) => {
          console.log(data);
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
