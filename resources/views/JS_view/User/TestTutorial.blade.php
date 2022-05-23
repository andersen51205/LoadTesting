<script type="text/javascript">
    
    function toggle(type) {
        if(type === "chromeExtension") {
            // 先淡出原本的內容
            document.querySelector('#Div_jmeter_card').classList.remove('show');
            setTimeout(function() {
                // 加上d-none才會將空間釋出(否則會是一片空白)
                document.querySelector('#Div_jmeter_card').classList.add('d-none');
                document.querySelector('#Div_chrome_extension').classList.remove('d-none');
                document.querySelector('#Div_chrome_extension').classList.add('show');
            }, 200);
        }
        if(type === "jmeter") {
            document.querySelector('#Div_chrome_extension').classList.remove('show');
            setTimeout(function() {
                document.querySelector('#Div_chrome_extension').classList.add('d-none');
                document.querySelector('#Div_jmeter_card').classList.add('show');
                document.querySelector('#Div_jmeter_card').classList.remove('d-none');
            }, 200);
        }
    }
</script>
