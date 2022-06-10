<script type="text/javascript">
    // 初始化
    init();

    function init() {
        // 檢查url是否有帶入專案參數
        const url = new URL(window.location.href);
        if(url.searchParams.has('projectId')) {
            const projectId = url.searchParams.get('projectId');
            const projectView = "{{ route('User_Project_View', 'projectId') }}";
            // 選取專案選項
            document.querySelector('#Select_project').value = projectId;
            // 帶入返回按鈕
            const returnButton = document.querySelector('#A_return_project_view');
            returnButton.href = projectView.replace('projectId', projectId);
            // 清除參數
            url.searchParams.delete('projectId');
            window.history.replaceState('', '', url.href);
        }
        // 呼叫changeIncremental()顯示/隱藏部分項目
        const incremental = document.querySelector('input[name=testScriptIncremental]:checked');
        if(incremental) {
            changeIncremental();
        }
    }

    function changeIncremental() {
        const incremental = document.querySelector('input[name=testScriptIncremental]:checked');
        const threadTildeDiv = document.querySelector('#Div_thread_tilde');
        const endThreadDiv = document.querySelector('#Div_end_thread');
        const incrementAmountDiv = document.querySelector('#Div_increment_amount');
        if(!incremental) {
            return;
        }
        if(incremental.value === "1") {
            threadTildeDiv.classList.remove('d-none');
            endThreadDiv.classList.remove('d-none');
            endThreadDiv.querySelector('input').classList.add('necessary');
            endThreadDiv.querySelector('input').classList.add('verify-int');
            incrementAmountDiv.classList.remove('d-none');
            incrementAmountDiv.querySelector('input').classList.add('necessary');
            incrementAmountDiv.querySelector('input').classList.add('verify-int');

        }
        else {
            threadTildeDiv.classList.add('d-none');
            endThreadDiv.classList.add('d-none');
            endThreadDiv.querySelector('input').classList.remove('necessary');
            endThreadDiv.querySelector('input').classList.remove('verify-int');
            incrementAmountDiv.classList.add('d-none');
            incrementAmountDiv.querySelector('input').classList.remove('necessary');
            incrementAmountDiv.querySelector('input').classList.remove('verify-int');
        }
    }

    function submitForm(el) {
        const createRoute = "{{ route('User_TestScript_Create') }}";
        const updateRoute = "{{ route('User_TestScript_Update', 'id') }}";
        const submitType = el.getAttribute('data-type');
        let route = createRoute;
        let warringText = "";
        
        /* 驗證前置作業 */
        const form = document.querySelector('#Form_test_script_information');
        // 清除紅框
        resetValidMark(form);
        // 驗證後送出
        if(validateForm() && validateInterger()) {
            let formData = new FormData(form);
            if(submitType === "update") {
                route = updateRoute.replace('id', el.getAttribute('data-id'));
                formData.append('_method', "PATCH");
                warringText = "注意：若有上傳新腳本，送出後將會清除壓測結果";
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
        const necessaryRadios = form.querySelectorAll('.necessaryRadio');
        let isValidPass = true;
        // 驗證必填
        for(let i=0; i<necessaryInputs.length; i++) {
            if(!necessaryInputs[i].value) {
                necessaryInputs[i].classList.add('is-invalid');
                isValidPass = false;
            }
        }
        for(let i=0; i<necessaryRadios.length; i++) {
            if(!necessaryRadios[i].querySelector('input:checked')) {
                necessaryRadios[i].classList.add('custom-isvaild');
                isValidPass = false;
            }
        }
        // 錯誤訊息
        if(!isValidPass) {
            UtilSwal.frontendValidFail();
        }
        return isValidPass;
    }
    function validateInterger() {
        const form = document.querySelector('#Form_test_script_information');
        const verifyIntegers = form.querySelectorAll('.verify-int');
        let isValidPass = true;
        const INTERGER = /^[0-9]*$/;
        // 驗證資料格式
        for(let i=0; i<verifyIntegers.length; i++) {
            if(verifyIntegers[i].value === "0" || !INTERGER.test(verifyIntegers[i].value)) {
                verifyIntegers[i].classList.add('is-invalid');
                isValidPass = false;
            }
        }
        // 錯誤訊息
        if(!isValidPass) {
            UtilSwal.showFail('請輸入大於0的整數');
        }
        return isValidPass;
    }
</script>
