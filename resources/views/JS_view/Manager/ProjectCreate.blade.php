<script type="text/javascript">
    function submitForm(el) {
        const updateRoute = "{{ route('Manager_Project_Update', 'id') }}";
        const submitType = el.getAttribute('data-submit-type');
        let route = updateRoute;
        /* 驗證前置作業 */
        const form = document.querySelector('#Form_project_information');
        // 清除紅框
        const validMarks = form.querySelectorAll('.is-invalid');
        for(let i=0; i<validMarks.length; i++) {
            validMarks[i].classList.remove('is-invalid');
        }
        // 驗證後送出
        if(validateForm()) {
            let formData = new FormData(form);
            if(submitType === 'update') {
                route = updateRoute.replace('id', el.getAttribute('data-project-id'));
                formData.append('_method', 'PATCH');
            }
            UtilSwal.formSubmit({},() => {
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
            });
        }
    }
    function validateForm() {
        const form = document.querySelector('#Form_project_information');
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
