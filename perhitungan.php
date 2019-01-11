
<?php
include 'koneksi.php';
include 'stopword_list.php';
require_once __DIR__ . '/vendor/autoload.php';
$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
$stemmer  = $stemmerFactory->createStemmer();

function preproses($teks) {
    global $stopwords;
    global $stemmer;
    //1. ubah ke huruf kecil            
    $teks = strtolower(trim($teks));
     
    //hilangkan tanda baca
    $teks = str_replace("'", " ", $teks);
 
    //$teks = str_replace("-", " ", $teks);
 
    $teks = str_replace(")", " ", $teks);
 
    $teks = str_replace("(", " ", $teks);
 
    $teks = str_replace("\"", " ", $teks);
 
    $teks = str_replace("/", " ", $teks);
 
    $teks = str_replace("=", " ", $teks);
 
    $teks = str_replace(".", " ", $teks);
 
    $teks = str_replace(",", " ", $teks);
 
    $teks = str_replace(":", " ", $teks);
 
    $teks = str_replace(";", " ", $teks);
 
    $teks = str_replace("!", " ", $teks);
 
    $teks = str_replace("?", " ", $teks);  
    
    //stemming
    $teks = $stemmer->stem($teks);


    //2. hapus stoplist
    $temp = explode(" ", $teks);
    for ($i=0; $i < sizeof($temp); $i++) { 
        for ($d=0; $d < sizeof($stopwords); $d++) { 
            if($stopwords[$d]==$temp[$i]){
                //echo $temp[$i];echo "<br>";
                $temp[$i] = '';
            }
        }
    }
    $teks = implode(" ", $temp);

    //hilangkan ruang kosong di awal & akhir teks   
    $teks = trim($teks);
    $data = explode(' ',$teks);

    for($i=0;$i<sizeof($data);$i++){
        if($data[$i]==""){
            unset($data[$i]);
            $temp=array_values($data);
            $data=array_values($temp);
            $i--;
        }
    }
   return $data;

} //end function

function insert($teks,$tabel){

    for($i=0;$i<sizeof($teks);$i++){
        if(!in_array($teks[$i],array_column($tabel,0))){
            $tabel[sizeof($tabel)][0]=$teks[$i];
        }
    }
    return $tabel;
}

function hitungTF($tabel,$berita){
    for ($i=1;$i<sizeof($tabel);$i++){
        $a=sizeof($tabel[$i]);
        $tabel[$i][$a] = count(array_keys($berita,$tabel[$i][0]));
    }
    return $tabel;
}

function hitungDF($tabel){
    $df = 0;
    for ($i=1;$i<sizeof($tabel);$i++){
        for ($d=1;$d<sizeof($tabel[$i]);$d++){
            if($tabel[$i][$d]!=0){
                $df++;
            }
        }
        $tabel[$i][sizeof($tabel[$i])]=$df;
        $df = 0;
    }
    return $tabel;
}

function hitungIDF($tabel){
    $index = cariAtrib($tabel,"DF");
    $jumlah = $index-1;
    for ($i=1;$i<sizeof($tabel);$i++){
        $tabel[$i][$index+1] = round(log10($jumlah/$tabel[$i][$index]),3);
    }
    return $tabel;
}

function hitungWdt($tabel){
    $idf = cariAtrib($tabel,"IDF");
    $h = 1;
    for ($i=$idf+1;$i<sizeof($tabel[0]);$i++){
        for ($d=1;$d<sizeof($tabel);$d++){
            $tabel[$d][$i] = $tabel[$d][$h] * $tabel[$d][$idf];
        }
        $h++;
    }
    return $tabel;
}

function hitungSkalar($table){
    $Q = cariAtrib($table,"WDQ");
    $max = sizeof($table[0])-$Q-1;
    for ($i=0;$i<$max;$i++){
        $a=$i+1;
        $skalar[0][$i] = "D$a";
    }
    $jumlah = sizeof($table[0])-$Q;
    $total = 0;
    for ($i=1;$i<$jumlah;$i++){
        for ($d=1;$d<sizeof($table);$d++){
            $skalar[$d][$i-1] = round($table[$d][$Q] * $table[$d][$Q+$i],3);
            $total += round($skalar[$d][$i-1],3);
        }
        $skalar[$d][$i-1] = $total;
        $total = 0;
    }
    return $skalar;
}

function hitungPvektor($tabel){
    $wdq = cariAtrib($tabel,"WDQ");
    $size = sizeof($tabel[0]) - $wdq;
    $Pvektor[0][0] = "Q";
    $total = 0;
    for ($i=1;$i<$size;$i++){
        $Pvektor[0][$i] = "D$i";
    }
    for ($i=0;$i<$size;$i++){
        for ($d=1;$d<sizeof($tabel);$d++){
            $Pvektor[$d][$i] = round(pow($tabel[$d][$wdq],2),3);
            $total+=$Pvektor[$d][$i];
        }
        $wdq++;
        $Pvektor[$d][$i] = $total;
        $Pvektor[$d+1][$i] = round(sqrt($total),3);
        $total = 0;
    }
    return $Pvektor;
}

function hitungRank($pvektor,$skalar){
    global $doc;
    for ($i=1;$i<=sizeof($doc);$i++){
        $hasil["D$i"] = round($skalar[sizeof($skalar)-1][$i-1] / ($pvektor[sizeof($pvektor)-1][0] * $pvektor[sizeof($pvektor)-1][$i-1]),3);
    }
    arsort($hasil);
    return $hasil;
}

function penamaan($tabel){
    $tabel[0][0]="TERM";
    $tabel[0][1]="Q";
    $tabel[0][sizeof($tabel[1])-1]="DF";
    $tabel[0][sizeof($tabel[1])]="IDF";
    $jumlah = sizeof($tabel[1])-1-cariAtrib($tabel,"Q")-1;
    for ($i=2;$i<$jumlah+2;$i++){
        $x=$i-1;
        $tabel[0][$i] = "D$x";
    }
    $tabel[0][sizeof($tabel[1])+1]="WDQ";
    $awal = sizeof($tabel[1])+2;
    $n = 1;
    for ($d=$awal;$d<$jumlah+$awal;$d++){
        $tabel[0][$d] = "WD$n";
        $n++;
    }
    return $tabel;
}

function cariAtrib($tabel,$query){
    for ($i=0;$i<sizeof($tabel[0]);$i++){
        if($tabel[0][$i]==$query){
            return $i;
        }
    }
    return "not found";
}

function printTabel($tabel){
    echo "<table border=1 cellpadding=2>";
    for ($d=0;$d<sizeof($tabel);$d++){
        echo "<tr>";
        for ($i=0;$i<sizeof($tabel[$d]);$i++){
            $a = $tabel[$d][$i];
            echo "<th>$a</th>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
//contoh penggunaan

$data = mysqli_query($con,"select * from upload");
while ($c = mysqli_fetch_array($data)) {
    $doc[] = $c['isi_file'];
}

print("Sebelum pre-processing:<hr />");
for($d=0;$d<sizeof($doc);$d++){
    echo "Doc ";echo $d+1;echo " : ";echo $doc[$d];echo "<br>";
}
echo "<br>";

print("Setelah pre-processing:<hr />");
if (isset($_COOKIE["key"])) {
    $query=$_COOKIE["key"];
    $query = preproses($query);
    echo "Query : ";echo implode(" ", $query);echo "<br>";

    for ($i=0; $i < sizeof($doc); $i++) { 
    $doc[$i] = preproses($doc[$i]);
    echo "Doc ";echo $i+1;echo " : ";echo implode(" ", $doc[$i]);echo "<br>";
    }

    echo "<br>";
    echo "<br>";
    $tabel[0][0]='';
    $tabel = insert($query,$tabel);
    for ($i=0; $i < sizeof($doc); $i++) { 
        $tabel = insert($doc[$i],$tabel);
    }

    $tabel = hitungTF($tabel,$query);
    for ($i=0; $i < sizeof($doc); $i++) { 
        $tabel = hitungTF($tabel,$doc[$i]);
    }

    $tabel = hitungDF($tabel);

    $tabel = penamaan($tabel);
    $tabel = hitungIDF($tabel);
    $tabel = hitungWdt($tabel);
    $skalar = hitungSkalar($tabel);
    $Pvektor = hitungPvektor($tabel);

    print ("Tabel Vector Space Model<hr />");
    printTabel($tabel);
    print ("<br>Tabel Perkalian Skalar<hr />");
    printTabel($skalar);
    echo "<br>";
    print ("<br>Tabel Panjang Vektor<hr />");
    printTabel($Pvektor);
    print ("<br></br>Ranking<hr/>");
    print_r(hitungRank($Pvektor,$skalar));
} else {
    echo 'mohon isikan query dulu -_-';
}

