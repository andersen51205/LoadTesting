<script type="text/javascript">

    function deleteTestResult(el) {
        UtilSwal.showWarning("功能建置中！");
        return;
        const projectId = el.getAttribute('data-projectId');
        let route = "";
        route = route.replace('projectId', projectId);

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
