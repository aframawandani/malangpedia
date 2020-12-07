<template>
  <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="feather icon-x"></span>
          </button>
          <h4 class="modal-title">Konfirmasi Hapus</h4>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin akan menghapus kategori '<strong v-html="data.name"></strong>'?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" v-bind:disabled="isDeleting" @click="confirm">
            <i v-if="isDeleting" class="feather icon-loader"></i>
            <span class="text">{{isDeleting ? 'Menghapus...' : 'Ya'}}</span>
          </button>
          <button type="button" class="btn btn-default" v-bind:disabled="isDeleting" data-dismiss="modal">
            <span class="text">Tidak</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    onsuccessdelete: Function
  },
  data() {
    return {
      isDeleting: false,
      data: {
        category_id: null,
        name: null
      }
    };
  },
  methods: {
    confirm() {
      if (this.data.category_id) {
        this.isDeleting = true;

        const data = {
          _method: 'DELETE',
          category_id: this.data.category_id
        };

        axios({
          method: 'POST',
          url: '/api/admin/category',
          data
        })
        .then(response => {
          if (typeof this.onsuccessdelete === 'function') {
            this.onsuccessdelete.call(this, response);
          }
        })
        .finally(() => {
          this.isDeleting = false;
        });
      }
    }
  }
}
</script>
