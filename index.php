<link href='style.css' rel='stylesheet' type='text/css' >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<a href='/' class='menu'>Главная</a>
<a  href="/?name=main" class='menu'> Новости </a>
<a  href="/?name=contact" class='menu'> Обратная связь </a>
<a href="/?name=admin" class='menu'> для админа</a>
<br>
<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
<br><br>
<?php

$pdo=include 'db_pdo.php';
if (!isset($_GET['name'])){
?>
<?php 

?>
<h1 align='center'>Приветствую вас </h1>
<p align='center'>Меня зовут Жгилев Илья, класс 9-2. Этот проект был сделан на спецкурсе по web разработке в ЛШ-2018.</p>
<p>Реализованный функционал:</p>
<ul>
    <li>Возможность просматривать функционал на вкладке "Главная"</li>
    <li>Список новостей на вкладке "Новости"</li>
    <li>Возможность написать админу и указать свое имя(вкладка "Обратная связь")</li>
    <li>Возможность просматривать сообщения для админа (при наличии доступа) во вкладке "для админа"</li>
    <li>При наличии доступа к панели админа можно добавлять записи для вкладки "Новости" (вкладка "Post news")</li>
</ul>
<br><br>
<p>Используемые технологии:</p>
<ul>
    <li>html5</li>
    <li>css3</li>
    <li>bootstrap4</li>
    <li>php7</li>
    <li>mysql v. 14.14</li>
</ul>
<br><br>
<p> исходники проекта лежат <a href='https://github.com/zhgilevi/web-summer-school'>тут</a></p>
<?php }
else if ($_GET['name'] == 'main'){?>
<h1 class="align-top" align='center'> Новости админа </h1>
<?php

$sql='SELECT * FROM news';
$stmt=$pdo->prepare($sql);
$stmt->execute();
while ($row=$stmt->fetch()){
    echo $row['new_text'].'<br>';
}
 } 
else if ($_GET['name'] == 'description'){
    ?>
    для обратной связи перейдите по <a href="/?name=contact">ссылке</a>
<?php
}
else if ($_GET['name']=='contact'){?>
<h3 align='center'>Напишите админу</h3><br><br>

<form action="" method='POST' id='mes_form'>
    <input type="text" name='username' placeholder="имя" required><br>

     <input name='message' placeholder="сообщение" required><br>

     <button type='submit' class='btn btn-outline-secondary'>отправить</button>

</form>

<?php
if (isset($_POST['username']) and isset($_POST['message']) ){ ?>
     Спасибо, <?php echo  $_POST['username'] ?> <br>
    ваше сообщение:<br> <?php echo $_POST['message'] ?> <br>успешно отправлено
    <?php
 $message=$_POST['message'];
    $username=$_POST['username'];
    $sql='INSERT INTO messages (username,message) VALUES (:username,:message)';
    $stmt = $pdo->prepare($sql);
    $stmt ->execute([
'username' => $username,
'message' => $message,
]);

 }?>

 

<?php }
else if ($_GET['name'] == 'admin'){

    if (isset($_POST['user']) and isset($_POST['password'])){
    $user=$_POST['user'];
    $password=$_POST['password'];
    if ($user == 'admin' and $password == 'helloworld'){
	?>
    <h1>Welcome,admin</h1>
    <a href='/?name=news'>Post news</a><br><br>
<?php
    $sql="SELECT * FROM messages";
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
    while ($row = $stmt->fetch()) {
	if ($row['username'] != '' ){
	    echo '<strong>'.$row['username']."</strong> :  ".$row['message']."<br>";}
}


    }else{
?>

<h1>извините, вы не админ</h1>
<br><br>
<a href="/">назад</a>


<?php
}


}else{

?>
<h3 align='center'>Вход для админа</h3>
<form action="" method="POST" id='enter_form'>
<input name='user' placeholder='name' required align='center'><br><br><br><br>
<input name='password' placeholder='password' required align='center' type='password'><br><br><br><br>
<button type="submit" class="btn btn-primary" align='center'>Log in</button><br>


</form>

<?php
}
?>



<?php



}
else if ($_GET['name'] == 'news'){
?>
<form action='' method='POST'>
<textarea placeholder='новость' required name='message'></textarea>
<button type='submit'>Post</button>
</form>

<?php

if (isset($_POST['message'])){
    $text=$_POST['message'];
    $sql='INSERT INTO news (new_text) VALUES (:text)';
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
    'text' => $text,
    ]);
?>
<h4>success</h4>
<?php

}
}


 




?>




