<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-tag"></i> Kategori</h1>
      <ol class="breadcrumb">
        <li>
          <inertia-link href="/admin">
            <span class="text">Beranda</span>
          </inertia-link>
        </li>
        <li>
          <span class="text">Kategori</span>
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
                    <th style="min-width: 320px; width: 320px;">Keterangan</th>
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
@import url(/assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css);
@import url(/assets/admin/bower_components/select2/dist/css/select2.min.css);
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
    scripts.include('/assets/admin/bower_components/datatables.net/js/datatables.min.js').then(() => {
      scripts.include('/assets/admin/js/select2.min.js').then(() => {
        let no = 1;
        const deleteFormModal = this.$refs.deleteFormModal;
        const $deleteFormModal = $(deleteFormModal.$el);

        this.$dataTable = $('#dataTable').dataTable({
          dom: "<'row'<'col'B><'col'f><'col float-right'l>><'row mr-0 overflow-auto'<'col-xs-12't>><'row'<'col'i><'col float-right'p>>",
          buttons: [
            {
              className: 'btn btn-primary btn-icon btn-rounded',
              text: '<i class="feather icon-plus"></i>',
              action: () => {
                this.$inertia.visit('/admin/category/insert');
              }
            }
          ],
          columns: [
            {
              className: 'no-padding',
              data: 'category_id',
              render: data => `<div class="flex"><a class="btn btn-transparent btn-icon btn-rounded btn-update" href="/admin/category/update/${data}"><i class="feather icon-edit-2"></i></a><button class="btn btn-transparent btn-icon btn-rounded btn-delete"><i class="feather icon-trash"></i></button></div>`,
              searchable: false,
              sortable: false
            },
            {
              data: 'category_id',
              render: () => no++,
              searchable: false,
              sortable: false
            },
            {
              data: 'name'
            },
            {
              data: 'description',
              searchable: false,
              sortable: false
            },
          ],
          processing: true,
          serverSide: true,
          ajax: {
            url: '/api/admin/category'
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
                deleteFormModal.data.category_id = [data.category_id];
                deleteFormModal.data.name = data.name;

                $deleteFormModal.modal('show');
              });
            });
          },
          language: {
            search: '',
            searchPlaceholder: 'Cari'
          }
        });
        this.dataTableApi = this.$dataTable.api();

        $('.dataTables_filter').find('.input-sm').removeClass('input-sm').css({width: '320px'});
        $('[name=dataTable_length]').select2({
          minimumResultsForSearch: -1
        });
      });
    });
  }
}
</script>
