<?php

//cashflow_fetch.php

include('database_connection.php');


$query = '';

$output = array();
$query .= "
SELECT * FROM cashflow 
JOIN user_details ON user_details.user_id = cashflow.cashflow_enter_by 
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE cashflow.cashflow_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR cashflow.cashflow_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR cashflow.cashflow_status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY cashflow_id ASC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
$saldo = 0;
foreach($result as $row)
{
	$status = '';
	if($row['cashflow_status'] == 'debit')
	{
		$status = '<span class="label label-success">debit</span>';
		$saldo=$saldo+$row['debit'];
	}
	else
	{
		$status = '<span class="label label-danger">kredit</span>';
		$saldo=$saldo-$row['kredit'];
	}
	$sub_array = array();
	$sub_array[] = $row['cashflow_id'];
	$sub_array[] = date('d F Y', strtotime($row['cashflow_date']));
	$sub_array[] = $row['cashflow_name'];
	$sub_array[] = number_format($row['debit']);
	$sub_array[] = number_format($row['kredit']);
	$sub_array[] = number_format($saldo);
	$sub_array[] = $row['user_name'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["cashflow_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["cashflow_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["cashflow_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["cashflow_status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM cashflow');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=>  get_total_all_records($connect),
	"data"    			=> 	$data
);

echo json_encode($output);

?>