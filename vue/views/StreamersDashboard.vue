<template>
  <PageComponent title="Streamers Management">
    <Administration>
      <div>
        <div class="pl-4">
          <table
            id="streamer-list"
            class="
              w-full
              text-sm text-left text-gray-500
              dark:text-gray-400
              overflow-x-auto
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
                <th scope="col" class="px-6 py-3">Streamer</th>
                <th scope="col" class="px-6 py-3"></th>
              </tr>
            </thead>
          </table>
        </div>
        <div>
          <Modal v-show="showModalDelete" @close="closeModal" id="modal-user"  class="top-1/2 left-1/2">
            <h2 class="text-xl font-bold text-gray-700">
              Deleting User {{ store.state.dashboard.edit.streamer.username }}
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
      </div>
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
    };
  },
  components: {},
  methods: {
    getStreamersDashboard: function () {
      store.dispatch("getStreamersDashboard").then((data) => {
        $("#streamer-list").DataTable({
          response: true,
          data: data.data,
          searching: true,
          columns: [
            { data: "id_streamer" },
            { data: "display_name" },
            {
              data: null,
              defaultContent: '<button><i class="fa fa-trash"></i></button>',
              className: "row-remove text-red-700 dt-center",
              orderable: false,
            },
          ],
          language: {
            zeroRecords: " ",
          },
        });
      });
    },
    openModalDelete: function (e) {
      this.showModalDelete = true;
    },
        closeModal: function () {
      this.showModalDelete = false;
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
    this.getStreamersDashboard();
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

        var username = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(1)
          .text();

        store.state.dashboard.edit.streamer.id = id;
        store.state.dashboard.edit.streamer.username = username;

        $("#btd").trigger("click");
      }
    );
  },
};
</script>
