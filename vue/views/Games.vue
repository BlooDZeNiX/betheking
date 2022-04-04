<template>
  <PageComponent title="Games">
    <div class="grid" id="topGames">
      <div v-for="topGame in listOfGames" :key="topGame.id">
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
</script>
<script>
import fecth from "cross-fetch";
import { createElementBlock } from "@vue/runtime-core";

export default {
  name: "Games",
  data: function () {
    return {
      listOfGames: [],
    };
  },
  components: {},
  methods: {
    fetchGames: function () {
      let fetchLink = "https://api.twitch.tv/helix/games/top?first=100";
      fecth(fetchLink, {
        method: "get",
        headers: {
          Authorization: "Bearer e1wlww25qpoew82axu3m566feqzvaz",
          "Client-Id": "xd72gmt643nbmegt9990z4c4iuvmc1",
        },
      })
        .then(function (response) {
          return response.json();
        })
        .then((data) => {
          console.log(data.data);
          this.listOfGames = data.data;
          this.listOfGames.forEach((element) => {
            element.box_art_url = element.box_art_url
              .replace("{width}", "180")
              .replace("{height}", "240");
          });
        });
    },
  },
  mounted() {
    this.fetchGames();
  },
};
</script>
