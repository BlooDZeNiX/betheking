<template>
  <PageComponent title="Games Management">
    <Administration>
      <div class="p-4 overflow-auto">
        <table
          id="games-list"
          class="
            w-full
            text-sm text-left text-gray-500
            dark:text-gray-400
            overflow-x-scroll
            shadow-md
            rounded-lg
            hover
          "
        >
          <thead
            class="
              text-xs text-white
              uppercase
              bg-gray-700
              dark:bg-gray-700 dark:text-gray-400
              shadow-md
              sm:rounded-lg
            "
          >
            <tr>
              <th scope="col" class="px-6 py-3">Id</th>
              <th scope="col" class="px-6 py-3">Game</th>
              <th scope="col" class="px-6 py-3"></th>
              <th scope="col" class="px-6 py-3"></th>
            </tr>
          </thead>
        </table>
      </div>
            <div>
        <!-- Modal info -->
        <Modal
          v-show="showModalInfo"
          @close="closeModal"
          id="modal-game-info"
          class="top-1/2 left-1/2"
        >
        <div class="flex justify-center">
          <h2 class="text-xl font-bold text-gray-700">
            {{ store.state.dashboard.edit.game.name }}
          </h2>
        </div>
        <div class="flex justify-center mt-4">
          <img :src="`${store.state.dashboard.edit.game.image}`" alt="" class="mt-4">
        </div>
          <div class="mt-4 flex flex-row justify-center">
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
                @click="showModalInfo = false"
              >
                Close
              </button>
            </div>
          </div>
        </Modal>
      </div>
      <div>
        <!-- Modal delete -->
        <Modal
          v-show="showModalDelete"
          @close="closeModal"
          id="modal-game-delete"
          class="absolute w-full top-1/2 left-1/2"
        >
          <h2 class="text-xl font-bold text-gray-700">
            Deleting the Game {{ store.state.dashboard.edit.game.name }} and all
            its votes.
          </h2>
          <h2 class="text-xl font-bold text-gray-700 mt-6">Are you sure?</h2>
          <div class="mt-4 flex flex-row justify-center">
            <div class="mr-8">
              <button
                type="submit"
                @click="deleteGame"
                id="btn-delete-user"
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
                Yes
              </button>
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
                @click="showModalDelete = false"
              >
                No
              </button>
            </div>
          </div>
        </Modal>
      </div>
      <button id="bti" class="hidden" @click="getGame"></button>
      <button id="btd" class="hidden" @click="openModalDelete"></button>
    </Administration>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../src/components/PageComponent.vue";
import Administration from "../src/components/Administration.vue";
import Modal from "../src/components/Modal.vue";
import { LockClosedIcon } from "@heroicons/vue/solid";
import store from "../src/store";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
let loading = ref(false);
let errorMsg = ref("");
</script>

<script>
export default {
  name: "GamesDashboard",
  data: function () {
    return {
      showModalInfo: false,
      showModalDelete: false,
    };
  },
  components: {},
  methods: {
    getGamesDashboard: function () {
      store.dispatch("getGamesDashboard").then((data) => {
        $(document).ready(function () {
          $("#games-list").dataTable().fnClearTable();
          $("#games-list").dataTable().fnDestroy();
          $("#games-list").dataTable({
            response: true,
            data: data.data,
            searching: true,
            columns: [
              { data: "id_game" },
              { data: "name" },
              {
                data: null,
                defaultContent: '<button><i class="fa fa-info-circle"></i></button>',
                className: "row-info text-blue-700 dt-center",
                orderable: false,
                "width": "5%",
              },
              {
                data: null,
                defaultContent: '<button><i class="fa fa-trash"></i></button>',
                className: "row-remove text-red-700 dt-center",
                orderable: false,
                "width": "5%",
              },
            ],
            language: {
              zeroRecords: " ",
            },
          });
        });
      });
    },
    openModalInfo: function (e) {
      this.showModalInfo = true;
      this.showModalDelete = false;
    },
    openModalDelete: function (e) {
      this.showModalDelete = true;
      this.showModalInfo = false;
    },
    closeModal: function () {
      this.showModalDelete = false;
      this.showModalInfo = false;
    },
    getGame: function () {
      store.dispatch("getGame", store.state.dashboard.edit.game.id).then((data) => {
        console.log(data.data);
        store.state.dashboard.edit.game.image = data.data[0]['box_art_url'];
        this.openModalInfo();
      })
    },
    deleteGame: function () {
      store.dispatch("deleteGame", store.state.dashboard.edit.game);
      this.closeModal();
      $("#games-list").dataTable().fnClearTable();
      $("#games-list").dataTable().fnDestroy();
      this.getGamesDashboard();
    },
  },
  mounted() {
    if (store.state.user.data.rol == "admin"){
    this.getGamesDashboard();
    }
//EventListener Click on info icon
    $("#games-list").on(
      "click",
      "tbody tr td.row-info button .fa-info-circle",
      function (e) {
        store.state.dashboard.edit.game = {};
        var id = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(0)
          .text();

        var name = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(1)
          .text();

        store.state.dashboard.edit.game.id = id;
        store.state.dashboard.edit.game.name = name;

        $("#bti").trigger("click");
      }
    );

//EventListener Click on trash icon
    $("#games-list").on(
      "click",
      "tbody tr td.row-remove button .fa-trash",
      function (e) {
        store.state.dashboard.edit.game = {};
        var id = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(0)
          .text();

        var name = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(1)
          .text();

        store.state.dashboard.edit.game.id = id;
        store.state.dashboard.edit.game.name = name;

        $("#btd").trigger("click");
      }
    );
  },
};
</script>
