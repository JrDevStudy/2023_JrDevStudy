<?PHP
# include = 같은 파일 여러 번 포함 가능 / 포함할 파일이 없어도 다음 코드 실행. header.inc 파일 읽어옴
include $_SERVER['DOCUMENT_ROOT']."/include/header.inc.php";

# include_once = 같은 파일 한 번만 포함 / 포함할 파일이 없어도 다음 코드 실행. class.class 파일 읽어옴
include_once $_SERVER['DOCUMENT_ROOT']. "/classes/member.class.php";

# $memberHandler 는 인스턴스, MEMBER 는 타입을 정의하는 클래스
$memberHandler = new MEMBER();

# get 의 mode 가 register 일 때 실행
if($_POST['mode'] == "register"){
    $row = $memberHandler->memberRegister();
    exit;
}

# get 의 mode 가 login 일 때 실행
if($_GET['mode'] == "login") {
    $memberHandler->memberLogin();
    exit;
}

# get 의 mode 가 logOut 일 때 실행
if($_GET['mode'] == "logOut") {
    $row = $memberHandler->memberLogOut();
    exit;
}

# post 의 mode 가 update 일 때 실행
if($_POST['mode'] == "update") {
    $row = $memberHandler->memberUpdate();
    exit;
}

# post 의 mode 가 memberOut 일 때 실행
if($_POST['mode'] == "memberOut") {

    $row = $memberHandler->memberOut();
    exit;

}











//if($_POST['mode'] == "comment") {
//
//    if($_SESSION) {
//        $sql = "insert into educomment (ec_no, em_no, ecm_comment, em_name) values ('".$_POST['postNum']."','".$_SESSION['no']."','".$_POST['commentText']."','".$_SESSION['name']."')";
//
//        $stmt = $dbconn->prepare($sql);
//        $stmt->execute();
//
//        alertHref("댓글이 작성 되었습니다.", "/board/detail.php?ec_no={$_POST['postNum']}");
//        exit;
//    } else{
//        alertHref("로그인후 이용하세요", "/member/login.php");
//        exit;
//    }
//}


?>