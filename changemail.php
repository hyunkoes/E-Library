<?php
    session_start();
	$tns="
		(DESCRIPTION = 
			(ADDRESS_LIST = (ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521)))
			(CONNECT_DATA = (SERVICE_NAME=XE))
		)
	";
	$dsn = "oci:dbname=".$tns.";charset=utf8";
	$username = 'c##tp';
	$password = '1234';
	$searchword = $_GET['searchword'] ?? '';
	try{
		$conn = new PDO($dsn,$username,$password);
	}catch(PDOException $e){
		echo(" ! 에러 ".$e -> getMessage());
	}
?>
<?php
  header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content="width=device-width, initial-scale=1">
	<title>EMAIL SET</title>
    <link rel="stylesheet" href="./style.css">
    <?php
      if(isset($_POST['newmail'])){//post방식으로 데이터가 보내졌는지?
        $username=$_SESSION['id'];
        $newmail=$_POST['newmail'];//post방식으로 보낸 데이터를 userpw라는 변수에 넣는다.
        $query="update customer set email='$newmail' where cno = '$username'";
        $stmt = $conn -> prepare($query);
		$stmt -> execute();
		echo "<script>alert('변경완료'); location.href='/mypage.php';</script>";
        

      }
    ?>
    </head>
    <body style="background-color: antiquewhite;">
        <h1 class="title" style="margin: 0; padding: 0;">
            Ebook Library
        </h1>
            <button type="button" style= "position:fixed; top : 10px; left : 10px;" onclick="location.href='mypage.php'" >Back</button>

        <div class="userinfo">
            <?php 
                  $cno = $_SESSION['id'];
                  $query = "select * from customer where cno='$cno'";
                    $stmt = $conn -> prepare($query);
		            $stmt -> execute();
                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            ?>
            <h3>Information</h3>
            <li><? echo $row['NAME']?></li>
            <li><?php if(!isset($row['EMAIL'])){echo "미등록";}else{ echo $row['EMAIL'];}?></li>
        </div>
        <div style="height: 130px;">
        </div>
        <div class="back" style="width: auto; margin: 0px 50px;">
            <h1>이메일 변경</h1>
            <div style="background-color:white;">
        <form method="post" action="changemail.php" >
             <div class="idpw">
                <p>
                    바꿀 이메일 <input type="text" name="newmail" class="inph">
                </p>

            </div>
                <p>
                     <button style = "font-size:20px;" type="submit" id="btn" >
                        변경
                    </button>
                    </form >
                </p>

        </div>
    </body>
</html>
