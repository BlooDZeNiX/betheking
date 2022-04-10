<template>
  <PageComponent title="Hall of Fame">

  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";

const router = useRouter();

store.dispatch("getUser").then(() => {
  return store.state.user.data.id;
});

</script>

<script>
export default {
  name: "Home",
  data: function () {
    return {
      topVoted:{
        streamers: [],
        games: [],
    },
    }
  },
  components: {},
  methods: {
    getTopVoted: function(){
      store.dispatch("getTopVoted").
      then((data)=>{
          console.log(data.data)
        this.topVoted = data;
      })
    },
  },
  mounted() {
    this.getTopVoted();
  },
};
</script>
