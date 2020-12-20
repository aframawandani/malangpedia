<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-box"></i> Produk</h1>
      <ol class="breadcrumb">
        <li>
          <inertia-link href="/admin">
            <span class="text">Beranda</span>
          </inertia-link>
        </li>
        <li>
          <span class="text">Produk</span>
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row h-100">
        <div class="col-md-12 h-100">
          <div class="box box-solid d-flex flex-column mh-100">
            <div class="box-body">
              <table class="table dataTable" id="dataTable" ref="dataTable">
                <thead>
                  <tr>
                    <th style="min-width: 68px; padding: 8px !important; width: 68px;">Tools</th>
                    <th style="min-width: 48px; width: 48px;">#</th>
                    <th style="min-width: 240px; width: 240px;">Nama</th>
                    <th style="min-width: 100px; width: 100px;">Jumlah</th>
                    <th style="min-width: 120px; width: 120px;">Harga</th>
                    <th style="min-width: 200px; width: 200px;">Owner</th>
                    <th style="min-width: 140px; width: 140px;">Dibuat</th>
                    <th style="min-width: 140px; width: 140px;">Diperbarui</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <delete-form-modal ref="deleteFormModal" v-bind:onsuccessdelete="deleteFormModalOnSuccessDelete" />
  </div>
</template>

<style>
@import url(/assets/admin/bower_components/datatables.net-bs/css/datatables.min.css);
@import url(/assets/admin/css/select2.min.css);
</style>

<script>
import axios from 'axios';
import scripts from '@/scripts';
import Layout from '@/Shared/Admin/Layout';
import DeleteFormModal from './Components/DeleteFormModal';

export default {
  components: {
    DeleteFormModal
  },
  layout: Layout,
  data() {
    return {
      data: [],
      $dataTable: null,
      dataTableApi: null,
    };
  },
  methods: {
    deleteFormModalOnSuccessDelete() {
      if (this.dataTableApi instanceof Object) {
        this.dataTableApi.draw();
        $(this.$refs.deleteFormModal.$el).modal('hide');
      }
    }
  },
  mounted() {
    scripts.include('/assets/admin/js/select2.min.js').then(() => {
      scripts.include('/assets/admin/bower_components/datatables.net/js/datatables.min.js').then(() => {
        let no = 1;
        const deleteFormModal = this.$refs.deleteFormModal;
        const $deleteFormModal = $(deleteFormModal.$el);

        this.$dataTable = $('#dataTable').dataTable({
          dom: "<'row'<'col'B><'col'f><'col float-right'l>><'row mr-0 overflow-auto'<'col-xs-12't>><'row'<'col'i><'col float-right'p>>",
          buttons: [
            {
              className: 'btn btn-primary',
              text: 'Tambah Produk',
              action: () => {
                this.$inertia.visit('/admin/product/insert');
              }
            }
          ],
          columns: [
            {
              className: 'no-padding',
              data: 'product_id',
              render: data => `<div class="flex"><a class="btn btn-transparent btn-icon btn-rounded btn-update" href="/admin/product/update/${data}"><i class="feather icon-edit-2"></i></a><button class="btn btn-transparent btn-icon btn-rounded btn-delete"><i class="feather icon-trash"></i></button></div>`
            },
            {
              data: 'product_id',
              render: () => no++,
              searchable: false,
              sortable: false
            },
            {
              data: 'name'
            },
            {
              data: 'quantity',
              render: data => typeof data === 'number' ? data.toString() : '-'
            },
            {
              data: 'price',
              render: data => data === null ? '-' : `Rp ${(Number.parseFloat(data)).toLocaleString('id-ID')}`
            },
            {
              data: 'owner',
              searchable: false,
              sortable: false
            },
            {
              data: 'created_at',
              render: data => {
                const date = new Date(data);

                return `${date.getDate().toString().padStart(2, '0')}-${date.getMonth().toString().padStart(2, '0')}-${date.getFullYear().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
              },
              sortable: false
            },
            {
              data: 'updated_at',
              render: data => {
                const date = new Date(data);

                return `${date.getDate().toString().padStart(2, '0')}-${date.getMonth().toString().padStart(2, '0')}-${date.getFullYear().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
              },
              sortable: false
            }
          ],
          processing: true,
          serverSide: true,
          ajax: {
            url: '/api/admin/product'
          },
          preDrawCallback: settings => {
            no = settings._iDisplayStart + 1;
          },
          drawCallback: () => {
            const rows = this.dataTableApi.rows();

            rows[0].forEach(no => {
              const row = rows.row(no);
              const data = row.data();
              const tr = row.node();

              $(tr).find('.btn-update').on('click', event => {
                event.preventDefault();
                this.$inertia.visit(event.currentTarget.href);
              });

              $(tr).find('.btn-delete').on('click', () => {
                deleteFormModal.date.product_id = [date.product_id];
                deleteFormModal.date.name = date.name;

                $deleteFormModal.modal('show');
              });
            });
          },
          language: {
            search: '',
            searchPlaceholder: 'Cari',
            lengthMenu: 'Tampilkan _MENU_ baris',
            emptyTable: 'No data available in table',
            info: 'Menampilkan _START_ - _END_ dari total _TOTAL_',
            infoEmpty: 'Menampilkan 0',
            paginate: {
                first: '<i class="feather icon-chevrons-left"></i>',
                last: '<i class="feather icon-chevrons-right"></i>',
                next: '<i class="feather icon-chevron-right"></i>',
                previous: '<i class="feather icon-chevron-left"></i>'
            },
          }
        });
        this.dataTableApi = this.$dataTable.api();

        $('.dataTables_filter').find('.input-sm').removeClass('input-sm').attr({spellcheck: false}).css({width: '320px'});
        $('[name=dataTable_length]').select2({
          minimumResultsForSearch: -1
        });
      });
    });
  }
}
</script>
