@include('layouts.js')
<form action="{{ url('/logout') }}" method="post" id="logout-form">
    {{ csrf_field() }}
</form>
<script>
    $(function() {
        // Berfungsi untuk disable error datatable
        $.fn.dataTable.ext.errMode = 'throw';
    });

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

    $(".logout-trigger").click(function (e) {
        e.preventDefault();
        swal({
                title: "Apakah Anda Yakin Ingin Logout",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                    $("#logout-form").submit();
                }
            })
    })

    $('.select2-all').select2();
</script>

<script type="text/javascript">

</script>

</body>
</html>