<?php
include("../../class/database.php");
include("../../class/formlibrary.php");

$config = include("../../class/config.php");

$db = new Database($config['host'], $config['username'], $config['password'], $config['db_name']);
$q = "";
$sql = 'SELECT * FROM data_barang';

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $sql .= " WHERE nama LIKE '%{$q}%'";
}

$title = 'Data Barang';
$result = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
</head>

<body>
    <style>
body {
    font-family: Tahoma, sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 0;
  }
  
  .container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    
    display: grid;
    justify-content: center;
    border-radius: 20px;
  }

  h2 {
    text-align: center;
  }
  
  nav {
      background: #8ec3a5;
      margin: 0;
      padding: 8px;
  }
  
  a{
      text-decoration: none;
      padding: 5px;
      color:whitesmoke;
      background-color: #7cab92;
      border-radius: 10px;
  }
  
  table {
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  th,
  td {
    border: 1px black solid;
    padding: 7px;
  }
  
  img {
    width: 100px;
  }
  
  .about-img img {
    width: 200px;
    border-radius: 50%;
  }
  
  .tambah, .hapus, .ubah{
    text-decoration: none;
    background-color:#80aba1;
    margin: 2px;
    color: #fff;
    border-radius: 5px;
    padding: 5px;
    font-size: 15px;
  }
  
  a:hover {
    background-color: whitesmoke;
    transform: scale(0.98);
    color: black;
  }
  
  nav a:hover {
    border-radius: 5px;
    padding: 10px;
  }
  
  footer {
      margin-top: 20px;
      border-radius: 20px;
      padding: 5 50px;
      color: #D3D3D3;
  }
  
  h1 {
      background:  #89b2a4;
      margin-bottom: 0;
      padding: 10px;
      color: #fff;
      border-radius: 10px 10px 0 0;
  }
  
  .modular-list, .modular{
    text-align: left;
  }
  
  .about-image img {
    width: 100px;
    height: 150px;
    border-radius: 200%;
}
.contact-content {
    display: flex;
    justify-content: space-around;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.contact-form h2, p{
    text-align: center;
}

.contact-form input, .contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

.contact-form button {
    background-color: #98b3a0;;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.contact-form button:hover {
    background-color: #4a4949;
}
</style>
    <div class="container">
        <?php require('../../template/header.php'); ?>
        <h2>Data Barang</h2>
        <div class="main" style="padding-bottom: 20px;">
        <a class="tambah" href="tambah.php">Tambah Barang</a>
        </div>

        <div class="main" style="padding-bottom: 20px;">
        <form action="index.php" method="get">
            <div class="search">
                <label for="q" style="font-weight: bold; color:var(--darkblue); font-size: 15px;">Cari Data: </label>
                <input type="text" id="q" name="q" class="input-q" style="height: 20px; border: 1px solid var(--blue); border-radius: 4px; padding: 5px; box-shadow: 0 0 3px #000000;" value="<?php echo $q ?>" autocomplete="off">
                <input type="submit" name="submit" value="Cari" class="btn btn-primary" style="background-color: #80aba1; color: #ffffff; padding: 6px 24px; font-weight: 700; border: 1px solid var(--white); border-radius: 6px; cursor: pointer;">
            </div>
        </form>
        </div>
        <div class="main">
        <?php
        $limit = 2;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM data_barang LIMIT $offset, $limit";
        $result = $db->query($sql);

        $total_data = $db->query("SELECT COUNT(*) AS total FROM data_barang")->fetch_assoc()['total'];
        $total_pages = ceil($total_data / $limit);

        echo formlibrary::generateTable($result);

        echo "<div class='pagination' style='margin: 0 auto; width: 100%; padding: 10px 0; list-style: none; display: flex; justify-content: center;'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i' style='background-color: var(--white); color: var(--magenta); padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; text-decoration: none;'>$i</a>";
        }
        echo "</div>";
        ?>
        </div>
        <?php require('../../template/footer.php'); ?>
    </div>
</body>

</html>

<?php
// Jangan lupa untuk menutup koneksi setelah selesai menggunakannya
$db->closeConnection();
?>