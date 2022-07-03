<script type="text/javascript">
    window.onload = function() {
        init();
    };

    function init() {
        setTippyLabel(document);
    }
    
    function deleteProject(el) {
        const projectId = el.getAttribute('data-projectId');
        let route = "{{ route('User_Project_Delete', 'projectId') }}";
        route = route.replace('projectId', projectId);

        UtilSwal.formSubmit({
            title: '是否確定刪除？',
            text: '注意：刪除專案將會連同該專案的測試腳本與測試結果一併刪除'
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
