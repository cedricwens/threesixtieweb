<?php
require('core/init.php');
require("fpdf/fpdf.php");

class PDF extends FPDF{
	// Current column
	var $col = 0;
	// Ordinate of column start
	var $y0;

	// Page header
	function Header()
	{
	    //if($this->PageNo()==1){
	    	$this->Image('img/logo.png',20,20,50);
		    // Arial bold 15
		    $this->SetFont('Arial','B',10);
		    // Title
		    $this->Cell(150);
		    $this->Cell(80,10,'Philipssite 5 bus 13',0,0);
		    $this->Ln(5);
		    $this->Cell(150);
		    $this->Cell(10,10,'3001 Leuven Belgium',0,0);
		    $this->Ln(5);
		    $this->Cell(150);
		    $this->Cell(10,10,'Tel.: +32 16 28 49 70',0,0);
		    $this->Ln(5);
		    $this->Cell(150);
		    $this->Cell(10,10,'Website : www.dns.be',0,0);
		    // Line break
		    $this->Ln(15);
		    $this->Line(10,40,200,40);
		    $this->Ln(15);
		    // Save ordinate
	    	$this->y0 = $this->GetY();
	   //} 
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	function SetCol($col)
	{
	    // Set position at a given column
	    $this->col = $col;
	    $x = 10+$col*65;
	    $this->SetLeftMargin($x);
	    $this->SetX($x);
	}

	function AcceptPageBreak()
	{
	    // Method accepting or not automatic page break
	    if($this->col<2)
	    {
	        // Go to next column
	        $this->SetCol($this->col+1);
	        // Set ordinate to top
	        $this->SetY($this->y0);
	        // Keep on page
	        return false;
	    }
	    else
	    {
	        // Go back to first column
	        $this->SetCol(0);
	        // Page break
	        return true;
	    }
	}
}
if(isset($_GET['id']) && $_GET['id'] == $_SESSION['user_id']){
	$id 					= $_SESSION['user_id'];
	$user 					= get_user_by_id($id);
	$reviews_given 			= get_number_of_reviews_given($id);
	$reviews_received 		= get_number_of_reviews_received($id);
	$teammember_reviews		= get_number_of_poll_team_members($id);
	$notteammember_reviews 	= get_number_of_poll_not_team_members($id);
	$teammanager_reviews 	= get_number_of_poll_team_manager($id);
	$notteammanager_reviews = get_number_of_poll_not_team_manager($id);
	$preferred_reviewers 	= get_number_of_preferred_reviewers($id);
	$preferred_reviewees 	= get_number_of_preferred_reviewees($id);
	$comments 				= get_comments($id);
	$questions 				= get_questions();

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',18);
	$pdf->Cell(10,10,$user[0].' '.$user[1],0,0);
	$pdf->Ln(15);

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,10,"Heeft $reviews_given review(s) geschreven",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"Heeft $reviews_received review(s) gekregen",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"Krijgt review(s) van $teammember_reviews teamleden",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"Krijgt review(s) van $notteammember_reviews niet-teamleden",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"Krijgt $teammanager_reviews review(s) van zijn teammanager.",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"Krijgt $notteammanager_reviews review(s) van andere teammanagers.",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"$preferred_reviewers van de gebruikers die $user[0] aangaf, mogen ook effectief de vragenlijst over $user[0] invullen.",0,0);
	$pdf->Ln(5);
	$pdf->Cell(10,10,"$user[0] mag van $preferred_reviewees gebruikers die zijn had gekozen, ook effectief de vragenlijst invullen.",0,0);
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(175,10,"Vraag",0,'C');
	$pdf->Ln(10);
	foreach ($questions as $key => $question) {
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10,3,$key+1,0,0);
		$pdf->MultiCell(175,5,$question['Question'],0,'L');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10);
		$pdf->Cell(5,10,"Gemiddelde score: ".get_average_score($id, $question['ID']),0,0);
		$pdf->Ln(10);
		if($pdf->GetY()>250){
			$pdf->AddPage();
		}	
	}
	if($comments){
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(175,10,"Extra commentaar",0,'C');
		$pdf->Ln(10);
		foreach ($comments as $comment) {
			$pdf->SetFont('Arial','',12);
			$pdf->SetMargins(10,10,10,10);
			$pdf->MultiCell(175,5,$comment['Comment'],1,'L');
			$pdf->Ln(10);
			if($pdf->GetY()>250){
				$pdf->AddPage();
			}	
		}
	}
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(173,10, 'Indien u graag meer informatie wil over uw resultaten, of deze resultaten graag met iemand bespreekt, dan kan dit.', 0, 'L');
	$pdf->Ln(5);
	$pdf->Output();
}		

?>