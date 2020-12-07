<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-box"></i> Produk</h1>
      <ol class="breadcrumb">
        <li>
          <inertia-link href="/admin">
            <span class="text">Home</span>
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
              <table class="table dataTable" id="dataTable">
                <thead>
                  <tr>
                    <th style="min-width: 68px; padding: 8px !important; width: 68px;">Tools</th>
                    <th style="min-width: 48px; width: 48px;">#</th>
                    <th style="min-width: 240px; width: 240px;">Nama</th>
                    <th style="min-width: 120px; width: 120px;">Jumlah</th>
                    <th style="min-width: 160px; width: 160px;">Harga</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import axios from 'axios';
import scripts from '../../../scripts';
import Layout from '../../../Shared/Admin/Layout';

export default {
  layout: Layout,
  data() {
    return {
      data: []
    };
  },
  mounted() {
    scripts.include('/assets/bower_components/datatables.net/js/datatables.min.js').then(() => {
      let no = 1;
      const insertModal = this.$refs.insertModal;
      const dataTable = $('#dataTable').dataTable({
        dom: "<'row'<'col'B><'col'f>><'row mr-0 overflow-auto'<'col-xs-12't>>",
        buttons: [
          {
            className: 'btn btn-primary btn-icon btn-rounded',
            text: '<i class="feather icon-plus"></i>',
            action: () => {
              this.$inertia.visit('/admin/product/insert');
            }
          }
        ],
        columns: [
          {
            className: 'no-padding',
            data: 'product_id',
            render: data => '<div class="flex"><button class="btn btn-transparent btn-icon btn-rounded btn-update"><i class="feather icon-edit-2"></i></button><button class="btn btn-transparent btn-icon btn-rounded btn-delete"><i class="feather icon-trash"></i></button></div>',
            searchable: false,
            sortable: false
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
            render: typeof data === 'string' || typeof data === 'number' ? Number.parseFloat(data) : '',
            searchable: false,
            sortable: false
          },
          {
            data: 'price',
            render: data => typeof data === 'string' || typeof data === 'number' ? `Rp ${Number.parseFloat(data).toLocaleString('id-ID')}` : '-',
            searchable: false,
            sortable: false
          },
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
          const rows = dataTableApi.rows();

          rows[0].forEach(no => {
            const row = rows.row(no);
            const data = row.data();
            const tr = row.node();

            $(tr).find('.btn-update').on('click', () => {
              this.$inertia.visit(`/admin/product/update/${data.product_id}`);
            });

            $(tr).find('.btn-delete').on('click', () => {
              this.$inertia.visit(`/admin/product/delete/${data.product_id}`);
            });
          });
        },
        language: {
          search: '',
          searchPlaceholder: 'Cari'
        }
      });
      const dataTableApi = dataTable.api();

      $('.dataTables_filter').find('.input-sm').removeClass('input-sm').css({width: '320px'});
    });
  }
}
</script>
