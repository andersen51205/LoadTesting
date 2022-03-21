<script type="text/javascript">
    function startTesting(el) {
        let route = "{{ route('TestScript_Start','id') }}";
        const id = el.getAttribute('data-id');
        route = route.replace('id', id);

        UtilSwal.showLoading();
        axios({
            url: route,
            method: "GET",
        })
        .then(function (response) {
            // handle success
            UtilSwal.showSuccess();
        })
        .catch(function (error) {
            // handle error
            UtilSwal.submitFail();
        });
    }
    
</script>
