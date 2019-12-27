<?php
echo "USAGE php register.php data_nik.txt \n";
/*
RECODED By jeinel Cannine
*/
require_once 'deathbycaptcha.php';
###############################################
$users = "";
$passs = "";
###############################################
$i = 0;
$listcode = $argv[1];
$codelistlist = file_get_contents($listcode);
$code_list_array = file($listcode);
$code = explode(PHP_EOL, $codelistlist);
$count = count($code);
echo "Total Ada : $count DATA Sob, Gass \n";
while($i < $count) {
$pisah = explode("|", $code[$i]);

$nik = $pisah[0];
$name = $pisah[1];
$tanggal = $pisah[2];
$bulan = $pisah[3];
$tahun = $pisah[4];

$nama = str_replace(" ", "+", $name);
$pass='Marlboro123@';
$get_token = get_token();
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $get_token, $kue);
$get_csrf = get_csrf($kue);
preg_match('/<input type="hidden" name="decide_csrf" value="(.*?)" \/>/', $get_csrf, $csrf);
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $get_csrf, $kuea);
$username = "angip".rand(100,999)."";
$em ='kukipusking+'.$username.'@gmail.com';
$email = urlencode($em); $password = urlencode($pass);
echo $i.". Mendaftarkan ".$em."|".$pass." = ";
$capcha = dbc($users,$passs);
$post_data=post_data($nik,$nama,$tanggal,$bulan,$tahun,$capcha,$csrf,$email,$password,$kue,$kuea);
$status=get_between($post_data, '"message":"', '","');
if ($status == 'success'){
echo "Sukses\n";
$simpan =fopen('result.txt', 'a');
fwrite($simpan, $em."|".$pass."\n");
}
else{
echo "Gagal (".get_between($post_data, '"message":"', '","').")\n";
}$i++;}
function get_token(){
$c = curl_init("https://www.marlboro.id/");
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($c, CURLOPT_MAXREDIRS, 15);
	curl_setopt($c, CURLOPT_TIMEOUT, 30);
	curl_setopt($c, CURLOPT_ENCODING, "");
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    $response = curl_exec($c);
    return $response;
}

function get_csrf($kue){
$c = curl_init("https://www.marlboro.id/auth/register");
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_MAXREDIRS, 15);
    curl_setopt($c, CURLOPT_TIMEOUT, 30);
    curl_setopt($c, CURLOPT_ENCODING, "");
    $header = array();
    $header[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0";
    $header[] = "Accept: */*";
    $header[] = "Accept-Language: en-US,en;q=0.5";
    $header[] = "Accept-Encoding: gzip, deflate";
    $header[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $header[] = 'Cookie: '.$kue[1][1].'; '.$kue[1][2].'; '.$kue[1][3].'; insdrSV=450; _ga=GA1.2.1234438292.1574557766; _gcl_au=1.1.1768291414.1574557768; accC=true; _hjid=e39e660a-2ac8-4f04-bad2-672711f485c1; OptanonConsent=isIABGlobal=false&datestamp=Fri+Dec+27+2019+06%3A54%3A15+GMT%2B0700+(Western+Indonesia+Time)&version=5.8.0&landingPath=NotLandingPage&AwaitingReconsent=false&groups=1%3A1%2C2%3A1%2C4%3A0%2C0_136904%3A0%2C0_136903%3A0%2C0_136902%3A0%2C0_136901%3A0%2C0_136900%3A1%2C0_136899%3A0%2C0_136898%3A0; _gid=GA1.2.559019225.1577284701; _p1K4r_=true; pikar_redirect=true; total-cart-amount=0; current-currency=IDR; '.$kue[1][4].'; ins-gaSSId=f5e22523-8123-4457-d796-8a3408c3d391_1577403654; _gat_UA-102334128-3=1';
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    curl_setopt($c, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    $response = curl_exec($c);
    return $response;
}
  function dbc($users,$passs){
$client = new DeathByCaptcha_HttpClient(''.$users.'', ''.$passs.'');
$data = array('googlekey' => '6LfFZpEUAAAAAAOeeFUdj-v_pUMb28yoq6SyjBta','pageurl' => 'https://www.marlboro.id/auth/register');
$json = json_encode($data);
$extra = ['type' => 4,'token_params' => $json];
$captcha = $client->decode(null, $extra);
$respon = $captcha['text'];
return $respon;
}

function post_data($nik,$nama,$tanggal,$bulan,$tahun,$capcha,$csrf,$email,$password,$kue,$kuea){
 $header = array();
    $header[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0";
    $header[] = "Accept: */*";
    $header[] = "Accept-Language: en-US,en;q=0.5";
    $header[] = "Accept-Encoding: gzip, deflate";
    $header[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $header[] = 'Cookie: '.$kue[1][1].'; '.$kue[1][2].'; '.$kue[1][3].'; insdrSV=450; _ga=GA1.2.1234438292.1574557766; _gcl_au=1.1.1768291414.1574557768; accC=true; _hjid=e39e660a-2ac8-4f04-bad2-672711f485c1; OptanonConsent=isIABGlobal=false&datestamp=Fri+Dec+27+2019+06%3A54%3A15+GMT%2B0700+(Western+Indonesia+Time)&version=5.8.0&landingPath=NotLandingPage&AwaitingReconsent=false&groups=1%3A1%2C2%3A1%2C4%3A0%2C0_136904%3A0%2C0_136903%3A0%2C0_136902%3A0%2C0_136901%3A0%2C0_136900%3A1%2C0_136899%3A0%2C0_136898%3A0; _gid=GA1.2.559019225.1577284701; _p1K4r_=true; pikar_redirect=true; total-cart-amount=0; current-currency=IDR; '.$kuea[1][0].'; ins-gaSSId=f5e22523-8123-4457-d796-8a3408c3d391_1577403654; _gat_UA-102334128-3=1';

$c = curl_init("https://www.marlboro.id/auth/register/");
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);;
    curl_setopt($c, CURLOPT_POSTFIELDS, 'name='.$nama.'&ktp_number='.$nik.'&date_dropdown='.$tanggal.'&month_dropdown='.$bulan.'&year_dropdown='.$tahun.'&email='.$email.'&password='.$password.'&ref_email=&t_and_c=on&g-recaptcha-response='.$capcha.'&decide_csrf='.$csrf[1].'&ref_uri=%2F&param=&sitekey=6LfFZpEUAAAAAAOeeFUdj-v_pUMb28yoq6SyjBta');
    curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_ENCODING, "");
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($c);
	$httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
	
    return $response;
}
function get_between($string, $start, $end) 
	{
	    $string = " ".$string;
	    $ini = strpos($string,$start);
	    if ($ini == 0) return "";
	    $ini += strlen($start);
	    $len = strpos($string,$end,$ini) - $ini;
	    return substr($string,$ini,$len);
	}
function randomPassword($len = 11) {

    //enforce min length 8
    if($len < 8)
        $len = 8;

    //define character libraries - remove ambiguous characters like iIl|1 0oO
    $sets = array();
    $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    $sets[] = '23456789';
    $sets[]  = '~!@#$%^&*(){}[],./?';

    $password = '';
    
    //append a character from each set - gets first 4 characters
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
    }

    //use all characters to fill up to $len
    while(strlen($password) < $len) {
        //get a random set
        $randomSet = $sets[array_rand($sets)];
        
        //add a random char from the random set
        $password .= $randomSet[array_rand(str_split($randomSet))]; 
    }
    
    //shuffle the password string before returning!
    return str_shuffle($password);
}


?>
