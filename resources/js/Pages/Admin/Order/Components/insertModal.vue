<template>
  <div class="modal fade" id="insertModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="feather icon-x"></span>
          </button>
          <h4 class="modal-title">Tambah Kategori</h4>
        </div>
        <div class="modal-body">
          <form id="insertForm">
            <div v-bind:class="'form-group'+(errors.name instanceof Array ? ' has-error' : '')">
              <label>Nama</label>
              <input class="form-control" id="nameInput" type="text" v-model="input.name">
              <span v-for="(error, i) in errors.name" v-bind:key="i" class="help-block">@{{error}}</span>
            </div>
            <div class="form-group">
              <label for="descriptionTextarea">Deskripsi</label>
              <textarea class="form-control" id="descriptionTextarea" type="text" name="description" v-model="input.description"></textarea>
            </div>
            <div v-bind:class="'form-group'+(errors.image instanceof Array ? ' has-error' : '')">
              <label>Gambar</label>
              <input class="form-control" id="imageInput" type="text" v-model="input.image">
              <span v-for="(error, i) in errors.image" v-bind:key="i" class="help-block">@{{error}}</span>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" type="button" data-dismiss="modal">Batal</button>
          <button class="btn btn-primary" form="insertForm">Upload</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
let $insertModal = null;

export default {
  mounted() {
    $insertModal = $('#insertModal');
    $insertModal.modal('show');
  },
  data() {
    return {
      input: [],
      errors: []
    }
  },
  methods: {
    show() {
      $insertModal.modal('show');
    },
    hide() {
      $insertModal.modal('hide');
    }
  }
}
</script>
