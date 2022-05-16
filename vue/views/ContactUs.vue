<template>
  <PageComponent title="Contact Us">
    <div class="w-full">
      <div class="p-6 rounded-lg shadow-lg">
        <div class="block mb-6">
          <span class="text-gray-700">Username</span>
          <input
            type="text"
            name="name"
            disabled
            class="
              block
              w-1/2
              mt-1
              border-gray-300
              rounded-md
              disabled:bg-gray-200
              shadow-sm
              focus:ring focus:ring-indigo-200 focus:ring-opacity-50
            "
            v-model="user.username"
          />
        </div>
        <div class="block mb-6">
          <span class="text-gray-700">Email address</span>
          <input
            name="email"
            type="email"
            disabled
            class="
              block
              w-1/2
              mt-1
              border-gray-300
              rounded-md
              disabled:bg-gray-200
              shadow-sm
              focus:ring focus:ring-indigo-200 focus:ring-opacity-50
            "
            v-model="user.email"
          />
        </div>
        <div class="block mb-6">
          <span class="text-gray-700">Message</span>
          <textarea
          id="message"
            name="message"
            class="
              block
              w-full
              mt-1
              border-gray-300
              rounded-md
              shadow-sm
              focus:ring focus:ring-teal-700 focus:ring-opacity-50
            "
            rows="3"
            placeholder="Tell us what you're thinking about..."
          ></textarea>
        </div>
        <div class="mb-6">
          <button
            v-on:click="contactUs"
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
let show = true;
let message = "";

const contact = {
  username: store.state.user.data.username,
  email: store.state.user.data.email,
  contact_message: "",
};

function contactUs(ev) {
  ev.preventDefault();
  contact.contact_message = $('#message').val();
  store.dispatch("contactUs", contact).then((data) => {
    message = "Mail contact sent.";
    router.push({
      name: "Home",
      params: {
        show,
        message,
      },
    });
  });
}
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
    },
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>
