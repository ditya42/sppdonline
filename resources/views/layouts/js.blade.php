<!-- Javascript -->
<script src="{{ asset('assets_admin/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/bundles/vendorscripts.bundle.js') }}"></script>

<!-- chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<!-- Axios -->
<script src="{{ asset('js/axios.min.js') }}"></script>

<!-- Select 2 Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<!-- Validator -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.10.2/validator.min.js"></script>

<script src="{{ asset('assets_admin/bundles/chartist.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/bundles/knob.bundle.js') }}"></script> <!-- Jquery Knob-->
<script src="{{ asset('assets_admin/bundles/flotscripts.bundle.js') }}"></script> <!-- flot charts Plugin Js -->
<script src="{{ asset('assets_admin/vendor/flot-charts/jquery.flot.selection.js') }}"></script>

<script src="{{ asset('assets_admin/bundles/mainscripts.bundle.js') }}"></script>
{{-- <script src="{{ asset('assets_admin/js/index.js') }}"></script> --}}

<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets_admin/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>

<script src="{{ asset('assets_admin/vendor/sweetalert/sweetalert.min.js') }}"></script> <!-- SweetAlert Plugin Js -->

<script src="{{ asset('assets_admin/vendor/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets_admin/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/js/pages/forms/dropify.js') }}"></script>

<script src="{{ asset('assets_admin/vendor/jquery/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery/jquery.fileupload.js') }}"></script>

<script src="{{ asset('assets_admin/vendor/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
<script src="{{ asset('assets_admin/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets_admin/vendor/toastr/toastr.js') }}"></script>
<script>
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "1500",
      "hideDuration": "1500",
      "timeOut": "1500",
      "extendedTimeOut": "1500",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
      };
</script>

<script>
  $(document).ready(function(){
    $('input').attr('autocomplete','off');
  });
</script>
<!-- Include this after the sweet alert js file -->
@include('sweet::alert')