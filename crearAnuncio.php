<?php
session_start();
if ($_SESSION['admin'] != null)
   $id_admin = $_SESSION['admin'];
else
   header("Location:informativa.php");
require 'database.php';

$Error = null;

if (!empty($_POST)) {

   $anuncio = $S_post['anuncio'];
   $multimedia = $S_post['multimedia'];
   $vigencia = $S_post['vigencia'];


   // validate input
   $valid = true;

   if (empty($name)) {
      $Error = 'Anuncio vacio';
      $valid = false;
   }

   // insert data
   if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO r_anuncios (id_anuncio, contenido, multimedia, vigente) 
                                values (NULL, ?, ?, false, ?,?, current_timestamp(), ?, ?, 1, ?)";

      $q = $pdo->prepare($sql);
      $q->execute(array($anuncio, ));
      Database::disconnect();
      header("Location: informativa.html");
   }
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nuevos Anuncios</title>
   <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
   <header class="header">
      <div class="logo">
         <a href="informativa_presentacion.html"><img src="IMG/logo-expo.png" alt="Logo de la pagina"></a>
      </div>
      <h1>Announcement Form</h1>
   </header>
   <div class="ventana">
      <h1 class="label"></h1>
      <div class="container">
         <form class="login" action="crearAnuncio.php" method=POST>
            <table>

               <tr>
                  <td><label for="name">Anuncio:</label></td>
                  <td><textarea type="text" id="title" name="anuncio"
                        value="<?php echo !empty($name) ? $name : ''; ?>"></textarea></td>
               </tr>

               <tr>
                  <td><label for="poster">Link multimedia:</label></td>
                  <td><input type="text" id="link" name="poster" value="<?php echo !empty($poster) ? $poster : ''; ?>">
                  </td>
               </tr>


               <tr>
                  <td><label for="link">Vigencia:</label></td>
                  <td>
                     <select>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="11">11</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                     </select>





                     <select>
                        <option value="Enero">Enero</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option value="Octubre">Octubre</option>
                        <option value="Noviembre">Noviembre</option>
                        <option value="Diciembre">Diciembre</option>
                     </select>

                  <td><input type="text" id="link" name="poster" placeholder="Fecha: 00:00"
                        value="<?php echo !empty($poster) ? $poster : ''; ?>"></td>


            </table>
            <td><input value="Agregar anuncio" type="submit" class="btn"></td>
            <button type="button" id="cancel">Cancelar</button>
            <?php if (($Error != null)) ?>
            <div class="Error">
               <?php echo $Error; ?>
            </div>
         </form>
</body>

</html>