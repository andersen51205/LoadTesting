<script type="text/javascript">
    function submitForm() {
        /* 驗證前置作業 */
        const form = document.querySelector('#Form_user_information');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 檢查密碼是否填寫
        const currentPassword = form.querySelector('#Input_current_password');
        const password = form.querySelector('#Input_password');
        const confirmPassword = form.querySelector('#Input_confirm_password');
        if(password.value || confirmPassword.value || currentPassword.value) {
            password.classList.add('necessary');
            confirmPassword.classList.add('necessary');
            currentPassword.classList.add('necessary');
        }
        else {
            password.classList.remove('necessary');
            confirmPassword.classList.remove('necessary');
            currentPassword.classList.remove('necessary');
        }
        // 驗證後送出
        if(validateForm() &&
           validatePassword()) {
            const route = "{{ route('Manager_Infomation_Update') }}";
            let formData = new FormData(form);
            formData.append('_method', "PATCH");

            UtilSwal.showLoading();
            axios({
                url: route,
                method: "POST",
                data: formData,
            }).then(function (response) {
                // handle success
                // "Successful" : 修改成功
                // "Current Password Wrong" : 舊密碼輸入錯誤
                // "Confirm Password Failed" : 新密碼確認失敗
                if(response['data'] === "Current Password Wrong") {
                    UtilSwal.showFail("舊密碼輸入錯誤");
                }
                else if(response['data'] === "Confirm Password Failed") {
                    UtilSwal.showFail("密碼確認失敗");
                }
                else {
                    UtilSwal.submitSuccess('儲存成功');
                }
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        }
    }
    function validateForm() {
        const form = document.querySelector('#Form_user_information');
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
        const form = document.querySelector('#Form_user_information');
        // 驗證密碼
        const currentPassword = form.querySelector('#Input_current_password');
        const password = form.querySelector('#Input_password');
        const confirmPassword = form.querySelector('#Input_confirm_password');
        if(password.value || confirmPassword.value || currentPassword.value) {
            if(password.value !== confirmPassword.value) {
                password.classList.add('is-invalid');
                confirmPassword.classList.add('is-invalid');
                UtilSwal.showFail("密碼確認失敗");
                return false;
            }
            if(password.value === currentPassword.value) {
                password.classList.add('is-invalid');
                currentPassword.classList.add('is-invalid');
                UtilSwal.showFail("新密碼與舊密碼相同");
                return false;
            }
        }
        return true;
    }
</script>
