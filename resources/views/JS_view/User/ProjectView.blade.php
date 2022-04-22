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
            UtilSwal.submitSuccess();
        })
        .catch(function (error) {
            // handle error
            UtilSwal.submitFail();
        });
    }
    
    function viewResult(el) {
        if(el.hasAttribute('data-href')) {
            location.href = el.getAttribute('data-href');
        }
        else {
            UtilSwal.submitFail();
        }
    }
    function editTestScript(el) {
        if(el.hasAttribute('data-href')) {
            location.href = el.getAttribute('data-href');
        }
        else {
            UtilSwal.submitFail();
        }
    }
</script>
