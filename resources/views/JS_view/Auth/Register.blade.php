<script type="text/javascript">
    function submitForm() {
        const route = "{{ route('Register_Create') }}";

        /* 驗證前置作業 */
        const form = document.querySelector('#Form_register');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 驗證後送出
        if(validateForm() && validatePassword()) {
            let formData = new FormData(form);
            
            UtilSwal.showLoading('註冊中，請稍後');
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
                else {
                    UtilSwal.submitFail();
                }
            });
        }
    }
    function validateForm() {
        const form = document.querySelector('#Form_register');
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
    function validatePassword() {
        const passwd = document.querySelector('#Input_password');
        const confirmPasswd = document.querySelector('#Input_password_confirm');
        if(passwd.value !== confirmPasswd.value) {
            passwd.classList.add('is-invalid');
            confirmPasswd.classList.add('is-invalid');
            UtilSwal.showFail('密碼不相同');
            return false;
        }
        return true;
    }
</script>
