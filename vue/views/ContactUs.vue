<template>
  <PageComponent title="Contact Us">
    <div class="w-full">
      <div class="p-6 rounded-lg shadow-lg">
        <form method="POST" action="https://herotofu.com/start">
          <label class="block mb-6">
            <span class="text-gray-700">Username</span>
            <input
              type="text"
              name="name"
              disabled
              class="block w-1/2 mt-1 border-gray-300 rounded-md disabled:bg-gray-200 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              v-model="user.username"
            />
          </label>
          <label class="block mb-6">
            <span class="text-gray-700">Email address</span>
            <input
              name="email"
              type="email"
              disabled
              class="block w-1/2 mt-1 border-gray-300 rounded-md disabled:bg-gray-200 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              v-model="user.email"
            />
          </label>
          <label class="block mb-6">
            <span class="text-gray-700">Message</span>
            <textarea
              name="message"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-700 focus:ring-opacity-50"
              rows="3"
              placeholder="Tell us what you're thinking about..."
            ></textarea>
          </label>
          <div class="mb-6">
            <button
              type="submit"
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
              Contact Us
            </button>
          </div>
        </form>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");
</script>
<script>
export default {
  name: "ContactUs",
  data: function () {
    return {
      user: store.state.user.data,
    };
  },
  components: {},
  methods: {
    getUserInfo() {
      store.dispatch("getUser");
      store.dispatch("getUserVotes", store.state.user.data).then((data) => {
        this.user.id = store.state.user.data.id;
        this.user.name = store.state.user.data.name;
        this.user.username = store.state.user.data.username;
        this.user.email = store.state.user.data.email;
        this.user.imageUrl = store.state.user.data.imageUrl;
        this.user.rol = store.state.user.data.rol;
        this.user.gold = store.state.user.data.gold;
        this.user.created_at = store.state.user.data.created_at.slice(0, 10);
      });
    },
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>
