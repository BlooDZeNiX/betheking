<template>
  <div class="h-fit flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-teal-700" style="height:100vh">
    <div class="max-w-md w-full  space-y-8 bg-teal-700">
     <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { LockClosedIcon } from '@heroicons/vue/solid'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline';
import {useStore} from 'vuex';
import {computed} from 'vue';
import store from '../store/index.js';

export default {
  components: {
    LockClosedIcon,
  },
}
</script>

