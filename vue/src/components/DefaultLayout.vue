<template>
  <div class="min-h-screen">
    <div>
      <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-24">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <router-link :to="{ name: 'Home' }">
                  <img
                    src="../assets/images/betheking.png"
                    alt="Logo"
                    style="height: 5rem"
                  />
                </router-link>
              </div>
              <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                  <router-link
                    v-for="item in navigation"
                    :key="item.name"
                    :to="item.to"
                    active-class=""
                    :class="[
                      this.$route.name === item.to.name
                        ? 'bg-gray-700 text-white border-2 border-teal-700'
                        : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                      'px-3 py-2 rounded-md text-sm font-medium',
                    ]"
                    >{{ item.name }}</router-link
                  >
                </div>
              </div>
            </div>
            <div class="hidden md:block">
              <div class="ml-4 flex items-center md:ml-6">
                <div class="float-right text-gray-600">
                  <input
                    class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none focus:ring focus:ring-teal-700 focus:border-gray-900"
                    type="search"
                    name="search"
                    placeholder="Search"
                  />
                  <button type="submit" class="relative">
                    <svg
                      class="text-gray-600 h-4 w-4 fill-current absolute right-2 bottom-0"
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      version="1.1"
                      id="Capa_1"
                      x="0px"
                      y="0px"
                      viewBox="0 0 56.966 56.966"
                      style="enable-background: new 0 0 56.966 56.966"
                      xml:space="preserve"
                      width="512px"
                      height="512px"
                    >
                      <path
                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"
                      />
                    </svg>
                  </button>
                </div>
                <!-- Profile dropdown -->
                <Menu as="div" class="ml-3 relative">
                  <div>
                    <MenuButton
                      class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                    >
                      <span class="sr-only">Open user menu</span>
                      <img
                        class="h-8 w-8 rounded-full hover:ring hover:ring-teal-700 hover:border-gray-900"
                        :src="user.imageUrl"
                        alt=""
                      />
                    </MenuButton>
                  </div>
                  <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                  >
                    <MenuItems
                      class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                    >
                      <MenuItem
                        @click="profile"
                        class="hover:text-white hover:bg-gray-400"
                      >
                        <a
                          :class="[
                            active ? 'bg-gray-100' : '',
                            'block px-4 py-2 text-sm text-gray-700 rounded-md',
                          ]"
                          >Profile</a
                        >
                      </MenuItem>
                      <MenuItem
                        @click="gold"
                        class="hover:text-white hover:bg-gray-400"
                      >
                        <a
                          :class="[
                            active ? 'bg-gray-100' : '',
                            'block px-4 py-2 text-sm text-gray-700 rounded-md',
                          ]"
                          >Gold</a
                        >
                      </MenuItem>
                      <MenuItem
                        v-if="user.rol == 'admin'"
                        @click="administration"
                        class="hover:text-white hover:bg-gray-400"
                      >
                        <a
                          :class="[
                            active ? 'bg-gray-100' : '',
                            'block px-4 py-2 text-sm text-gray-700 rounded-md',
                          ]"
                          >Administration</a
                        >
                      </MenuItem>
                      <MenuItem
                        @click="logout"
                        class="hover:text-white hover:bg-gray-400"
                      >
                        <a
                          :class="[
                            active ? 'bg-gray-100' : '',
                            'block px-4 py-2 text-sm text-gray-700 rounded-md',
                          ]"
                          >Log Out</a
                        >
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>
              </div>
            </div>
            <div class="-mr-2 flex md:hidden">
              <!-- Mobile menu button -->
              <DisclosureButton
                class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
              >
                <span class="sr-only">Open main menu</span>
                <MenuIcon
                  v-if="!open"
                  class="block h-6 w-6"
                  aria-hidden="true"
                />
                <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
              </DisclosureButton>
            </div>
          </div>
        </div>

        <DisclosurePanel class="md:hidden">
          <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <router-link
              v-for="item in navigation"
              :key="item.name"
              :to="item.to"
              active-class=""
              :class="[
                this.$route.name === item.to.name
                  ? 'bg-gray-900 text-white'
                  : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                'block px-3 py-2 rounded-md text-base font-medium',
              ]"
            >
              {{ item.name }}
            </router-link>
          </div>
          <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
              <div class="flex-shrink-0">
                <img
                  class="h-10 w-10 rounded-full"
                  v-bind:src="user.imageUrl"
                  alt="user.imageURL"
                />
              </div>
              <div class="ml-3">
                <div class="text-base font-medium leading-none text-white">
                  {{ user.name }}
                </div>
                <div class="text-sm font-medium leading-none text-gray-400">
                  {{ user.email }}
                </div>
              </div>
            </div>
            <div class="mt-3 px-2 space-y-1">
              <DisclosureButton
                @click="profile"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
              >
                <a class="hover:text-white hover:bg-gray-700">Profile</a>
              </DisclosureButton>
              <DisclosureButton
                v-if="user.rol == 'admin'"
                @click="administration"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
              >
                <a class="hover:text-white hover:bg-gray-700">Administration</a>
              </DisclosureButton>
              <DisclosureButton
                v-if="user.rol == 'admin'"
                @click="gold"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
              >
                <a class="hover:text-white hover:bg-gray-700">Gold</a>
              </DisclosureButton>
              <DisclosureButton
                @click="logout"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
              >
                <a class="hover:text-white hover:bg-gray-700">Log Out</a>
              </DisclosureButton>
            </div>
          </div>
        </DisclosurePanel>
      </Disclosure>
      <router-view></router-view>
      <!-- Footer -->
      <div class="w-full">
        <footer class="text-gray-300 bg-gray-800">
          <div
            class="container px-5 py-5 mx-auto flex md:items-center lg:items-start lg:flex-row md:flex-row flex-col md:flex-nowrap flex-wrap"
          >
            <div class="lg:w-1/5 md:w-1/5 w-full px-4">
              <img
                src="../assets/images/betheking.png"
                alt="Logo"
                style="height: 5rem"
                class="mx-auto"
              />
            </div>
            <div class="flex justify-center">
              <div
                class="flex lg:flex-row md:flex-row flex-col items-center justify-center md:space-x-20 lg:space-x-40"
              >
                <router-link
                  v-for="item in footerItems"
                  :key="item.name"
                  :to="item.to"
                  active-class=""
                  :class="[
                    this.$route.name === item.to.name
                      ? 'bg-gray-700 text-white border-2 border-teal-700'
                      : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                    'px-3 py-4 rounded-md text-sm font-medium',
                  ]"
                  ><h1>{{ item.name }}</h1></router-link
                >
              </div>
            </div>
          </div>
          <div class="bg-teal-700">
            <div
              class="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row"
            >
              <p class="text-gray-300 text-sm text-center sm:text-left">
                © 2022 BeTheKing
              </p>
              <span
                class="inline-flex sm:ml-auto sm:mt-0 mt-2 justify-center sm:justify-start"
              >
                <a class="text-gray-300">
                  <svg
                    fill="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"
                    ></path>
                  </svg>
                </a>
                <a class="ml-3 text-gray-300">
                  <svg
                    fill="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"
                    ></path>
                  </svg>
                </a>
                <a class="ml-3 text-gray-300">
                  <svg
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                  >
                    <rect
                      width="20"
                      height="20"
                      x="2"
                      y="2"
                      rx="5"
                      ry="5"
                    ></rect>
                    <path
                      d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"
                    ></path>
                  </svg>
                </a>
              </span>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { BellIcon, MenuIcon, XIcon } from "@heroicons/vue/outline";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRouter } from "vue-router";

const navigation = [
  { name: "Kings", to: { name: "Home" } },
  { name: "Streamers", to: { name: "Streamers" } },
  { name: "Games", to: { name: "Games" } },
];

const footerItems = [
  { name: "About Us", to: { name: "AboutUs" } },
  { name: "Help", to: { name: "Help" } },
  { name: "Privacy Policy", to: { name: "PrivacyPolicy" } },
  { name: "Contact Us", to: { name: "ContactUs" } },
];

const userNavigation = [
  { name: "Profile", href: "#", f: "profile" },
  { name: "Favovites", href: "/favorites", f: "user" },
  { name: "Log out", href: "#", f: "logout" },
];

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    function logout() {
      store.dispatch("logout").then(() => {
        router.push({
          name: "Login",
        });
      });
    }

    function profile() {
      router.push({
        name: "Profile",
      });
    }

    function gold() {
      router.push({
        name: "Gold",
      });
    }

    function administration() {
      router.push({
        name: "Dashboard",
      });
    }

    return {
      user: computed(() => store.state.user.data),
      navigation,
      userNavigation,
      footerItems,
      logout,
      profile,
      gold,
      administration,
    };
  },
};
</script>
