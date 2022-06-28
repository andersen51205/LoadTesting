<script type="text/javascript">

    window.onload = function() {
        init();
    };

    function init() {
        setTippyLabel(document);
    }

    function deleteTestResult(el) {
        const resultId = el.getAttribute('data-result-id');
        let route = "{{ route('Manager_TestResult_Delete', 'resultId') }}";
        route = route.replace('resultId', resultId);

        UtilSwal.formSubmit({
            title: '是否確定刪除？'
        }, function() {
            UtilSwal.showLoading();
            axios({
                url: route,
                method: "DELETE",
            }).then(async function (response) {
                // handle success
                UtilSwal.submitSuccess({ title:'刪除成功' });
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        });
    }
</script>
