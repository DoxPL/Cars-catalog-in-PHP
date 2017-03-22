<?php
require_once "mysql.php";
include_once "valid.php";
?>
<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8">
		<title>Katalog samochodów</title>		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel = "stylesheet" type = "text/css" href = "css/style.css">	
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Cabin+Condensed" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script> 
			$(document).ready(function(){
				$('.menu_ico').click(function(){
					$('div#menu').show();
					$('.mlink').show();
					$('div#mobile_bar').hide();
				});
				$('.more').click(function(){
					$('.less_info').hide();
					$('.more_info').show();		
					$('.more').hide();
					$('.less').show();
				});
				$('.less').click(function(){
					$('.more_info').hide();
					$('.less_info').show();		
					$('.less').hide();
					$('.more').show();
				});
			});

		</script>
	</head>
	<body>

			<div id = "header">
				<img src = "imgs/logo.png" alt = "Katalog samochodów" class = "logo">
				
			</div>		
		
			<div id = "menu">
					<a href = "index.php" class = "mlink">Strona główna</a> |
					<a href = "cat.php" class = "mlink">Przeglądaj katalog</a> |
					<a href = "add.php" class = "mlink">Dodaj samochód</a> |
					<a href = "search.php" class = "mlink">Szukaj pojazdu</a> |
		
			</div>				
			<div id = "mobile_bar"> 
				<img src = "imgs/menu.png" class = "menu_ico">
			</div>
			<div class = "container">		
			<div id = "left">
			
				<h1 class = "htext">Dodawanie nowego pojazdu do bazy</h1>
				<div id = "car">
					<form method = "post" class = "add_form">
						<p><label>Marka samochodu</label>
						<select class="form-control" name = "comp">
						<?php
							$mysql->connect();
							$sql = "SELECT * FROM companies ORDER BY name ASC";
							$result = $mysql->conn->query($sql);
							while($row = $result->fetch_array())
							{
								echo "<option>".$row[name]."</option>";
							}
							$mysql->cls();						
						?>
						</select>	
						</p>
						<p>
						<label>Nazwa modelu</label>
						<input type="text" class="form-control" placeholder="Model" name = "model">
						</p>
						<p>
						<label>Opis samochodu</label>
						<textarea class="form-control" rows="3" name = "description"></textarea>
						</p>
						<p>
						<label>Zdjęcie</label>
						<input type = "url" name = "img" class="form-control" placeholder = "Adres URL obrazka">
						</p>
						<p>
						<input type = "submit" name = "send" class="btn btn-primary" value = "Prześlij samochód">
						</p>
					</form>	
					<?php
					if(isset($_POST['send']))
					{
						$access = false;
						$cm = $valid->checkmodel($_POST['model']);
						$cd = $valid->checkdes($_POST['description']);
						$cu = $valid->checkurl($_POST['img']);
						if($cm == 1)
						{
							if($cd == 1)
							{
								if($cu == 1)
								{
									$access = true;
								}
								else
								{
									echo "Adres URL obrazka jest nieprawidłowy.";
								}
							}
							else
							{
								echo "Opis pojazdu jest nieprawidłowy.";
							}
						}
						else
						{
							echo "Nazwa modelu jest nieprawidłowa.";
						}
						
						if($access === true)
						{
							$mod = addslashes(strip_tags(trim($_POST['model'])));
							$des = addslashes(strip_tags(trim($_POST['description'])));
							$url = addslashes(strip_tags(trim($_POST['img'])));
							$mysql->connect();
							$mysql->conn->query("SET NAMES UTF8");
							$sql = "SELECT c_id FROM companies WHERE name = '$_POST[comp]'";
							$result = $mysql->conn->query($sql)->fetch_array();
							$comp_id = $result['c_id'];
							$sql = "INSERT INTO cars (`id`, `comp`, `model`, `descr`, `img`) VALUES (NULL, '$comp_id', '$mod', '$des', '$url')";
							$result = $mysql->conn->query($sql);
							if($result == true)
							{
								echo "Dodano samochód do bazy danych.";
							}
							else
							{
								echo "Wystąpił problem podczas dodawania danych do bazy.";
							}
							$mysql->cls();
						}
					}
					?>
				</div>
			</div>
			
			<div id = "right">
				<h1 class = "htext">Lista firm</h1>
					<div id = "comp_list">
						<?php
						$mysql->connect();
						$sql = "SELECT * FROM companies ORDER BY name ASC";
						$result = $mysql->conn->query($sql);
						while ($row = $result->fetch_array())
						{
							echo "<h4><a href='cat.php?company=$row[name]'>".$row['name']."</a></h4>";
						}
						$mysql->cls();
						?>
					</div>
				
			</div>
		</div>
		<div id = "footer">
			Copyright &copy; 2016-2017 Dominik Galoch <br />
			Projekt strony internetowej wykonany na ćwiczenia z przedmiotu SPI
		</div>			
	
	</body>
</html>
	