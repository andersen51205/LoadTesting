
const defaultOptions = (title, text, icon) => {
	return {
		title,
		text,
		icon
	};
};

window.UtilSwal = {
    // 通用 Info
	showInfo: function(title = '系統提示', hintText = null) {
		Swal.fire({
			showConfirmButton: true,
			...defaultOptions(title, hintText, 'info')
		});
	},
    // 通用 Success
	showSuccess: function(title = '操作成功') {
		Swal.fire({
			showConfirmButton: true,
			...defaultOptions(title, '', 'success')
		});
	},
	// 通用 Warnning
	showWarning: function(title = '系統警告', hintText = null) {
		Swal.fire({
			showConfirmButton: true,
			...defaultOptions(title, hintText, 'warning')
		});
	},
	// 通用 Fail
	showFail: function(title = '操作失敗', hintText = null) {
		Swal.fire({
			showConfirmButton: true,
			...defaultOptions(title, hintText, 'error')
		});
	},
    // 顯示前端驗證錯誤訊息
	frontendValidFail: function(options) {
		Swal.fire({
			...defaultOptions(
				'請確實填寫所有必填欄位!',
				'(前方有加*號的輸入項目，並確定格式正確)',
				'error'
			),
			...options
		});
		return false;
	},
    // 用於表單驗證後呼叫
	formSubmit: function(options, cb) {
		Swal.fire({
			showCancelButton: true,
			...defaultOptions('是否確認儲存？', '', 'warning'),
			...options,
			cancelButtonColor: '#aaa',
			cancelButtonText: '取消',
			confirmButtonColor: '#d33',
			confirmButtonText: '確定'
		}).then(result => {
			if (result.isConfirmed) {
				UtilSwal.showLoading('資料處理中，請稍後', false);
				cb();
			}
		});
	},
    // 等待 Loading 用
	showLoading: function(
		title = '資料處理中，請稍後',
		allowOutsideClick = false
	) {
		Swal.fire({
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			},
			...defaultOptions(title, '', 'info'),
			allowOutsideClick: allowOutsideClick,
			showCloseButton: false
		});
	},
    // 接續 Fetch 成功
	submitSuccess: function(options) {
		Swal.fire({
			confirmButtonText: '確定',
			...defaultOptions('儲存成功', '自動重新載入頁面！', 'success'),
			...options
		}).then(result => {
			if (result.isConfirmed) {
				options?.redirectPage
					? window.location.assign(options.redirectPage)
					: location.reload();
			}
		});
	},
	// 接續 Fetch 失敗
	submitFail: function(options) {
		Swal.fire({
			...defaultOptions(
				'🙏 抱歉，有東西出錯了',
				'請再操作一次，若問題持續發生請回報網站管理員處理!',
				'error'
			),
			...options
		});
	},
}