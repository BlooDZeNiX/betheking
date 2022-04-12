<template>
  <Authlayout>
    <div>
      <div>
        <div class="h-fit flex items-center justify-center">
          <img
            class="flex items-center justify-center"
            src="../src/assets/images/betheking_login.png"
            alt="Logo"
            style="height: 10rem"
          />
        </div>
        <h2 class="mt-6 text-center text-4xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
        <p class="mt-2 font-medium text-center text-sm text-gray-900">
          Do you need an account?
          <router-link :to="{ name: 'SignUp' }" class="font-medium"
            ><span class="text-white hover-greenwater"
              >Click here</span
            ></router-link
          >
        </p>
      </div>
      <form class="mt-8 space-y-6" @submit="login">
        <input type="hidden" name="remember" value="true" />
        <div class="-space-y-px">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input
              id="email-address"
              name="email"
              type="email"
              autocomplete="email"
              required
              v-model="user.email"
              placeholder="Email address"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              required
              v-model="user.password"
              placeholder="Password"
            />
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              name="remember-me"
              type="checkbox"
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
              <p class="ml-2 font-medium text-sm text-gray-900">Remember me</p>
            </label>
          </div>

          <div class="text-sm text-white">
            <router-link
              :to="{ name: 'PasswordRecovery' }"
              class="font-medium text-indigo-600 hover:text-indigo-500"
            >
              <span class="text-white hover-greenwater"
                >Forgot your password?</span
              ></router-link
            >
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
            </span>
            Sign in
          </button>
        </div>
      </form>
    </div>
  </Authlayout>
</template>
<style scoped>
#email-address {
  color: darkslategray;
  border-color: gray;
  border-top-left-radius: 0.375rem;
  border-top-right-radius: 0.375rem;
  border-width: 1px;
  width: 100%;
  display: block;
  position: relative;
}
#password {
  color: darkslategray;
  border-color: gray;
  border-bottom-left-radius: 0.375rem;
  border-bottom-right-radius: 0.375rem;
  border-width: 1px;
  width: 100%;
  display: block;
  position: relative;
}
input:focus {
  border-color: #24728a;
  z-index: 10;
}
</style>
<script setup>
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
const user = {
  email: "",
  password: "",
};

let loading = ref(false);
let errorMsg = ref("");

function login(ev) {
  ev.preventDefault();
  store
    .dispatch("login", user)
    .then(() => {
      router.push({
        name: "Home",
      });
    })
    .catch((err) => {
      loading.value = false;
      errorMsg.value = err.response.data.error;
    });
}
</script>
