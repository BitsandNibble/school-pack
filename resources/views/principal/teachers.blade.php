<x-app-layout>
  <x-breadcrumb>Teachers</x-breadcrumb>

  <livewire:principal.teachers />


  @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}">
  @endpush

  @push('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
      $(document).ready(function() {
        var table = $('#teachersTable').DataTable({
          lengthChange: true,
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });

        table.buttons().container()
          .appendTo('#teachersTable_wrapper .col-md-6:eq(1)');
      });
    </script>
  @endpush
</x-app-layout>