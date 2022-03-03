// 引入套件
window.Swal = require('sweetalert2');

// 配置套件
window.Swal = Swal.mixin({
	width: 560,
	allowOutsideClick: false,
	// showCloseButton: true,
	confirmButtonText: '關閉',
	confirmButtonColor: '#2778c4' // v10(藍) > v11 (紫) 維持 v10 顏色
});
