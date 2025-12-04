# Lab10Web - Pratikum PHP OOP

Nama: Marsya Nabila Putri

NIM: 312410338

Kelas: TI.24.A4

Matakuliah: Pemograman Web 1

## Tujuan Pratikum

- Memahami konsep OOP dasar di PHP.

-  Membantu class, object, dan library modular (form, database).

-   Mengimplementasikan modularisasi dalam proyek sederhana.


## Mobile.php

```php
<?php
class Mobil {
    public $warna;
    public $merk;
    public $harga;

    public function __construct($warna="Biru", $merk="BMW", $harga="10000000") {
        $this->warna = $warna;
        $this->merk = $merk;
        $this->harga = $harga;
    }

    public function gantiWarna($warnaBaru) {
        $this->warna = $warnaBaru;
    }

    public function info() {
        return "Merk: $this->merk, Warna: $this->warna, Harga: Rp " . number_format($this->harga, 0, ',', '.');
    }
}

// membuat objek mobil
$a = new Mobil(); 
$b = new Mobil("Hijau", "Toyota", 10000000);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Contoh Class Mobil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Contoh Class Mobil</h1>

    <!-- Mobil pertama -->
    <h3>Mobil pertama</h3>
    <p>Warna: <b style="color:#007bff;"><?php echo $a->warna; ?></b></p>

    <?php $a->gantiWarna("Merah"); ?>

    <p>Setelah ganti warna:</p>
    <p>Warna: <b style="color:#d40046;"><?php echo $a->warna; ?></b></p>

    <hr>

    <!-- Mobil kedua -->
    <h3>Mobil kedua</h3>
    <p>Warna: <b style="color:#0f8b4c;"><?php echo $b->warna; ?></b></p>

    <div class="btn" style="display:inline-block; background:#ff8bbd; color:#5a1a2e;">
        <?php echo $b->info(); ?>
    </div>

</div>

</body>
</html>


```


Kode tersebut membuat sebuah class bernama Mobil yang memiliki properti warna, merk, dan harga. Constructor memberi nilai default ketika object dibuat, sedangkan method gantiWarna() digunakan untuk mengubah warna mobil. Method info() mengembalikan informasi lengkap tentang mobil dalam bentuk teks.

Setelah class dibuat, program membuat dua object: mobil pertama menggunakan nilai default, dan mobil kedua dengan warna Hijau dan merk Toyota. Di bagian HTML, nilai properti mobil pertama ditampilkan, lalu warnanya diubah menjadi Merah dan ditampilkan kembali. Mobil kedua juga ditampilkan bersama informasi lengkapnya melalui method info().

<img width="958" height="765" alt="image" src="https://github.com/user-attachments/assets/6b236cb5-2681-409a-8ccd-477d122786f3" />


## Form.php
```php
<?php
class Form {
    private $fields = array();
    private $action;
    private $submit = "Submit";
    private $jumField = 0;

    public function __construct($action, $submit) {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function addField($name, $label) {
        $this->fields[$this->jumField]['name']  = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->jumField++;
    }

    public function displayForm() {
        echo "<form action='".$this->action."' method='POST'>";
        echo "<table border='0' width='100%'>";
        for ($i = 0; $i < count($this->fields); $i++) {
            echo "<tr>
                    <td align='right'>".$this->fields[$i]['label']."</td>
                    <td><input type='text' name='".$this->fields[$i]['name']."'></td>
                  </tr>";
        }
        echo "<tr><td colspan='2'><input type='submit' value='".$this->submit."'></td></tr>";
        echo "</table>";
        echo "</form>";
    }
}
?>
```



Class **Form** dipakai untuk membuat form secara otomatis.
`addField()` menambah input ke dalam form, sedangkan `displayForm()` menampilkan form beserta semua field yang sudah ditambahkan. Constructor mengatur action dan tulisan tombol submit.

## Form_input.php
```php
<?php
/**
* Program memanfaatkan Program 10.2 untuk membuat form inputan sederhana.
**/

include "form.php";

echo "<html><head><title>Mahasiswa</title></head><body>";
$form = new Form("","Input Form");
$form->addField("txtnim", "Nim");
$form->addField("txtnama", "Nama");
$form->addField("txtalamat", "Alamat");
echo "<h3>Silahkan isi form berikut ini :</h3>";
$form->displayForm();
echo "</body></html>";

?>
```


Kode tersebut menampilkan form dengan memanfaatkan class **Form** dari file *form.php*. Setelah file tersebut di-include, halaman HTML dibuat dan style.css digunakan untuk memberi tampilan. Di dalam card, program membuat object Form, lalu menambahkan tiga field yaitu NIM, Nama, dan Alamat. Method **displayForm()** dipanggil untuk menampilkan form secara otomatis sesuai struktur yang ada di class Form.

Setelah form dikirim, halaman mendeteksi request POST. Jika ada data yang masuk, bagian bawah akan menampilkan kembali semua data yang dikirim oleh pengguna dalam bentuk daftar. Dengan cara ini, halaman berfungsi sebagai form input sekaligus menampilkan hasil input menggunakan konsep OOP dan modularisasi.


<img width="955" height="745" alt="image" src="https://github.com/user-attachments/assets/f6060319-5fb5-46f6-9a11-ed36d669e27f" />


## Database.php
```php
<?php

class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;
    
    public function __construct() {
        $this->getConfig();
        $this->conn = new mysqli($this->host, $this->user, $this->password,
$this->db_name);
if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error);
}
}

private function getConfig() {
    include_once("config.php");
    $this->host = $config['host'];
    $this->user = $config['username'];
    $this->password = $config['password'];

    $this->db_name = $config['db_name'];
}
public function query($sql) {
    return $this->conn->query($sql);
}
public function get($table, $where=null) {
    if ($where) {
        $where = " WHERE ".$where;
    }
    $sql = "SELECT * FROM ".$table.$where;
    $sql = $this->conn->query($sql);
    $sql = $sql->fetch_assoc();
    return $sql;
}

public function insert($table, $data) {
    if (is_array($data)) {
        foreach($data as $key => $val) {
            $column[] = $key;
            $value[] = "'{$val}'";
        }
        $columns = implode(",", $column);
        $values = implode(",", $value);
    }
    $sql = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
    $sql = $this->conn->query($sql);
    if ($sql == true) {
        return $sql;
    } else {
        return false;
    }
}
public function update($table, $data, $where) {
    $update_value = "";
    if (is_array($data)) {
        foreach($data as $key => $val) {
            $update_value[] = "$key='{$val}'"
        }
        $update_value = implode(",", $update_value);
    }
    $sql = "UPDATE ".$table." SET ".$update_value." WHERE ".$where;
    $sql = $this->conn->query($sql);
    if ($sql == true) {
        return true;
    } else {
        return false;
    }
}

public function delete($table, $filter) {
    $sql = "DELETE FROM ".$table." ".$filter;
    $sql = $this->conn->query($sql);
    if ($sql == true) {
        return true;
    } else {
        return false;
    }
}
}
?>
```




## Pertanyaan dan Tugas
Implementasikan konsep modularisasi pada kode program pada praktukum sebelumnya
dengan menggunakan class library untuk form dan database connection.

## Hasi

<img width="958" height="902" alt="image" src="https://github.com/user-attachments/assets/879a8aa9-b789-465f-805a-124a80f6cdbd" />







