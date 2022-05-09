<template>
  <PageComponent title="Users Management">
    <Administration>
      <div class="p-4 overflow-auto">
        <table
          id="user-list"
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
              <th scope="col" class="px-6 py-3">UserName</th>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Email</th>
              <th scope="col" class="px-6 py-3">Gold</th>
              <th scope="col" class="px-6 py-3"></th>
              <th scope="col" class="px-6 py-3"></th>
            </tr>
          </thead>
        </table>
        <!-- Modal formulario -->
        <div>
          <Modal v-show="showModalEdit" @close="closeModal" id="modal-user"  class="top-1/2 left-1/2 sm:w-full">
            <h2 class="text-xl font-bold text-gray-700">Edit User</h2>
            <hr />
            <div class="mt-4">
              <div class="m-2 m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="id" class="text-bold font-medium pb-2">Id:</label>
                </div>
                <div class="w-4/5 items-center">
                  <input
                    id="id"
                    name="id"
                    type="text"
                    required
                    disabled
                    class="bg-gray-300 w-full"
                    :value="`${store.state.dashboard.edit.user.id}`"
                  />
                </div>
              </div>
              <div class="m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="name" class="text-bold font-medium pb-2"
                    >Name:</label
                  >
                </div>
                <div class="w-4/5">
                  <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    class="w-full"
                    :value="`${store.state.dashboard.edit.user.name}`"
                  />
                </div>
              </div>
              <div class="m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="Username" class="text-bold font-medium pb-2"
                    >Username:</label
                  >
                </div>
                <div class="w-4/5">
                  <input
                    id="username"
                    name="name"
                    type="text"
                    required
                    class="w-full"
                    :value="`${store.state.dashboard.edit.user.username}`"
                  />
                </div>
              </div>
              <div class="m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="email" class="text-bold font-medium pb-2"
                    >Email:</label
                  >
                </div>
                <div class="w-4/5">
                  <input
                    id="email"
                    name="name"
                    type="text"
                    required
                    class="w-full"
                    :value="`${store.state.dashboard.edit.user.email}`"
                  />
                </div>
              </div>
              <div class="m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="gold" class="text-bold font-medium pb-2"
                    >Gold:</label
                  >
                </div>
                <div class="w-4/5">
                  <input
                    id="gold"
                    name="name"
                    type="text"
                    required
                    class="w-full"
                    :value="`${store.state.dashboard.edit.user.gold}`"
                  />
                </div>
              </div>
              <div class="mt-4 flex flex-row justify-center">
                <div class="mr-8">
                  <button
                    type="submit"
                    @click="editUser"
                    disabled="true"
                    id="btn-update-user"
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
                    Edit
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
                    @click="showModal = false"
                  >
                    Close
                  </button>
                </div>
              </div>
            </div>
          </Modal>
        </div>
        <div>
          <Modal v-show="showModalDelete" @close="closeModal" id="modal-user" class="top-1/2 left-1/2">
            <h2 class="text-xl font-bold text-gray-700">
              Deleting User {{ store.state.dashboard.edit.user.username }}
            </h2>
            <h2 class="text-xl font-bold text-gray-700 mt-6">Are you sure?</h2>
            <div class="mt-4 flex flex-row justify-center">
              <div class="mr-8">
                <button
                  type="submit"
                  @click="deleteUser"
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
        <button id="bte" class="hidden" @click="openModalEdit"></button>
        <button id="btd" class="hidden" @click="openModalDelete"></button>
      </div>
    </Administration>
  </PageComponent>
</template>

<style scoped>
.row-edit {
  padding: 0;
}
label {
  color: darkslategray;
  margin: auto;
}
input {
  padding-top: 10px;
  color: darkslategray;
  border-color: #374151;
  border-width: 1.7px;
  border-radius: 0.35rem;
  margin: auto;
}
button:disabled {
  background-color: #9ca3af;
}
button:disabled:hover {
  --tw-ring-offset-width: 0px;
  border-color: #9ca3af;
}
input:disabled {
  color: darkslategray;
  background-color: #d1d5db;
  border-color: #374151;
  border-width: 1.7px;
}

input:focus {
  border-color: #24728a;
  --tw-ring-color: #0f766e;
  --tw-ring-offset-width: 0px;
  box-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width))
    var(--tw-ring-color);
  border-radius: 0.35rem;
}
option {
  background-color: #24728a;
}
</style>

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
let tab;
</script>

<script>
export default {
  name: "UserDashboard",
  data: function () {
    return {
      titulo: "",
      btnCrear: false,
      btnEditar: false,
      showModalEdit: false,
      showModalDelete: false,
    };
  },
  components: {},
  methods: {
    getUsersDashboard: function () {
        store.dispatch("getUsersDashboard").then((data) => {
        $(document).ready(function () {
          $("#user-list").DataTable({
            response: true,
            data: data.data,
            searching: true,
            columns: [
              { data: "id" },
              { data: "username" },
              { data: "name" },
              { data: "email" },
              { data: "gold" },
              {
                data: null,
                defaultContent: '<button><i class="fa fa-pen"></i></button>',
                className: "row-edit text-teal-700 dt-center",
                orderable: false,
              },
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
      });
    },
    openModalEdit: function (e) {
      this.showModalDelete = false;
      this.showModalEdit = true;
      $("#btn-update-user").prop("disabled", true);
    },
    openModalDelete: function (e) {
      this.showModalEdit = false;
      this.showModalDelete = true;
      $("#btn-update-user").prop("disabled", true);
    },
    closeModal: function () {
      this.showModalEdit = false;
      this.showModalDelete = false;
    },
    editUser: function () {
      store.state.dashboard.edit.user.id = $("#id").val();
      store.state.dashboard.edit.user.name = $("#name").val();
      store.state.dashboard.edit.user.username = $("#username").val();
      store.state.dashboard.edit.user.email = $("#email").val();
      store.state.dashboard.edit.user.gold = $("#gold").val();
      store.dispatch("editUserData", store.state.dashboard.edit.user);
      this.closeModal();
      $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    deleteUser: function() {
      store.dispatch("deleteUserData", store.state.dashboard.edit.user);
      this.closeModal();
      $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    close() {
      this.$emit("close");
    },
  },
  mounted() {
    this.getUsersDashboard();
    //EventListener to set disable button from modal until there is no changes.
    $("#modal-user #name, #username, #email, #gold").on("input", function () {
      $("#btn-update-user").prop("disabled", false);
    });

    //EventListener Click on edit button.
    $("#user-list").on(
      "click",
      "tbody tr td.row-edit button .fa-pen",
      function (e) {
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

        var name = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(2)
          .text();

        var email = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(3)
          .text();

        var gold = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(4)
          .text();

        store.state.dashboard.edit.user = {
          id: id,
          username: username,
          name: name,
          email: email,
          gold: gold,
        };
        $("#bte").trigger("click");
      }
    );

    //EventListener Click on delete button.
    $("#user-list").on(
      "click",
      "tbody tr td.row-remove button .fa-trash",
      function (e) {
        store.state.dashboard.edit.user = {};
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

        store.state.dashboard.edit.user.id = id;
        store.state.dashboard.edit.user.username = username;

        $("#btd").trigger("click");
      }
    );
  },
};
</script>
