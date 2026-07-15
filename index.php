<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kriptografi Klasik</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}
.container{
    width:600px;
    margin:40px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}
h2{
    text-align:center;
}
textarea,input,select{
    width:100%;
    padding:10px;
    margin-top:8px;
    margin-bottom:15px;
}
button{
    padding:10px 20px;
    margin-right:10px;
    background:#007bff;
    color:white;
    border:none;
    cursor:pointer;
}
button:hover{
    background:#0056b3;
}
.result{
    margin-top:20px;
    padding:15px;
    background:#e8f5e9;
    border-left:5px solid green;
}
</style>

</head>
<body>

<div class="container">

<h2>Aplikasi Kriptografi Klasik</h2>

<form method="POST">

<label>Pesan (Plaintext / Ciphertext)</label>
<textarea name="text" rows="5" required><?= $_POST['text'] ?? '' ?></textarea>

<label>Pilih Algoritma</label>
<select name="algoritma">
    <option value="caesar">Caesar Cipher</option>
    <option value="vigenere">Vigenère Cipher</option>
</select>

<label>Key</label>
<input type="text" name="key" required value="<?= $_POST['key'] ?? '' ?>">

<button type="submit" name="encrypt">Enkripsi</button>
<button type="submit" name="decrypt">Dekripsi</button>

</form>

<?php

function caesar_cipher($text,$key,$encrypt=true){

    $hasil="";

    foreach(str_split($text) as $char){

        if(ctype_alpha($char)){

            $ascii = ctype_upper($char) ? 65 : 97;

            $offset = ord($char)-$ascii;

            if($encrypt)
                $offset = ($offset+$key)%26;
            else
                $offset = ($offset-$key+26)%26;

            $hasil .= chr($offset+$ascii);

        }else{
            $hasil .= $char;
        }

    }

    return $hasil;
}


function vigenere_cipher($text,$key,$encrypt=true){

    $hasil="";

    $key = strtoupper($key);
    $j=0;

    for($i=0;$i<strlen($text);$i++){

        $char = $text[$i];

        if(ctype_alpha($char)){

            $ascii = ctype_upper($char)?65:97;

            $k = ord($key[$j % strlen($key)])-65;

            $offset = ord($char)-$ascii;

            if($encrypt)
                $offset = ($offset+$k)%26;
            else
                $offset = ($offset-$k+26)%26;

            $hasil .= chr($offset+$ascii);

            $j++;

        }else{

            $hasil .= $char;

        }

    }

    return $hasil;
}


if(isset($_POST['encrypt']) || isset($_POST['decrypt'])){

    $text=$_POST['text'];
    $alg=$_POST['algoritma'];
    $encrypt=isset($_POST['encrypt']);

    if($alg=="caesar"){

        $key=(int)$_POST['key'];

        $hasil=caesar_cipher($text,$key,$encrypt);

    }else{

        $key=$_POST['key'];

        $hasil=vigenere_cipher($text,$key,$encrypt);

    }

    echo "<div class='result'>";
    echo "<h3>Hasil</h3>";
    echo "<b>$hasil</b>";
    echo "</div>";

}

?>

</div>

</body>
</html>