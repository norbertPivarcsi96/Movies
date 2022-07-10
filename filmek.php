<?php
function getAllMovie($connection) {
  $getAllMovie = $connection->query("SELECT * FROM filmek");
  return $getAllMovie;
}

function insertMovie($connection, $newMovie) {
  $title = $newMovie['title'];
  $year = $newMovie['year'];
  $director = $newMovie['director'];
  $description = $newMovie['description'];
  $insertMovie = $connection->query("INSERT INTO filmek(cim, megjelenesi_ev, rendezo, leiras) VALUES ('$title', $year, '$director', '$description')");
}
function deleteMovie($connection) {
  if (isset($_GET['delete_film'])) {
      $unsetData = $_GET['delete_film'];
      $delete_filmSQL = $conn->query("DELETE FROM filmek WHERE id = $unsetData");
      if ($delete_filmSQL) {
        echo "Sikeres törlés";
      }else {
        echo "Valami hiba történ, kérjük keresse fel vevőszolgálatukat";
      }
  }
}
function connectionToDatabase() {//function csatlakozás az adatbázishoz
  $database = "127.0.0.1";
  $databaseName = "filmek";
  $username = "root";
  $password = "";

  $conn = new mysqli($database, $username, $password, $databaseName);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

$connection = connectionToDatabase();

$helper = getAllMovie($connection);

if (isset($_POST['title']) && isset($_POST['year']) && isset($_POST['director']) && isset($_POST['description'])) {
  $newMovie = array(
                    'title' => $_POST['title'],
                    'year' => $_POST['year'],
                    'director' => $_POST['director'],
                    'description' => $_POST['description']
                  );
  insertMovie($connection, $newMovie);
}

while ($row = $helper->fetch_assoc()) {
  echo "Cim: ".$row['cim']." | ";
  echo "Rendező: ".$row['rendezo']." | ";
  echo "Megjelenési év: ".$row['megjelenesi_ev']." | "."<br>";
  echo "Leírás: ".$row['leiras']."<br><br>";
  echo "<a href=adatbazis_hazifeladat.php?edit_description=".$row['id'].">Szerkesztés</a><br>";//nem kötelző a kérdőjel előtti rész
  echo "<a href=adatbazis_hazifeladat.php?delete_film=".$row['id'].">Törlés</a><br>";
}

?>
<form class="" method="post">
  <input type="text" name="title" value="" placeholder="Cím"><br>
  <input type="number" name="year" value="" placeholder="Kiadás éve"><br>
  <input type="text" name="director" value="" placeholder="Rendező"><br>
  <textarea name="description" rows="8" cols="30" placeholder="Rövid leírás"></textarea>
  <input type="submit" name="submit" value="Feltöltés">
</form>
