<script type="text/javascript">
    // 初始化
    init();

    function init() {
        // 檢查url是否有帶入專案參數
        const url = new URL(window.location.href);
        if(url.searchParams.has('projectId')) {
            // 選取專案選項
            document.querySelector('#Select_project').value = url.searchParams.get('projectId');
            // 清除參數
            url.searchParams.delete('projectId');
            window.history.replaceState('', '', url.href);
        }
    }

    function submitForm(el) {
        const createRoute = "{{ route('TestScript_Create') }}";
        const updateRoute = "{{ route('TestScript_Update', 'id') }}";
        const submitType = el.getAttribute('data-type');
        let route = createRoute;
        let warringText = "";
        
        /* 驗證前置作業 */
        const form = document.querySelector('#Form_test_script_information');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 驗證後送出
        if(validateForm()) {
            let formData = new FormData(form);
            if(submitType === "update") {
                route = updateRoute.replace('id', el.getAttribute('data-id'));
                formData.append('_method', "PATCH");
                warringText = "注意：送出後將會清除壓測結果";
            }
            UtilSwal.formSubmit({
                text: warringText
            },() => {
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
            })
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
