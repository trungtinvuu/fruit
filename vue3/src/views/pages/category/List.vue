<template>
    <v-card-title class="d-flex align-center pa-0 pb-2">
      <router-link to="/category/add" class="add-category" color="white" >
        <v-btn
          class="text-none text-subtitle-1"
          color="primary"
          variant="flat"
        >
          <v-icon>mdi-plus</v-icon> New category
        </v-btn>
      </router-link>
      <v-spacer></v-spacer>
  
      <v-text-field
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        variant="outlined"
        hide-details
        single-line
      ></v-text-field>
    </v-card-title>
  
    <v-data-table
      v-model="selected"
      :headers="headers"
      :items="categories"
      :sort-by="[{ key: 'calories', order: 'asc' }]"
      :search="search"
      show-select
      class="custom-table"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title class="ml-0">List Category</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ props }">
              <v-btn
                v-if="selected.length === 0"
                class="text-none mr-0"
                color="medium-emphasis"
                variant="outlined"
                rounded
              >
                Delete
              </v-btn>
              <v-btn
                v-else
                class="text-none mr-0"
                color="primary"
                variant="flat"
                @click="deleteAll()"
              >
                Delete
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Are you sure you want to delete all?</span>
              </v-card-title>
  
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="close">
                  Cancel
                </v-btn>
                <v-btn color="blue-darken-1" variant="text" @click="save">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <router-link :to="`/category/${item.id}`">
            <v-icon size="small" >
                mdi-pencil
            </v-icon>
        </router-link>
        <v-icon size="small" @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
      <template v-slot:item.name="{ item }">
        <b v-html="render(item.level)"></b> {{ item.name }}
      </template>
    </v-data-table>
  </template>
  
<script>
import axiosInstance from '@/store/axiosInstance';
import Config from '@/store/config';
import { myMixin } from '@/store/mixin';

export default {
  mixins: [myMixin],
  data: () => ({
    search: '',
    dialog: false,
    dialogDelete: false,
    selected: [],
    headers: [
      { title: 'Name', align: 'start', sortable: false, key: 'name' },
      { title: 'Date', key: 'created_at' },
      { title: 'Actions', key: 'actions', sortable: false },
    ],
    categories: [],
    editedIndex: -1,
    editedItem: {
      name: '',
      calories: 0,
    },
    defaultItem: {
      name: '',
      calories: 0,
    },
  }),

  computed: {
    formLevel(level) {
      return level
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
    }
  },

  created() {
    this.initialize()
  },

  methods: {

    async initialize() {
      const response = await axiosInstance.get(Config.API_ENDPOINT+'/category');
      this.categories = response.data;
    },

    deleteAll() {
      this.dialog = true
    },

    deleteItem(item) {
      this.editedIndex = this.categories.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      axiosInstance.delete(Config.API_ENDPOINT + '/category/' + this.editedItem.id)
      .then(response => {
        this.initialize();
      })
      .catch(error => {
        console.error('Error deleting category:', error);
      });

      this.closeDelete()
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save() {
      const data = {
        "list" : this.selected
      };

      axiosInstance.post(Config.API_ENDPOINT + '/categoryDeleteAll/' , data)
        .then(response => {
          this.initialize();
        })
        .catch(error => {
          console.error('Error deleting category:', error);
        });
      this.close()
    },
  },
}
</script>

<style >
.add-category{
  text-decoration: none;
}
</style>
