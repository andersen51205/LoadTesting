<script type="text/javascript">

    window.onload = function() {
        init();
    };

    function init() {
        setTippyLabel(document);
    }

    function disableUser(el) {
        const userId = el.getAttribute('data-userId');
        let route = "{{ route('User_Disable', 'userId') }}";
        route = route.replace('userId', userId);

        UtilSwal.formSubmit({
            title: '是否確定停用？'
        }, function() {
            UtilSwal.showLoading();
            axios({
                url: route,
                method: "DELETE",
            }).then(async function (response) {
                // handle success
                UtilSwal.submitSuccess({ title:'停用成功' });
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        });
    }

    function enableUser(el) {
        const userId = el.getAttribute('data-userId');
        let route = "{{ route('User_Enable', 'userId') }}";
        route = route.replace('userId', userId);

        UtilSwal.formSubmit({
            title: '是否確定啟用？'
        }, function() {
            UtilSwal.showLoading();
            axios({
                url: route,
                method: "PATCH",
            }).then(async function (response) {
                // handle success
                UtilSwal.submitSuccess({ title:'啟用成功' });
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        });
    }
</script>
