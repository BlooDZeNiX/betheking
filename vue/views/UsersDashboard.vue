<template>
  <PageComponent title="Users Management">
    <Administration>
      <div  class="max-h-[56vh] overflow-auto">
        <div class="flex h-full justify-self-end mb-4">
          <button
            id="btau"
            @click="openModalAdd"
            class="
              border border-black-600
              rounded-lg
              px-4
              text-white
              bg-gray-800
              font-semibold
              leading-relaxed
              hover-greenwater
            "
          >
            <i class="fa-solid fa-user-plus"></i> Add
          </button>
        </div>
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
              <th scope="col" class="px-6 py-3">Enabled</th>
              <th scope="col" class="px-6 py-3"></th>
              <th scope="col" class="px-6 py-3"></th>
              <th scope="col" class="px-6 py-3"></th>
            </tr>
          </thead>
        </table>
        <!-- Modal add -->
        <div>
          <Modal
            v-show="showModalAdd"
            @close="closeModal"
            id="modal-add-user"
            class="top-1/2 left-1/2 sm:w-full"
          >
            <h2 class="text-xl font-bold text-gray-700">Add User</h2>
            <hr />
            <div class="mt-4">
              <div class="m-2 m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="id" class="text-bold font-medium pb-2"
                    >Username:</label
                  >
                </div>
                <div class="w-4/5 items-center">
                  <input
                    id="new_username"
                    v-model="newUser.username"
                    name="new_username"
                    type="text"
                    required
                    class="w-full"
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
                    id="new_name"
                    v-model="newUser.name"
                    name="new_name"
                    type="text"
                    required
                    class="w-full"
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
                    id="new_email"
                    v-model="newUser.email"
                    name="new_email"
                    type="text"
                    required
                    class="w-full"
                  />
                </div>
              </div>
              <div class="m-2 flex justify-between w-full items-center">
                <div class="w-1/5">
                  <label for="gold" class="text-bold font-medium pb-2"
                    >Password:</label
                  >
                </div>
                <div class="w-4/5">
                  <input
                    id="new_password"
                    v-model="newUser.password"
                    name="new_password"
                    type="text"
                    required
                    class="w-full"
                  />
                </div>
              </div>
              <Alert
                v-if="Object.keys(errors).length"
                class="
                  flex-col
                  items-stretch
                  text-sm
                  rounded-lg
                  text-red
                  border-2 border-red-900
                "
              >
                <div v-for="(field, i) of Object.keys(errors)" :key="i">
                  <div v-for="(error, ind) of errors[field] || []" :key="ind">
                    * {{ error.trim() }}
                  </div>
                </div>
              </Alert>
              <div class="mt-4 flex flex-row justify-center">
                <div class="mr-8">
                  <button
                    type="submit"
                    @click="addUser"
                    disabled="true"
                    id="btn-save-user"
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
                    Create
                  </button>
                </div>
                <div>
                  <button
                    type="submit"
                    id="close-new-modal"
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
                    @click="showModalAdd = false"
                  >
                    Close
                  </button>
                </div>
              </div>
            </div>
          </Modal>
        </div>
        <!-- Modal edit -->
        <div>
          <Modal
            v-show="showModalEdit"
            @close="closeModal"
            id="modal-user"
            class="top-1/2 left-1/2 sm:w-full"
          >
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
        <!-- Modal delete -->
        <div>
          <Modal
            v-show="showModalDelete"
            @close="closeModal"
            id="modal-user"
            class="top-1/2 left-1/2"
          >
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
        <!-- Modal disable -->
        <div>
          <Modal
            v-show="showModalDisable"
            @close="closeModal"
            id="modal-user"
            class="top-1/2 left-1/2"
          >
            <h2 class="text-xl font-bold text-gray-700">
              Do you want to
              <span v-if="store.state.dashboard.edit.user.active == 'Active'"
                >disable</span
              ><span v-else>enable</span> User
              {{ store.state.dashboard.edit.user.username }} ?
            </h2>
            <div class="mt-4 flex flex-row justify-center">
              <div
                v-if="store.state.dashboard.edit.user.active == 'Active'"
                class="mr-8"
              >
                <button
                  type="submit"
                  @click="disableUser"
                  id="btn-disable-user"
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
              <div v-else class="mr-8">
                <button
                  type="submit"
                  @click="enableUser"
                  id="btn-enable-user"
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
                  @click="showModalDisable = false"
                >
                  No
                </button>
              </div>
            </div>
          </Modal>
        </div>
        <button id="bte" class="hidden" @click="openModalEdit"></button>
        <button id="btd" class="hidden" @click="openModalDelete"></button>
        <button id="btdd" class="hidden" @click="openModalDisable"></button>
        <button id="bta" class="hidden" @click="update"></button>

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

let errors = ref("");
const newUser = {
  name: "",
  username: "",
  email: "",
  password: "",
};

function addUser(e) {
  store
    .dispatch("addUser", newUser)
    .then((data) => {
      $('#bta').trigger('click');

    })
    .catch((error) => {
      if (error) {
        if (error.response.status === 422) {
          errors.value = error.response.data.errors;
          console.log(errors);
        }
      }
    });
}
</script>

<script>
export default {
  name: "UserDashboard",
  data: function () {
    return {
      titulo: "",
      btnCrear: false,
      btnEditar: false,
      showModalAdd: false,
      showModalEdit: false,
      showModalDelete: false,
      showModalDisable: false,
    };
  },
  components: {},
  methods: {
    getUsersDashboard: function () {
      store.dispatch("getUsersDashboard").then((data) => {
        $(document).ready(function () {
          $("#user-list").dataTable({

            response: true,
            data: data.data,
            searching: true,
            columns: [
              { data: "id" },
              { data: "username" },
              { data: "name" },
              { data: "email" },
              { data: "gold" },
              { data: "active" },
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
              {
                data: null,
                defaultContent: '<button><i class="fa fa-ban"></i></button>',
                className: "row-disable text-yellow-700",
                orderable: false,
              },
            ],
            language: {
              zeroRecords: " ",
            },

            createdRow: function (row, data, index) {
              console.log(data);
              if (data.active == 0) {
                $("td", row).eq(5).addClass("text-danger").text("Inactive");
                $("td", row)
                  .eq(8)
                  .removeClass("text-yellow-700")
                  .addClass("text-green-700");
              } else {
                $("td", row).eq(5).addClass("text-success").text("Active");
              }
            },
          });
        });
      });
    },
    openModalAdd: function (e) {
      this.showModalDelete = false;
      this.showModalDisable = false;
      this.showModalEdit = false;
      this.showModalAdd = true;
      $("#btn-update-user").prop("disabled", true);
      $("#modal-user #btn-update-user").css("cursor", "not-allowed");
    },
    openModalEdit: function (e) {
      this.showModalDelete = false;
      this.showModalAdd = false;
      this.showModalDisable = false;
      this.showModalEdit = true;
      $("#btn-update-user").prop("disabled", true);
      $("#modal-user #btn-update-user").css("cursor", "not-allowed");
    },
    openModalDelete: function (e) {
      this.showModalEdit = false;
      this.showModalDisable = false;
      this.showModalAdd = false;
      this.showModalDelete = true;
      $("#btn-update-user").prop("disabled", true);
    },
    openModalDisable: function (e) {
      this.showModalEdit = false;
      this.showModalDelete = false;
      this.showModalAdd = false;
      this.showModalDisable = true;
      $("#btn-update-user").prop("disabled", true);
    },
    closeModal: function () {
      this.showModalAdd = false;
      this.showModalEdit = false;
      this.showModalDisable = false;
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
      // $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    deleteUser: function () {
      store.dispatch("deleteUserData", store.state.dashboard.edit.user);
      this.closeModal();
      // $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    disableUser: function () {
      store.dispatch("disableUser", store.state.dashboard.edit.user);
      this.closeModal();
      // $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    enableUser: function () {
      store.dispatch("enableUser", store.state.dashboard.edit.user);
      this.closeModal();
      // $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    update: function () {
      this.closeModal();
      // $("#user-list").dataTable().fnClearTable();
      $("#user-list").dataTable().fnDestroy();
      this.getUsersDashboard();
    },
    close() {
      this.$emit("close");
    },
  },
  mounted() {
    if (store.state.user.data.rol == "admin") {
      this.getUsersDashboard();
    }
    //EventListener to enable button from modal edit user and giving it pointer style when changes.
    $("#modal-user #name, #username, #email, #gold").on("input", function () {
      $("#btn-update-user").prop("disabled", false);
      $("#modal-user #btn-update-user").css("cursor", "pointer");
    });

    //EventListener to enable button from modal add user and giving it pointer style when changes.
    $("#modal-add_user #new_name, #new_username, #new_email, #new_password").on(
      "input",
      function () {
        $("#btn-save-user").prop("disabled", false);
        $("#modal-add-user #btn-save-user").css("cursor", "pointer");
      }
    );

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

    //EventListener Click on disable button.
    $("#user-list").on(
      "click",
      "tbody tr td.row-disable button .fa-ban",
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

        var active = $(e.target)
          .closest("button")
          .parent()
          .parent()
          .children()
          .eq(5)
          .text();

        store.state.dashboard.edit.user.id = id;
        store.state.dashboard.edit.user.username = username;
        store.state.dashboard.edit.user.active = active;

        $("#btdd").trigger("click");
      }
    );
  },
};
</script>
