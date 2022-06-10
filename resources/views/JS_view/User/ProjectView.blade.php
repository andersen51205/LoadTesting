<script type="text/javascript">
    function startTesting(el) {
        let route = "{{ route('User_TestScript_Start','id') }}";
        if(!el.hasAttribute('data-id')) {
            UtilSwal.submitFail();
            return;
        }
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
    function deleteTestScript(el) {
        let route = "{{ route('User_TestScript_Delete','id') }}";
        if(!el.hasAttribute('data-script-id')) {
            UtilSwal.submitFail();
            return;
        }
        UtilSwal.formSubmit({
            title: '確定要刪除嗎？',
        },() => {
            const id = el.getAttribute('data-script-id');
            route = route.replace('id', id);

            UtilSwal.showLoading();
            axios({
                url: route,
                method: "DELETE",
            })
            .then(function (response) {
                // handle success
                UtilSwal.submitSuccess();
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        })
    }
</script>
