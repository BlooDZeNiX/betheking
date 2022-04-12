<template>
  <div>
    <div>
      <h2 class="mt-6 text-center text-4xl font-extrabold text-gray-900">
        Sign Up
      </h2>
      <p class="mt-2 font-medium text-center text-sm text-gray-900">
        If you are registered
        <router-link
          :to="{ name: 'Login' }"
          class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          <span class="text-white hover-greenwater">Login</span></router-link
        >
        to your account
      </p>
    </div>
    <form class="mt-8 space-y-6" @submit="signUp">
      <input type="hidden" name="remember" value="true" />
      <div class="rounded-md shadow-sm -space-y-px">
        <div class="-space-y-px">
          <label for="name" class="sr-only">Name</label>
          <input
            id="name"
            name="name"
            type="text"
            autocomplete="name"
            required
            v-model="user.name"
            placeholder="Name"
          />
        </div>
        <div>
          <label for="email-address" class="sr-only">Email address</label>
          <input
            id="email-address"
            name="email"
            type="email"
            autocomplete="email"
            v-model="user.email"
            required
            placeholder="Email address"
          />
        </div>
        <div>
          <label for="password" class="sr-only">Password</label>
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="password"
            v-model="user.password"
            required
            placeholder="Password"
          />
        </div>
        <div>
          <label for="password_confirmation" class="sr-only"
            >Password confirmation</label
          >
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            v-model="user.password_confirmation"
            autocomplete="password confirmation"
            required
            placeholder="Password Confirmation"
          />
        </div>
      </div>
       <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              name="remember-me"
              type="checkbox"
              required
              v-model="user.remember"
              class="
                h-4
                w-4
                text-gray-700
                focus:ring-teal-700
                border-2 border-gray-700
                selected:ring-gray-700
                rounded
              "
            />
            <label for="remember-me">
              <p class="ml-2 font-medium text-sm text-gray-900">Accept
                Terms & Conditions
                </p>
            </label>
          </div>
       </div>
      <div>
       <button
            type="submit"
            class="
              group
              relative
              w-full
              flex
              justify-center
              py-2
              px-4
              border border-transparent
              text-sm
              font-medium
              rounded-md
              text-white
              bg-gray-900
              hover-greenwater
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-indigo-500
            "
          >
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/lock-closed -->
            <svg
              class="h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
          Sign Up
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";

const router = useRouter();

const user = {
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
};

function signUp(ev) {
  ev.preventDefault();
  store
    .dispatch("signUp", user)
    .then(() => {
      router.push({
        name: "Streamers",
      });
    })
    .catch((err) => {
      loading.value = false;
      errorMsg.value = err.response.data.error;
    });
}
</script>

<style scoped>
input{
  width:100%;
   color: darkslategray;
  border-color: gray;
  border-width: 1px;
  width: 100%;
  display: block;
  position: relative;
}

input:focus{
  border-color: #24728A;
  z-index: 10;
}
#name{
border-top-left-radius: 0.375rem;
  border-top-right-radius: 0.375rem;
}
#remember-me{
  width:1rem;
}
#password_confirmation{
  border-bottom-left-radius: 0.375rem;
  border-bottom-right-radius: 0.375rem;
}
</style>
