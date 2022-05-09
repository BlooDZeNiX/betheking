<template>
  <PageComponent title="Dashboard">
    <Administration>
      <div>
        <div class="w-full flex flex-row text-center">
          <div
            class="w-1/3 rounded border-gray-900 ml-2 border-2 bg-gray-700 text-white px-3 py-2 font-medium"
          >
            <div>
              <div>
                <span class="">Users</span>
              </div>
              <div>
                <span class="">Total: {{todayUsers.total}} </span>
              </div>
              <div>
            <ChartDoughnut :values="users.values" :colors="users.colors" :labels="users.labels"><p>10</p></ChartDoughnut>
              </div>
            </div>
          </div>
          <div
            class="w-1/3 rounded border-gray-900 ml-2 border-2 bg-gray-700 text-white px-3 py-2 font-medium"
          >
            <div>
              <div>
                <span class="">Votes Today</span>
              </div>
              <div>
                <span class="">Total: {{todayVotes.total}} </span>
              </div>
              <div>
            <ChartDoughnut :values="votes.values" :colors="votes.colors" :labels="votes.labels"><p>10</p></ChartDoughnut>
              </div>
            </div>
          </div>
          <div
            class="w-1/3 rounded border-gray-900 ml-2 border-2 bg-gray-700 text-white px-3 py-2 font-medium"
          >
            <div>
              <div></div>
              <div>
                <span class="">Transactions Today</span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div>
          </div>
        </div>
      </div>
    </Administration>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import Administration from "../src/components/Administration.vue";
import Modal from "../src/components/Modal.vue";
import store from "../src/store";
import { defineComponent } from "vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import { DoughnutChart } from "vue-chart-3";
import { Chart, DoughnutController, ArcElement } from "chart.js";
import { useRouter } from "vue-router";
import { ref } from "vue";
import ChartDoughnut from "../src/components/ChartDoughnut.vue";

Chart.register(DoughnutController, ArcElement);

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");
</script>

<script>
export default {
  name: "Dashboard",
  data: function () {
    return {
      todayVotes: {},
      todayUsers: {},
      todaySuscriptions: {},
      votes:{
        values:[],
        labels:["Games", "Streamers"],
        colors: ["teal", "gray"],
      },
      users:{
        values:[],
        labels:["Logged In", "Not Logged In"],
        colors: ["teal", "gray"],
      },
    }
  },
  components: {
    ChartDoughnut,
  },
  methods: {
    getTodayVotes: function () {
      store.dispatch("getTodayVotes").then((data) => {
        this.todayVotes = data.data;
      console.log(data.data)
      this.votes.values = [data.data.gameVotes, data.data.streamVotes];
      console.log(this.votes);

      });
    },
    getTodayUsers: function () {
      store.dispatch("getTodayUsers").then((data) => {
        this.todayUsers = data.data;
        this.users.values = [data.data.loged, data.data.total - data.data.loged,];
      });
    },
  },
    mounted() {
      this.getTodayVotes();
      this.getTodayUsers();
    },
};
</script>
