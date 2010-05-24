<?
function generatePassword($length = 8){
  $chars = 'abdefhik nrst?yzA:BDE FGHKNQRS TYZ234, 567!89';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}

for ($x=0;$x<=500;$x++) {
	$h=rand(0,23);
	$i=rand(0,59);
	$s=rand(0,59);
	$m=rand(1,12);
	$d=rand(0,28);
	$y=rand(2009,2010);
	$art_file=mktime($h, $i,$s, $m, $d, $y);

	$cnt=generatePassword(rand(10,50))."\r\n";
	$cnt.=generatePassword(rand(200,800));
	
	if (!file_exists('./data/articles/'.$art_file)) {
		file_put_contents('./data/articles/'.$art_file,$cnt);
	}
}
?>