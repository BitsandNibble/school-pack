<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/js/pace.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

<!--notification js -->
<script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
<script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
<script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}

<script>
  Livewire.on('closeModal', () => $('.modal').modal('toggle'));
</script>
