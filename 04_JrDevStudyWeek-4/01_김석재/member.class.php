<?PHP
    class MEMBER
    {

        public $_SESSION, $_GET, $_POST;

        public $userNo;

        /*
         * 클래스에서 처음으로 호출되는 함수(생성자)
         * */
        public function __construct()
        {
            $this->userNo = $_SESSION['no'];
        }

        /*
         * 멤버를 등록하는 함수
         * */
        public function memberRegister()
        {
            # PDO 사용하는 전역 변수 $dbconn = new PDO("pgsql:host=117.52.153.104;dbname=edu", "edu", "zjajtmfoq");
            global $dbconn;

            # 멤버 정보를 insert 하는 쿼리문
            $sql = "insert into edumember (em_name, em_id, em_pwd, em_email, em_phone, em_address) values ('".$_POST['name']."','".$_POST['id']."', '".$_POST['password']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['address']."')";

            # PDO 사용하면 활용할 수 있는 준비구문(prepare statement). SQL 인젝션 공격을 막을 수 있고 애플리케이션의 성능이 향상됨
            $stmt = $dbconn->prepare($sql);

            # PDO Statement 객체가 가진 쿼리를 실행
            $stmt->execute();

            # POD Statement 객체가 실행한 쿼리의 결과값 가져오기
            # fetch()은 결과를 한개씩 반환함. 결과를 전부 출력하려면 반복문 사용해야함.
            # fetchAll()은 결과를 배열로 한번에 전부 반환.
            $row = $stmt->fetch();
            alertHref("회원가입이 완료 되었습니다.", "login.php");
            return $row;
        }

        /*
         * 멤버 로그인 함수
         * */
        public function memberLogin()
        {
            global $dbconn;

            # returnUrl 변수는 GET 요청의 'returnUrl' 값을 url 디코딩한 값
            $returnUrl = urldecode($_GET['returnUrl']);

            # strlen은 문자열 길이를 구하는 함수. 만약 $_GET['returnUrl']값이 없으면 returnUrl 변수는 "/"
            if(!strlen($_GET['returnUrl'])) $returnUrl = "/";

            # 멤버 로그인 select 하는 쿼리문
            $sql ="select * from edumember where em_id='{$_GET['id']}' and em_pwd = '{$_GET['password']}'";

            $stmt = $dbconn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();

            # 아이디 혹은 비밀번호 불일치 처리
            if(!$row){
                alertHref("id 혹은 비밀번호를 확인하세요.", "goBack");
                return;
            }

            # 로그인성공
            $_SESSION["name"] = $row['em_name'];
            $_SESSION["id"] = $row['em_id'];
            $_SESSION["no"] = $row['em_no'];

            # alertHref 함수는 common.func.php에 설명과 코드가 있음
            alertHref("'{$row['em_name']}'님 환영합니다.", $returnUrl);

            return;
        }

        /*
         * 로그아웃 함수
         * */
        public function memberLogOut()
        {
            # 세션에 등록된 모든 데이터를 파괴하는 함수
            session_destroy();
            alertHref("로그아웃 되었습니다.", "/");
        }

        /*
         * 멤버 정보 수정 함수
         * */
        public function memberUpdate()
        {
            global $dbconn;

            # post요청으로 받은 데이터들을 변수로 선언
            $userUpdateName = $_POST['updateName'];
            $userUpdatePwd = $_POST['updatePassword'];
            $userUpdateEmail = $_POST['updateEmail'];
            $userUpdatePhone = $_POST['updatePhone'];
            $userUpdateAddress = $_POST['updateAddress'];

            # 위에서 선언한 변수들로 멤버 정보를 수정하는 쿼리문. 마지막에 where절의 em_no와 생성자에서 선언한 세션 넘버가 같을때 동작
            $sql ="update edumember set em_pwd = '{$userUpdatePwd}', em_name = '{$userUpdateName}', em_email = '{$userUpdateEmail}', em_Phone = '{$userUpdatePhone}', em_address = '{$userUpdateAddress}' where em_no='{$this->userNo}'";

            $stmt = $dbconn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();

            alertHref("회원정보가 수정되었습니다.", "/");

            return $row;
        }

        /*
         * 멤버 탈퇴 함수
         * */
        public function memberOut()
        {
            global $dbconn;

            # 멤버 정보를 삭제하는 쿼리문. em_no가 생성자에서 선언한 세션 넘버와 같을때 동작
            $sql = "delete from edumember where em_no = '{$this->userNo}'";

            $stmt = $dbconn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();

            # 세션에 등록된 모든 데이터를 파괴하는 함수
            session_destroy();

            alertHref("회원탈퇴 되었습니다.", "/");
            return $row;
        }

        /*
         * 멤버 수정 폼에서 멤버가 가지고 있는 정보를 조회하고 값을 보여주기 위해 실행되는 함수
         * */
        public function verifyMember()
        {
            global $dbconn;
            $sql = "select * from edumember where em_no='{$this->userNo}'";

            $stmt = $dbconn->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }
    }
?>