<?php
session_start();

if (!isset($_SESSION['last_id'])) {
    header("location: order_status.php");
    exit();
}
session_write_close();
?>

<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location: cart.php");
    exit();
}
?>
	
<?php
require('fpdf17/fpdf.php');

//db connection
include 'scripts/connect.php';

$id = $_SESSION['last_id'];
if (isset($_GET['id'])) {
    $id = pf_validate_number($_GET['id'], "value", $config_basedir);
}

$query = mysqli_query($con,"select * from orders
	where 
	id = '$id'");
	
$id = mysqli_fetch_array($query);

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(130	,5,'SHOPPING ONLINE',0,0);
$pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'99 Moo.17, Tambon Khlong Nueng',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

//set date and time in thai form
	$th=mktime(gmdate("H")+7,gmdate("i"));
	$format="d/m/y H:i a"; 
	$str=date($format,$th);

$pdf->Cell(130	,5,'Amphur Khlong Luang, Pathum Thani, 12120',0,0);
$pdf->Cell(25	,5,'Date',0,0);
$pdf->Cell(34	,5,$str,0,1);//end of line

$pdf->Cell(130	,5,'Phone 0988454160',0,0);
$pdf->Cell(25	,5,'invoice #',0,0);
$pdf->Cell(34	,5,$id['id'],0,1);//end of line

$pdf->Cell(130	,5,'Fax 02771696',0,0);
$pdf->Cell(25	,5,'Customer ID',0,0);
$pdf->Cell(34	,5,$id['user_id'],0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address
$pdf->Cell(100	,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,$id['full_name'],0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,''.$id['address'].' '.$id['city'].' '.$id['state'].' '.$id['zipcode'].' '.$id['country'].'',0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,'tel '.$id['phone_number'].'',0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(130	,5,'Product Name',1,0);
$pdf->Cell(25	,5,'Quantity',1,0);
$pdf->Cell(34	,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);


//pull data from cart.php
	$ashipping = $_SESSION['shipping'];
	$avat = $_SESSION['vat'];
	$asum = $_SESSION['sum'];

	$aName = $_SESSION['aryName'];
	$aQuan = $_SESSION['aryQuan'];
	$aAmonunt = $_SESSION['aryAmount'];
	$count = $_SESSION['count'];

//display the items	
	for ($i = 0; $i < $count; $i++) {
		$pdf->Cell(130	,5,$aName[$i],1,0);
		$pdf->Cell(25	,5,$aQuan[$i],1,0);
		$pdf->Cell(34	,5,$aAmonunt[$i],1,1,'R');
	}
//pull data from order_status.php
	$aquan =$_SESSION['quantity'];
	$atotal =$_SESSION['total'];

//summary
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Sub-total',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$atotal,1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Vat(7%)',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,number_format($avat, 2, '.', ''),1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Shipping',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$ashipping,1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Total Due',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,number_format($asum, 2, '.', ''),1,1,'R');//end of line


$pdf->Output();
?>
