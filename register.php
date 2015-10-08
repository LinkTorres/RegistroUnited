<?php 
if($_POST)
{
	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
       
        $output = json_encode(array( //create JSON data
            'type'=>'error',
            'text' => 'Sorry Request must be Ajax POST'
        ));
        die($output); //exit script outputting json data
    }
    //Sanitize input data using PHP filter_var().
    $nombre      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $apellido     = filter_var($_POST["apellido"], FILTER_SANITIZE_STRING);
    $empresa   = filter_var($_POST["empresa"], FILTER_SANITIZE_STRING);
    $Telefono   = filter_var($_POST["telefono"], FILTER_SANITIZE_STRING);
    $Correo  = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
 
	try { 
		$conn = new PDO ("sqlsrv:server = tcp:zfbduazijj.database.windows.net,1433; Database = cww","administrador","*3001*Xt");    
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		
		$sql = "INSERT INTO registro (Nombre,Apellido,Empresa,Telefono,Correo) VALUES (?,?,?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $nombre);
		$stmt->bindValue(2, $apellido);
		$stmt->bindValue(3, $empresa);
		$stmt->bindValue(4, $Telefono);
		$stmt->bindValue(5, $Correo);
		$stmt->execute();
		$conn->close();
	}
		catch ( PDOException $e ) 
			{
			print("Error connecting to SQL Server." );
			die(print_r($e));
			}
			//Código de ejemplo de extensión de SQL Server:
			$connectionInfo = array("UID" => "administrador@zfbduazijj", "pwd" => "*3001*Xt", "Database" =>"cww", "LoginTimeout" => 30, "Encrypt" => 1);
			$serverName = "tcp:zfbduazijj.database.windows.net,1433";
			$conn = sqlsrv_connect($serverName, $connectionInfo);

}

?>