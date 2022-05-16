<template>
  <PageComponent title="Streamers Management">
    <Administration>
      <div class="p-4 overflow-auto">
        <table
          id="streamer-list"
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
              <th scope="col" class="px-6 pr-50 py-3">Streamer</th>
              <th scope="col" class="px-6 py-3 max-w-[5%]"></th>
              <th scope="col" class="px-6 py-3 max-w-[5%]"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div>
        <!-- Modal info -->
        <Modal
          v-show="showModalInfo"
          @close="closeModal"
          id="modal-streamer-info"
          class="top-1/2 left-1/2"
        >
          <h2 class="text-xl font-bold text-gray-700">
            {{ store.state.dashboard.edit.streamer.name }}
          </h2>
          <h3 class="font-medium text-gray-500 mt-4">
            {{ store.state.dashboard.edit.streamer.description }}
          </h3>
          <img :src="`${store.state.dashboard.edit.streamer.offline_image}`" alt="" class="mt-4">
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
          id="modal-streamer-delete"
          class="top-1/2 left-1/2"
        >
          <h2 class="text-xl font-bold text-gray-700">
            Deleting the Streamer
            {{ store.state.dashboard.edit.streamer.name }} and all its votes.
          </h2>
          <h2 class="text-xl font-bold text-gray-700 mt-6">Are you sure?</h2>
          <div class="mt-4 flex flex-row justify-center">
            <div class="mr-8">
              <button
                type="submit"
                @click="deleteStreamer"
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
      <button id="btd" class="hidden" @click="openModalDelete"></button>
      <button id="bti" class="hidden" @click="getStreamer"></button>
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
  name: "StreamersDashboard",
  data: function () {
    return {
      showModalDelete: false,
      showModalInfo: false,
    };
  },
  components: {},
  methods: {
    getStreamersDashboard: function () {
      store.dispatch("getStreamersDashboard").then((data) => {
        $(document).ready(function () {
          $("#streamer-list").dataTable().fnClearTable();
          $("#streamer-list").dataTable().fnDestroy();
          $("#streamer-list").dataTable({
            response: true,
            data: data.data,
            searching: true,
            columns: [
              { data: "id_streamer" },
              { data: "display_name" },
              {
                data: null,
                defaultContent: '<button><i class="fa fa-info-circle"></i></button>',
                className: "row-info text-blue-700 dt-center",
                orderable: false,
                "width": "10%",
              },
              {
                data: null,
                defaultContent: '<button><i class="fa fa-trash"></i></button>',
                className: "row-remove text-red-700 dt-center",
                orderable: false,
                "width": "10%",
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
    getStreamer: function () {
      store.dispatch("getStreamer", store.state.dashboard.edit.streamer.id).then((data) => {
        console.log(data.data);
        store.state.dashboard.edit.streamer.offline_image = data.data.offline_image_url;
        store.state.dashboard.edit.streamer.description = data.data.description;
        this.openModalInfo();
      })
    },
    deleteStreamer: function () {
      store.dispatch("deleteStreamer", store.state.dashboard.edit.streamer);
      this.closeModal();
      $("#streamer-list").dataTable().fnClearTable();
      $("#streamer-list").dataTable().fnDestroy();
      this.getStreamersDashboard();
    },
  },
  mounted() {
    if (store.state.user.data.rol == "admin"){
    this.getStreamersDashboard();
    }

//EventListener Click on info icon
    $("#streamer-list").on(
      "click",
      "tbody tr td.row-info button .fa-info-circle",
      function (e) {
        store.state.dashboard.edit.streamer = {};
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

        store.state.dashboard.edit.streamer.id = id;
        store.state.dashboard.edit.streamer.name = name;

        $("#bti").trigger("click");
      }
    );

    //EventListener Click on remove icon
    $("#streamer-list").on(
      "click",
      "tbody tr td.row-remove button .fa-trash",
      function (e) {
        store.state.dashboard.edit.streamer = {};
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

        store.state.dashboard.edit.streamer.id = id;
        store.state.dashboard.edit.streamer.name = name;

        $("#btd").trigger("click");
      }
    );
  },
};
</script>
