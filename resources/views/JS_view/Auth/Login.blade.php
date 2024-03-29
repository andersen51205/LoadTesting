<script type="text/javascript">
    function submitForm() {
        const route = "{{ route('Login') }}";

        /* 驗證前置作業 */
        const form = document.querySelector('#Form_login');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 驗證後送出
        if(validateForm()) {
            let formData = new FormData(form);
            
            UtilSwal.showLoading('登入中，請稍後');
            axios({
                url: route,
                method: "POST",
                data: formData,
            }).then(async function (response) {
                // handle success
                let options = {'text':''};
                if(response.data['redirectTarget']) {
                    redirectPage = response.data['redirectTarget'];
                    window.location.assign(redirectPage);
                }
                else {
                    location.reload();
                }
            })
            .catch(function (error) {
                // handle error
                let title = error.response.data['message'];
                if(error.response.status === 401) {
                    UtilSwal.showFail(title);
                }
                else if(error.response.status === 403) {
                    UtilSwal.showFail(title);
                }
                else {
                    UtilSwal.submitFail();
                }
            });
        }
    }
    function validateForm() {
        const form = document.querySelector('#Form_login');
        const necessaryInputs = form.querySelectorAll('.necessary');
        let isValidPass = true;
        // 驗證必填
        for(let i=0; i<necessaryInputs.length; i++) {
            if(!necessaryInputs[i].value) {
                necessaryInputs[i].classList.add('is-invalid');
                isValidPass = false;
            }
        }
        // 錯誤訊息
        if(!isValidPass) {
            UtilSwal.frontendValidFail();
        }
        return isValidPass;
    }
</script>
