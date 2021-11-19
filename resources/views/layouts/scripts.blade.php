<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/plugins/yearpicker/dist/yearpicker.js') }}"></script>

<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}

<script>
    Livewire.on('closeModal', () => $('.modal').modal('hide'));
</script>
