<?PHP
# include = 같은 파일 여러 번 포함 가능 / 포함할 파일이 없어도 다음 코드 실행. header.inc 파일 읽어옴
include $_SERVER['DOCUMENT_ROOT']."/include/header.php";

# include_once = 같은 파일 한 번만 포함 / 포함할 파일이 없어도 다음 코드 실행. member.class 파일 읽어옴
include_once $_SERVER['DOCUMENT_ROOT']. "/classes/member.class.php";

# $memberHandler 는 인스턴스, MEMBER 는 타입을 정의하는 클래스
$memberHandler = new MEMBER();

# verifyMember() 함수를 호출하는 $row 변수와 실행된 함수의 배열 값을 담는 변수들
$row = $memberHandler->verifyMember();
$defaultName = $row['em_name'];
$defaultId = $row['em_id'];
$defaultPassword = $row['em_pwd'];
$defaultEmail = $row['em_email'];
$defaultPhone = $row['em_phone'];
$defaultAddress = $row['em_address'];

?>

<html>
<head>
    <link rel="stylesheet" href="/css/form.css">
</head>
<body>

<?
if($_SESSION){
?>
        <div class="holeMemberFormDiv">
            <div class="memberFormDiv">
                <h1>회원수정</h1>
                <form class="memberForm" name="updateForm" action="/member/exec.php" onsubmit="return memberUpdateCheck()" method="post">
                    <input type="hidden" name="mode" value="update"/>
                    name<br>
                    <input type="text"id="updateName" name="updateName" value="<?= $defaultName ?>"><br>
                    id<br>
                    <input type="text" id="updateId" name="updateId" value="<?= $defaultId ?>" disabled><br>
                    password<br>
                    <input type="password" id="updatePassword" name="updatePassword" ><br>
                    passwordCheck<br>
                    <input type="password" id="updatePasswordCheck" name="updatePasswordCheck" ><br>
                    email<br>
                    <input type="text" id="updateEmail" name="updateEmail" value="<?= $defaultEmail ?>"><br>
                    phone<br>
                    <input type="text" id="updatePhone" name="updatePhone" value="<?= $defaultPhone ?>"><br>
                    address<br>
                    <input type="text" id="updateAddress" name="updateAddress" value="<?= $defaultAddress ?>"><br><br>
                    <input type="submit" value="회원수정">
                </form>
            </div>
        </div>
    <?
}else {
?>
    <div class="holeMemberFormDiv">
        <div class="memberFormDiv">
            <h1 id="headerOne">회원가입</h1>
            <form
                    class="memberForm"
                    name="JoinForm"
                    onsubmit="return registerCheck()"
                    method="post"
            >
                <label for="name">이름 <span style="color: red">*</span></label>
                <input type="text" id="name" name="name" placeholder="이름을 입력하세요" />
                <p id="name_warning" style="display: none; margin-top: 0px"></p>

                <br><label for="password">비밀번호 <span style="color: red">*</span></label>
                <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="문자, 숫자, 특수문자를 포함한 패스워드를 8자 이상"
                />
                <p id="password_warning" style="display: none; margin-top: 0px"></p>

                <br><label for="passwordCheck"
                >비밀번호 확인 <span style="color: red">*</span></label
                >
                <input
                        type="password"
                        id="passwordCheck"
                        name="passwordCheck"
                        placeholder="패스워드를 다시 입력하세요"
                />
                <p id="passwordCheck_warning" style="display: none; margin-top: 0px"></p>

                <br><label for="email">이메일 <span style="color: red">*</span></label><button onclick="emailCheck(event)">메일인증</button>
                <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="이메일을 입력하세요 예시: abc@naver.com"
                        required
                />
                <p id="email_warning" style="display: none; margin-top: 0px"></p>

                <br><label for="phone">휴대폰 번호 <span style="color: red">*</span></label>
                <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="휴대폰 번호를 입력하세요 -은 생략해도 됩니다"
                />
                <p id="phone_warning" style="display: none; margin-top: 0px"></p>

                <br><label for="address">주소</label><br>
                <input
                        type="text"
                        id="address"
                        name="address"
                        placeholder="주소를 입력하세요"
                />

                <input type="submit" value="회원가입" />
            </form>
        </div>
    </div>
    <?
}
?>
</body>
</html>


<script>

    // 이름 입력 검사(정규식 조건은 없음. input 접근 이후에 값이 비어있으면 p태그가 나오게)

    // id가 name인 태그를 name으로 변수 선언
    let name = document.getElementById('name');
    // id가 정상적으로 입력되었는지 확인하기 위한 변수 선언. 기본값은 false로 지정
    let isValidName = false;
    // id가 name_warning인 태그를 nameWarning으로 변수 선언
    let nameWarning = document.getElementById('name_warning');

    // blur -> 해당 태그에 focus가 되었다가 나갈때 동작
    // addEventListener는 지정한 이벤트가 발생했을때 호출되는 함수. 여기서는 blur 이벤트가 발생하면 호출됨
    name.addEventListener('input', ()=>{
        // name 태그에 value, 즉 값이 있으면 name 스타일, nameWarning 스타일 이렇게. 값이 있다는건 조건을 만족한다는 것(유효성검사가 있는 경우 유효성 검사를 통과하면)이기 때문에 isValidName 값 = true
        if (name.value){
            name.style.borderColor='black';
            nameWarning.style.display='none';
            isValidName = true;
        } else {
            // name 태그에 value 값이 없으면 name 스타일, nameWarning 스타일 이렇게. 조건을 만족하지 못하기 때문에 isValidName 값 = false
            name.style.borderColor='red';
            nameWarning.style.display='flex';
            nameWarning.style.color='red';
            nameWarning.textContent='이름을 입력하세요';
            nameWarning.style.fontSize='15px'
            isValidName = false;
        }
    })


    document.addEventListener('DOMContentLoaded', function() {
    // id 입력 검사(정규식 조건은 없음)
    let id = document.getElementById('id');
    let idWarning = document.getElementById('id_warning');
    let isValidId = false;

    id.addEventListener('input', ()=>{
        if (id.value){
            id.style.borderColor='black';
            idWarning.style.display='none';
            isValidId = true;
        } else {
            id.style.borderColor='red';
            idWarning.style.display='flex';
            idWarning.style.color='red';
            idWarning.textContent='아이디를 입력하세요';
            idWarning.style.fontSize='15px'
            isValidId = false;
        }
    })
    });

    // 패스워드 입력 검사
    let password = document.getElementById('password');
    // (?=.*[a-zA-Z]) : 적어도 하나의 영문자가 포함되어야함
    // (?=.*\d) : 적어도 하나의 숙자가 포함되어야함
    // (?=.*[@$!%*#?&]) : 적어도 하나의 특수문자가 포함되어야 함
    // [A-Za-z\d@$!%*#?&]{8,} : 영문자, 숫자, 특수문자 중 하나 이상을 포함하는 최소 8자 이상의 문자열
    // $ : 문자열의 끝
    let passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    let passwordWarning = document.getElementById('password_warning');
    let isValidPassword = false;

    password.addEventListener('input', ()=>{
        // trim() : 문자열의 양쪽 끝 공백 제거
        let inputPassword = password.value.trim();
        // test() : 정규표현식과 문자열을 매개변수로 받아서 해당 문자열이 정규표현식과 일치하는지 검사
        if (passwordPattern.test(inputPassword)){
            password.style.borderColor='black';
            passwordWarning.style.display='none';
            isValidPassword = true;
        } else {
            password.style.borderColor='red';
            passwordWarning.style.display='flex';
            passwordWarning.style.color='red';
            passwordWarning.textContent='패스워드를 확인하세요';
            passwordWarning.style.fontSize='15px'
            isValidPassword = false;
        }
    })


    // 패스워드체크 입력 검사
    let passwordCheck = document.getElementById('passwordCheck');
    let passwordCheckWarning = document.getElementById('passwordCheck_warning');
    let isValidPasswordCheck = false;

    passwordCheck.addEventListener('input', ()=>{
        //패스워드의 value 와 패스워드체크의 value 가 동일한지 확인
        if (password.value == passwordCheck.value){
            passwordCheck.style.borderColor='black';
            passwordCheckWarning.style.display='none';
            isValidPasswordCheck = true;
        } else {
            password.style.borderColor='red';
            passwordCheckWarning.style.display='flex';
            passwordCheckWarning.style.color='red';
            passwordCheckWarning.textContent='패스워드를 확인하세요';
            passwordCheckWarning.style.fontSize='15px'
            isValidPasswordCheck = false;
        }
    })


    // 이메일 입력 검사
    let email = document.getElementById('email')
    // [a-zA-Z0-9._%+-]+ : 이메일에서 @ 앞부분. 영문 대소문자, 숫자, (. _ % + -) 중 하나 이상의 연속된 문자열로 올 수 있음
    // [a-zA-Z0-9.-]+ : 도메인 부분. 영문 대소문자, 숫자, (. -) 중 하나 이상이 연속된 문자열로 올 수 있음
    // [a-zA-Z]{2,} : 이메일 주소에서 도메인 부분의 최상의 도메인. 영문 대소문자가 두개 이상 연속된 문자열로 올 수 있음. 최상위 도메인은 두 개의 문자로 구성되어야 함. 예를 들면 abc@naver.example.com 에서 최상위 도메인은 example.com이 됨
    let emailPattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/u;
    let emailWarning = document.getElementById('email_warning');
    let isValidEmail = false;

    function emailCheck(event) {
        event.preventDefault()
    email.addEventListener('input', ()=>{
        let inputEmail = email.value.trim();
        if (emailPattern.test(inputEmail)){
            email.style.borderColor='black';
            emailWarning.style.display='none';
            isValidEmail = true;
        } else {
            email.style.borderColor='red';
            emailWarning.style.display='flex';
            emailWarning.style.color='red';
            emailWarning.textContent='이메일 주소를 확인하세요';
            emailWarning.style.fontSize='15px'
            isValidEmail = false;
        }
    })
    // 이메일 체크 fetch post
        if (isValidEmail){
            alert(email.value)
        } else {
            alert("이메일 주소가 올바르지 않습니다")
        }
    }


    // 폰 입력 검사
    let phone = document.getElementById('phone');
    // ^ : 문자열 시작 위치
    // 01 : 01로 시작한다는 뜻. 즉 02,051,032 등등 지역번호는 입력 불가
    // ([0|1|6|7|8|9]?) : [0|1|6|7|8|9]은 이 숫자들중 하나의 숫자와 일치함. ?는 앞에 []에 있는 숫자들이 있을수도, 없을수도 있다는 뜻.
    // -? : -가 있을 수도 있고 없을 수도 있음
    // ([0-9]{3,4}) : 0~9까지의 숫자 중 3자리 혹은 4자리가 일치함. ()로 묶여 있기 때문에 이 부분은 하나의 그룹으로 처리됨.
    // ([0-9]{4}) : 0~9까지의 숫자가 4자리 일치함. ()로 묶여 있기 때문에 이 부분도 하나의 그룹으로 처리됨
    // $ : 문자열의 끝을 나타냄
    let phonePattern = /^01([0|1|6|7|8|9]?)-?([0-9]{3,4})-?([0-9]{4})$/;
    let phoneWarning = document.getElementById('phone_warning');
    let isValidPhone = false;

    phone.addEventListener('input', ()=>{
        let inputPhone = phone.value.trim();
        if (phonePattern.test(inputPhone)){
            phone.style.borderColor='black';
            phoneWarning.style.display='none';
            isValidPhone = true;
        } else {
            phone.style.borderColor='red';
            phoneWarning.style.display='flex';
            phoneWarning.style.color='red';
            phoneWarning.textContent='휴대폰 번호를 확인하세요';
            phoneWarning.style.fontSize='15px';
            isValidPhone = false;
        }
    });
    console.log(isValidName, isValidPhone, isValidEmail, isValidPassword)

    // 회원가입 폼 버튼 체크 함수
    function registerCheck(){

        if(isValidName == false){
            alert("이름을 입력하세요")
            return false;
        } else if(isValidId == false) {
            alert("ID를 입력하세요")
            return false;
        } else if(isValidPassword == false) {
            alert("패스워드를 확인하세요")
            return false;
        } else if(isValidPasswordCheck == false) {
            alert("패스워드를 확인하세요")
            return false;
        } else if(isValidEmail == false) {
            alert("이메일을 확인하세요")
            return false;
        } else if(isValidPhone == false){
            alert("휴대폰 번호를 확인하세요")
            return false;
        } else {
            return true
        }
    }
</script>