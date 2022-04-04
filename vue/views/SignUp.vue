<template>
  <div>
       <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign Up</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        If you are registered
        <router-link :to="{name: 'Login'}" class="font-medium text-indigo-600 hover:text-indigo-500">Login</router-link>
        to your account
      </p>
    </div>
    <form class="mt-8 space-y-6" @submit="signUp">
      <div class="rounded-md shadow-sm -space-y-px">
           <div>
          <label for="name" class="sr-only">Name</label>
          <input id="name" name="name" type="text" autocomplete="name" required v-model="user.name" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Name">
        </div>
        <div>
          <label for="email-address" class="sr-only">Email address</label>
          <input id="email-address" name="email" type="email" autocomplete="email" v-model="user.email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
        </div>
        <div>
          <label for="password" class="sr-only">Password</label>
          <input id="password" name="password" type="password" autocomplete="password" v-model="user.password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
        </div>
         <div>
          <label for="password_confirmation" class="sr-only">Password confirmation</label>
          <input id="password_confirmation" name="password_confirmation" type="password" v-model="user.password_confirmation" autocomplete="password confirmation" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password Confirmation">
        </div>
      </div>

      <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/lock-closed -->
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
         Sign Up
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {LockClosedIcon} from '@heroicons/vue/solid'
import store from "../src/store";
import {useRouter} from "vue-router";

const router = useRouter();

const user = {
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
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

a {
  color: #42b983;
}

label {
  margin: 0 0.5em;
  font-weight: bold;
}

code {
  background-color: #eee;
  padding: 2px 4px;
  border-radius: 4px;
  color: #304455;
}
</style>
