<template>
  <PageComponent title="Games">
    <div class="grid" id="topGames">
      <div v-for="topGame in topGames" :key="topGame.id">
        <div class="rounded-lg flex justify-center overflow-hidden m-1">
          <card>
            <a href="#">
              <img
                class="rounded-t-lg"
                :src="`${topGame.box_art_url}`"
                :alt="`${topGame.name}`"
              />
            </a>
            <div class="  rounded-b-lg justify-center">
              <div class=" text-center bg-gray-200 rounded-b-lg ">
                <div class="">
                  <p class="text-gray-800 whitespace-nowrap font-bold px-1 pt-2 pb-2 text-ellipsis">
                    {{ topGame.name.trim().slice(0,16) }}<span v-if="topGame.name.length > 17">...</span>
                  </p>
                </div>
                <button
                  class="
                    border border-black-600
                    rounded-lg
                    px-4
                    text-white
                    bg-gray-800
                    font-semibold
                    leading-relaxed
                    hover:bg-teal-700
                    mb-2
                  "
                >
                  Vote
                </button>
              </div>
            </div>
          </card>
        </div>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import store from "../src/store";
</script>
<script>
import fecth from "cross-fetch";
import { createElementBlock } from "@vue/runtime-core";

export default {
  name: "Games",
  data: function () {
    return {
      topGames: [],
    };
  },
  components: {},
  methods: {
  getTopGames: function () {
     store.dispatch("getTopGames").
      then((data)=>{
        console.log(data);
        this.topGames = data;
      })
  },
  },
  mounted() {
    this.getTopGames();
  },
};
</script>
