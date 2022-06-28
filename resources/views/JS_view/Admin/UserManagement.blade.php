<script type="text/javascript">

    window.onload = function() {
        init();
    };

    function init() {
        setTippyLabel(document);
    }

    function disableUser(el) {
        const userId = el.getAttribute('data-userId');
        let route = "{{ route('Admin_User_Delete', 'userId') }}";
        route = route.replace('userId', userId);

        UtilSwal.formSubmit({
            title: '是否確定停用？',
            text: '停用後將無法再使用該帳號'
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
</script>
