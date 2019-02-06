$dbhost='localhost:3306';
$dbuser='xxxx_xxxx';
$dbpass='yyyy_yyyy';
$dbname='db_kuvat';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn){
die('Could not connect: ' .mysql_error());
}
	$conn->set_charset('utf8');

//construct SQL query
if ($_GET[haku] != "") $sql = "SELECT * FROM taulukko WHERE kuvanumero LIKE '%$_GET[haku]%'";
$result = mysqli_query($conn, $sql) or die("Error retrieving data");

//THE MAIN IMAGE PAGE IS CREATED HERE
$record = mysqli_fetch_array($result);
$kuvanumero = $record["kuvanumero"];
$kuvailu = $record["kuvailu"];
$tiedostonimi = $record["tiedostonimi"];
$otsikko = $record["otsikko"];
$vuosikymmen = $record["vuosikymmen"];
/*free result set*/
mysqli_free_result($result);
	
//session_start();
$new_img_arr = $_SESSION['img_arr'];
$new_search_arr = $_SESSION['search_arr'];

$avain = array_search((int)$kuvanumero, $new_img_arr);	
$next = $new_img_arr[$avain+1];
$prev = $new_img_arr[$avain-1];
			
echo "<a href='/kuvat/luettelo4.php?haku = $kuvanumero'><imgborder='0'src='/images/$vuosikymmen/images/$tiedostonimi'width='450'></a>";
echo "<h3>$otsikko</h3>";
echo "<p>$kuvailu</p>";
echo "<p>&nbsp;</p>";
	
if (!$new_search_arr[vuosikymmen]) echo "<p><i>Aikakausi: <a href='/kuvat/luettelo.php?vuosikymmen=$vuosikymmen'> $vuosikymmen-luku</a></p><p>&nbsp;</p></i>";	
	
if ($new_search_arr[henkilo]) echo "<p><a href='/kuvat/luettelo.php?henkilo=$new_search_arr[henkilo]'>Takaisinhakutuloksiin:henkilo=$new_search_arr[henkilo]</a>";
elseif ($new_search_arr[teksti]) echo"<p><a href='/kuvat/luettelo.php?teksti = $new_search_arr[teksti]'>Takaisinhakutuloksiin:teksti=$new_search_arr[teksti]</a>";
elseif ($new_search_arr[vuosikymmen]) echo"<p><a href='/kuvat/luettelo.php?vuosikymmen=$new_search_arr[vuosikymmen]'>Takaisinhakutuloksiin:vuosikymmen=$new_search_arr[vuosikymmen]</a>";
else echo "<p><a href='index.php'>Kuvien haku</a></p>";
echo "<br><br><br><strong>Kuvan käyttöoikeudet: </strong> Creative commons<span><a target='_blank'href='http://creativecommons.org/licenses/by/4.0/deed.fi'>CCBY4.0</a></span>";
if ($prev) echo "<pclass='irrallaan'><table width='450'><tr><td><img height='0' width='85' src='/pics/250px.gif'></td><td><a href='/kuvat/luettelo.php?haku=$prev'><img width='30'src='/pics/success-previous-button.png'></a></td>";
else echo "<pclass='text_line'>&nbsp;";
if ($next) echo "<td><ahref='/kuvat/luettelo.php?haku=$next'><imgwidth='30'alt='button'src='/pics/success-next-button.png'></a></td><td><imgheight='0'width='75'src='/pics/250px.gif'></td></tr></table></p>";
echo "<p><p><hr></p></p>";
echo "<p><p><pclass='text_line'><ahref='/kuvat/luettelo4.php?haku=$kuvanumero'>(+)suurenna kuva [$kuvanumero]</a></p></p>";
	
