<script type="text/javascript">
    // 初始化
    init();

    function init() {
        // 檢查url是否有帶入專案參數
        const url = new URL(window.location.href);
        if(url.searchParams.has('project')) {
            // 選取專案選項
            document.querySelector('#Select_project').value = url.searchParams.get('project');
            // 清除參數
            url.searchParams.delete('project');
            window.history.replaceState('', '', url.href);
        }
    }

    function submitForm() {
        /* 驗證前置作業 */
        const form = document.querySelector('#Form_test_script_information');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 驗證後送出
        if(validateForm()) {
            const route = "{{ route('TestScript_Create') }}";
            let formData = new FormData(form);

            UtilSwal.showLoading();
            axios({
                url: route,
                method: "POST",
                data: formData,
            }).then(async function (response) {
                // handle success
                let options = {'text':''};
                if(response.data['redirectTarget']) {
                    options['redirectPage'] = response.data['redirectTarget'];
                }
                UtilSwal.submitSuccess(options);
            })
            .catch(function (error) {
                // handle error
                UtilSwal.submitFail();
            });
        }
    }
    function validateForm() {
        const form = document.querySelector('#Form_test_script_information');
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
