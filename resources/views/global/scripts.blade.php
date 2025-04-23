<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (Session::has('success'))
<script>
    Swal.fire({
        position: "top"
        , icon: "success"
        , title: "{{session('success')}}"
        , showConfirmButton: false
        , timer: 1500
    })

</script>
@endif
@if (Session::has('error'))
<script>
    Swal.fire({
        position: "top"
        , icon: "error"
        , title: "{{session('error')}}"
        , showConfirmButton: false
        , timer: 1500
    })

</script>
@endif
@if (Session::has('message'))
<script>
    Swal.fire({
        position: "top"
        , icon: "info"
        , title: "{{session('message')}}"
        , showConfirmButton: false
        , timer: 1500
    })

</script>
@endif
