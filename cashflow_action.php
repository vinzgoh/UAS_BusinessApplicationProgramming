<?php

//cashflow_action.php

include('database_connection.php');




if(isset($_POST['btn_action']))
{


	if($_POST['btn_action'] == 'Add')
	{

		$query = "
		INSERT INTO cashflow (cashflow_name, cashflow_date, cashflow_status, debit, kredit,  cashflow_enter_by) 
		VALUES ( :cashflow_name, :cashflow_date, :cashflow_status, :debit, :kredit,  :cashflow_enter_by)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cashflow_name'			=>	$_POST['cashflow_name'],
				':cashflow_date'			=>	$_POST['cashflow_date'],
				':cashflow_status'			=>	$_POST['cashflow_status'],
				':debit'					=>	$_POST['debit'],
				':kredit'					=>	$_POST['kredit'],
				':cashflow_enter_by'		=>	$_SESSION["user_id"],
				':cashflow_date'			=>	$_POST['cashflow_date']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'cashflow Added';
		}
	}

	if($_POST['btn_action'] == 'cashflow_details')
	{

		$query = "
		SELECT * FROM cashflow 
		INNER JOIN user_details ON user_details.user_id = cashflow.cashflow_enter_by 
		WHERE cashflow.cashflow_id = '".$_POST["cashflow_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
		<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['cashflow_status'] == 'debit')
			{
				$status = '<span class="label label-success">debit</span>';
			}
			else
			{
				$status = '<span class="label label-danger">kredit</span>';
			}
			$output .= '
			<tr>
			<td>Cashflow Name</td>
			<td>'.$row["cashflow_name"].'</td>
			</tr>
			<tr>
			<td>Cashflow Name</td>
			<td>'.date('d F Y', strtotime($row["cashflow_date"])).'</td>
			</tr>
			<tr>
			<td>Debit</td>
			<td>Rp &nbsp;'.number_format($row["debit"]).'</td>
			</tr>
			<tr>
			<td>Credit</td>
			<td>Rp &nbsp;'.number_format($row["kredit"]).'</td>
			</tr>
			<tr>
			<td>Enter By</td>
			<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
			<td>Status</td>
			<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
		</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{	
		$query = "
		SELECT * FROM cashflow WHERE cashflow_id = :cashflow_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cashflow_id'	=>	$_POST["cashflow_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['cashflow_name'] 	= $row['cashflow_name'];
			$output['cashflow_date'] 	= $row['cashflow_date'];
			$output['cashflow_status'] 	= $row['cashflow_status'];
			$output['debit']			= $row['debit'];
			$output['kredit'] 			= $row['kredit'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{

		$query = "
		UPDATE cashflow 
		set cashflow_name = :cashflow_name,
		cashflow_date = :cashflow_date,
		cashflow_status = :cashflow_status,
		kredit = :kredit, 
		debit = :debit
		WHERE cashflow_id = :cashflow_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cashflow_name'			=>	$_POST['cashflow_name'],
				':cashflow_date'			=>	$_POST['cashflow_date'],
				':cashflow_status'			=>	$_POST['cashflow_status'],
				':kredit'					=>	$_POST['kredit'],
				':debit'					=>	$_POST['debit'],
				':cashflow_id'				=>	$_POST['cashflow_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'cashflow Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{

		$query = "
		DELETE FROM cashflow 
		WHERE cashflow_id = :cashflow_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cashflow_id'		=>	$_POST["cashflow_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'cashflow has been deleted ';
		}
	}
}


?>