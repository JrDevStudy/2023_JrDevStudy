<?PHP
    include $_SERVER['DOCUMENT_ROOT']."/include/header.php";
?>
<html>
<head>
    <link rel="stylesheet" href="/css/form.css">
    <script>
        // 로그인 필수값 확인 함수
        function loginCheck() {
            let inputId = document.getElementById('id').value;
            let inputPassword = document.getElementById('password').value;
            if (inputId.length == 0) {
                alert("id를 입력하세요")
                return false;
            } else if(inputPassword.length == 0) {
                alert("패스워드를 입력하세요")
                return false;
            } else {
                $("#loginForm").submit();
                document.loginForm.submit();
            }
        }
    </script>
</head>
<body>
<div class="holeMemberFormDiv">
    <div class="memberFormDiv">
        <h1>로그인</h1>
        <form class="memberForm" name="firstForm" id="loginForm" action="/member/exec.php" onsubmit="return loginCheck()" method="get">
            <input type="hidden" name="returnUrl" value="<?=$_GET["returnUrl"]?>">
            <input type="hidden" name="mode" value="login"/>
            id<br>
            <input type="text" id="id" name="id"><br>
            password<br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="login">
        </form>
        <button class="joinBtn" onclick="location.href='/member/form.php'">join</button>
    </div>
</div>
</body>
</html>