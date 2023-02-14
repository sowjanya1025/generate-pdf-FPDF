<?php
include('database1.php');
$database = new Database();
/*$result = $database->runQuery("SELECT tournament_id,player1_id,player2_id,match_start_time, court_id FROM msa_fixture_dtl where tournament_id = 117");
*/

$result = $database->runQuery("SELECT 
							td.id,
							u1.firstname as player1_name,
							u2.firstname as player2_name, 
							fix.match_date,
							fix.`match_start_time`,
							fix.court_id,
							tv.venue_name
							FROM 
							`tournament_details` td 
							Right JOIN msa_fixture_dtl fix on td.id=fix.tournament_id 
							LEFT JOIN tournament_venues as tv on td.id=tv.tournament_details_id
							INNER join users u1 on fix.player1_id=u1.id INNER join users u2 on fix.player2_id=u2.id  where fix.tournament_id = 220;");

				   
require('fpdf/fpdf.php');


class PDF extends FPDF
{
// Page header
function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(28);
        // Framed title
		$this->SetTextColor(34, 139, 34);
		
		$this->Cell(60, 10, 'Tournament Name', 1, 0, 'C');
        $this->Cell(60, 10, 'Pre-Quarter Finals', 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }


}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

 $pdf->Cell(18,10,'Matches',1);
  $pdf->Cell(70,10,'Players',1);
  $pdf->Cell(30,10,'Match Date',1);
  $pdf->Cell(30,10,'Match Start Time',1);
  $pdf->Cell(15,10,'Court',1);
  $pdf->Cell(20,10,'Venue',1);
  
  

$i=1;
foreach($result as $row) {
	$pdf->Ln();
	//foreach($row as $column)
		//$pdf->Cell(95,12,$column,1);
		
		$pdf->SetFont('Times','',12);
		$id =  $i;
		$players = $row['player1_name']." -Vs-  ".$row['player2_name'] ;
		$date = $row['match_date'];
		//$player2 = $row['player2_name'];
		$time = $row['match_start_time'];
		$court = $row['court_id'];
		$venue = $row['venue_name'];
		//$pdf->Cell(95,12,$row,1);
 $pdf->Cell(18,10,$id,1);
 // $pdf->Cell(50,10,$player1,1);
 
  $pdf->Cell(70,10,$players,1);
  $pdf->Cell(30,10,$date,1);
  $pdf->Cell(30,10,$time,1);
  $pdf->Cell(15,10,$court,1);
  $pdf->Cell(20,10,$venue,1);
  $i++;
}
$pdf->Output();
?>