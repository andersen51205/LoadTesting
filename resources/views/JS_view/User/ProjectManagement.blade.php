<script type="text/javascript">

    function deleteProject(el) {
        const projectId = el.getAttribute('data-projectId');
        let route = "{{ route('Project_Delete', 'projectId') }}";
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
