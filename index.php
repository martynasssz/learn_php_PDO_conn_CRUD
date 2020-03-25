<?php
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$dbname = 'pdoposts';

	// Set DSN //DNS is data source name which is basicly a string which has an acociated data structure, to decribe a connection to data source. 

	$dsn ='mysql:host='. $host.';dbname='.$dbname; //bringing a local host to a variable

	//Create a PDO instance
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //set default, an object (nereiks padavineti reiksmiu while cikle i fetch metoda)
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Rasome, kad galetume naudoti limit

	#---PDO QUERY---

	//$stmt = $pdo->query('SELECT * FROM posts'); //take a PDO instance and call query method

	//we loop throught the result and output then to a screen

	/*

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //call method fetch and in this metohd we tell how we want to be it formated 

	echo $row['title'].'<br>'; //after data fill in in database we got two entries: Post one, Post two
	}

	*/

	/*
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) { //call method fetch and in this metohd we tell how we want to be it formated //$pdo->setAttribute metodui, nors (PDO::FETCH_OBJ) vistiek gausime rezultata

	echo $row->title.'<br>'; //use object style we got two entries: Post one, Post two
	}
	
	*/

	/*
	while($row = $stmt->fetch()) { //gausime analogiska atsakyma kaip ir auksciau ir nepavade reiksmes i fetch metoda

	echo $row->title.'<br>'; 

	*/

	#-----PREPARED STATEMEMS (two main methodes: prepare & execute)-------
	
	#PREPARED STATEMEMS separetes instruction from actual data anf gives oportunity write sql instruction i a query

	//UNSEFE example
	//$sql = "SELECT * FROM post WHERE author = '$author' "; //bad example author = variable (variable come from submit or search form)

	//FETCH MULTIPLE POSTS
	//we can use positional params and name params

	//User Input
	$author = 'Martin';
	$is_published = true; 
	$id = 1;
	$limit = 1; //or limit example(last one)


	// -- Positional params --

	/*
	$sql = 'SELECT * FROM posts WHERE author = ?'; //vietoj neteisingame pavyzdyje naudoto kintamojo po author naudojame klaustuka (positional param), t.y. kintamaji $author irasysim prie execute metode
	$stmt = $pdo->prepare($sql);   //kitamajam $stmt set $pdo instance 
	$stmt->execute([$author]); //--- !!!! t\The first variable should be in array. Strict order !!!----

	$posts = $stmt->fetchAll(); //when we fetch more then one use fetchAll()

	//echo "<pre>";
	//var_dump($posts); // shows what is in this post object
	*/

	// -- Named Params --

	/*
	$sql = 'SELECT * FROM posts WHERE author = :author'; //vietoj neteisingame pavyzdyje naudoto kintamojo po author naudojame :author
	$stmt = $pdo->prepare($sql);   //kitamajam $stmt set $pdo instance 
	$stmt->execute(['author'=> $author]); // vietoj paprasto masyvo naudojame asociatyvu

	$posts = $stmt->fetchAll(); //when we fetch more the one use fetchAll()

	
	foreach($posts as $post) {
		echo $post->title . '<br>'; //jei pakeisime autoriu i Algis gausime su irasu su Algiu
	}
	*/

	// -- Use more then one variable --

	/*
	$sql = 'SELECT * FROM posts WHERE author = :author && is_published = :is_published';  
	$stmt = $pdo->prepare($sql);   
	$stmt->execute(['author'=> $author, 'is_published' => $is_published]); //isrinks is duombazessu Martin ir is_publish 1
	$posts = $stmt->fetchAll(); 
	
	foreach($posts as $post) {
		echo $post->title . '<br>'; 
	}
	*/

	// --- FETCH SINGLE POST ---

	/*

	$sql = 'SELECT * FROM posts WHERE id = :id';  
	$stmt = $pdo->prepare($sql);   
	$stmt->execute(['id'=> $id]); 
	$post = $stmt->fetch();  //because we getting one record

	*/

	//--- GET ROW COUNT ----

	/*

	$stmt = $pdo->prepare('SELECT * FROM posts WHERE author = ?');
	$stmt->execute([$author]);
	$postCount = $stmt->rowCount();

	echo $postCount; //gusime atsakyma 3;

	*/

	// ----INSERT DATA ----

	/*
	$title = 'Post Seven';
	$body = 'This is post seven';
	$author = 'Remigijus';

	$sql = 'INSERT INTO posts(title, body, author) VALUES (:title, :body, :author)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['title' => $title, 'body' =>$body, 'author' =>$author]);
	echo 'Post added';
	*/

	//----UPDATE DATA ----

	/*

	//specify what we want update
	$id = 1; //atnaujinam pirmaji ID
	$body = 'This is update post'; //pirma ID pakeisime bodi pavadinima
	
	$sql = 'UPDATE posts SET body = :body WHERE id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['body' =>$body, 'id' =>$id]);
	echo 'Post updated';

	*/

	//-----DELETE DATA -----

	/*
	$id = 3; //trinsim irasa su id=3
		
	$sql = 'DELETE FROM posts WHERE id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['id' => $id]);
	echo 'Post deleted';

	*/

	//----SEARCH DATA USING LIKE OPERATOR ----

	/*
	$search = "%f%";
	$sql = 'SELECT * FROM posts WHERE title LIKE ?';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$search]); 
	$posts = $stmt->fetchAll();

	foreach($posts as $post){
		echo $post->title . '<br>';
	}

	*/

	// ---LIMIT---

	$sql = 'SELECT * FROM posts WHERE author = ? && is_published = ? LIMIT ?'; 
	$stmt = $pdo->prepare($sql);   
	$stmt->execute([$author, $is_published, $limit]); 

	$posts = $stmt->fetchAll();

	foreach($posts as $post) {
		echo $post->title . '<br>'; //gausime post one
	}


























?>

	<!-- galime taip iterpineti i html koda, bet tai nera gera struktura-->
	<!-- iterpinejant geriau naudoti template engine ar kazka panasaus -->
	<!-- <h1><?php //echo $post->title; ?></h1>
	<p><?php //echo $post->body; ?></p> -->
	



































	











