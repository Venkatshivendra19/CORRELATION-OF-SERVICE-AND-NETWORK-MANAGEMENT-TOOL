<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="120">
		<link rel = "stylesheet" href = "./bootstrap.min.css">
		<link rel = "stylesheet" href = "./bootstrap-theme.min.css">
		
		<style>
			#t1{
				padding: 15px;
				background-color: #eeeeee;
				border-bottom: solid 1px black;
			}

			#home{
				line-height: 150%;
			}

			footer
			{
				text-align: center;
				background-color: lavender;
				border-top: solid 1px black;
				bottom: 0;
				width: 100%;
				position: relative;
			}
								
		</style>

		<title>
			ANM	| Assignment - 2
		</title>
	</head>


	<body>
		<div class = "container-fluid" style = "margin: 0px; padding: 0px; width: 100%; height: 100%;">
			<div id = "t1">
				<div class = "container-fluid" style = "margin: 0px; padding: 0px;">
					<div class = "row">
						<div class = "col-md-5"></div>
						<div class = "col-md-2" style = "padding: 0;">
							<div class = "container-fluid" style = "margin: 0px; padding: 0px; text-align: center;">
								<h2><a href = './index.php'>Assignment - 2</a></h2>
							</div>
						</div>
						<div class = "col-md-5" style = "padding: 0;"></div>
					</div>
				</div>
			</div>


			<div class = "row" style = "margin: 0;">
				<ul class="nav nav-tabs">
<?php

include './split.php';

//Create connection
$connection = mysqli_connect($host, $username, $password, $database, $port);

//Check connection
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}


?>

					<li role="presentation"><a href="./index.php">Add Devices/servers to monitor</a></li>
					<li role="presentation"><a href="./add_plot.php">Select Devices/servers to plot</a></li>
					<li role="presentation" class="active"><a href="./compare.php">Compare</a></li>
				</ul>
			</div><br>
			
			
			<!--Status panel-->
			<div class = "col-md-4"></div>
			<div class = "col-md-4" style = "height: 100%;">
				<div class = "container-fluid" style = "margin: 0 20px 0 20px; padding: 0px; height: 100%;">
					<div class = "row" style = "margin: 0; height: 100%; text-align: center;">
						<form action = "./compare.php" method = "get">
							<table class = "table table-bordered" style = "width: 100%; text-align: left; vertical-align: middle;">
							  <tr>
								<th>Select Metrics</th>
								<th>Enter duration interms of hours</th>
							  </tr>
							  
							  <tr>
								<td>

<?php

	//Metrics table
	$match = array('Total Kbytes' => 'totalkbytes', 'CPU Utilization' => 'cpuutil', 'Requests/sec' => 'reqpersec', 'Bytes/sec' => 'bytespersec', 'Bytes/request' => 'bytesperreq');
	$units = array('Total Kbytes' => 'kB', 'CPU Utilization' => '%%', 'Requests/sec' => 'rps', 'Bytes/sec' => 'Bps', 'Bytes/request' => 'B');
	#$yaxis = array('Total Kbytes' => 'Total Kbytes', 'CPU Utilization' => 'CPU Utilization in %%', 'Requests/sec' => 'Requests/sec', 'Bytes/sec' => 'Bytes/sec', 'Bytes/request' => 'Bytes/request');
	$list_metrics = array_keys($match);
				
	foreach($list_metrics as $metric)
	{
		echo '<input style = "margin-right: 5px;" type = "checkbox" name = "server_metrics[list][]" value = "' . $metric . '">' . $metric . '<br>';
	}

?>
			  <input style = "margin-right: 5px;" type = "checkbox" name = "server_metrics[list]" value = 'all'>Select all metrics<br>
		  
								</td>
								<td>
									<br><input type = "textbox" name = "duration" style = 'margin-left: 10px;'/>
								</td>
							</table>
							<input type = "submit" name = "button" value = 'PLOT'/><br>
						</form>
						</div>
					</div>
				</div>
					

				<div class = "col-md-12" style = "height: 100%;">
					<div class = "container-fluid" style = "margin: 10px 0 10px 0; padding: 0px; height: 100%;">
						<div class = "row" style = "margin: 0; height: 100%; text-align: center;">
							<table class = "table table-bordered" style = "width: 100%; text-align: center;">
									
<?php

#$_GET['duration'] = 1;
if(isset($_GET['duration']))
{
	include './split.php';

	//Create connection
	$connection = mysqli_connect($host, $username, $password, $database, $port);

	//Check connection
	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	echo '<tr style = "text-align: center; padding: 2px;">
			<th>SERVERS</th>
			<th>DEVICES</th>
		  </tr>';
	echo '<tr style = "text-align: center; padding: 2px;">';

	//SERVERS	
	$query = "SELECT * FROM plot_SERVERS";
	$result = mysqli_query($connection, $query) or die("Error:" . mysqli_error($connection));
	$num_rows = mysqli_num_rows($result);
	
	$opts = array(
					"--start", "-" . $_GET['duration'] . "h",
					"--width", "500",
					"--lower-limit", "0",
					"--slope-mode",
			//		"--units-exponent", "6",
			//		"--rigid",
					"--title=Servers", 
			//		"--x-grid", "DAY:1:DAY:1:DAY:1:86400:%a",
			//		"--y-grid", "0:1",
			//		"--units-length", "5",
			//		"--units=si",
					"--grid-dash", "1:3",
					"--alt-autoscale-max",
					"--alt-y-grid",
					"VRULE:00#F00",
					"COMMENT: \\n",
					"COMMENT:\\t",
					"COMMENT:\\t",
					"COMMENT:\\t",
					"COMMENT: MAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  CURRENT\\n",
					"COMMENT: \\s"
				);
	
	
	if($num_rows != 0)
	{			
		if(empty($_GET['server_metrics']))
		{
			$met_list = array_keys($match);
		}		
		else
		{
			foreach($_GET['server_metrics'] as $input => $output)
			{			
				if($output == "all")
				{
					$met_list = array_keys($match);
				}
				else
				{
					$met_list = $_GET['server_metrics']['list'];
				}
			}
		}
		

		while($row = mysqli_fetch_assoc($result))
		{
			$file = "./RRD files/" . $row["IP"] . ".rrd";
			array_push($opts, "COMMENT: Server\:" . $row["IP"] . "\\n");
			
			if(file_exists($file))
			{	
				foreach($met_list as $key)
				{
					$colour = colour_append();
					array_push($opts, 
								"DEF:" . $match[$key] . '_' . $row['id'] . "=" . $file . ":" . $match[$key] . ":AVERAGE",
								"VDEF:max_" . $match[$key] . '_' . $row['id'] . "=" . $match[$key] . '_' . $row['id'] . ",MAXIMUM",
								"VDEF:avg_" . $match[$key] . '_' . $row['id'] . "=" . $match[$key] . '_' . $row['id'] . ",AVERAGE",
								"VDEF:last_" . $match[$key] . '_' . $row['id'] . "=" . $match[$key] . '_' . $row['id'] . ",LAST",
								"COMMENT: \\s");
								
					if($key === 'CPU Utilization')
					{
						array_push($opts, "LINE1:" . $match[$key] . '_' . $row['id'] . "#" . $colour . ":" . $key . "\\t");
					}
					else{
						array_push($opts, "LINE1:" . $match[$key] . '_' . $row['id'] . "#" . $colour . ":" . $key . "\\t\\t");
					}
								
					array_push($opts,
								"GPRINT:max_" . $match[$key] . '_' . $row['id'] . ": %3.2lf %s" . $units[$key] . "\\t",
								"GPRINT:avg_" . $match[$key] . '_' . $row['id'] . ": %3.2lf %s" . $units[$key] . "\\t",
								"GPRINT:last_" . $match[$key] . '_' . $row['id'] . ": %3.2lf %s" . $units[$key] . "\\n");

				}
				array_push($opts, "COMMENT: \\n");
			}
		}
		
		$img_location = "./RRD files/servers_" . $_GET['duration'] . "d.png";
		$ret = rrd_graph($img_location, $opts);

		if ($ret === FALSE)
		{
			echo "<b>Graph error: </b>".rrd_error()."\n";
		}
		else
		{
			echo "	<td>
						<img style = 'margin: 0;' src = '" . $img_location . "' title = 'Comparision of Server'>
					 </td>";
		}
	}


//DEVICES
	$query = "SELECT * FROM plot_DEVICES";
	$result = mysqli_query($connection, $query) or die("Error:" . mysqli_error($connection));
	$num_rows = mysqli_num_rows($result);
	
	$opts = array(
					"--start", "-" . $_GET['duration'] . "h",
					"--width", "500",
					"--lower-limit", "0",
					"--slope-mode",
				//		"--units-exponent", "6",
				//		"--rigid",
					"--title=Devices", 
				//		"--x-grid", "HOUR:1:HOUR:2:HOUR:2:0:%H",
				//		"--y-grid", "0:1",
				//		"--units-length", "5",
					"--units=si",
					"--grid-dash", "1:3",
					"--alt-autoscale-max",
					"--alt-y-grid",
					"--vertical-label=Bytes per Second",
					"VRULE:00#F00",
					"COMMENT: \\n",
					"COMMENT:\\t",
					"COMMENT:\\t",
					"COMMENT:\\t",
					"COMMENT: MAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  CURRENT\\n",
					"COMMENT: \\s"
					);


	if($num_rows != 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$file = "./RRD files/" . $row["IP"] . "_" . $row["PORT"] . "_" . $row["COMMUNITY"] . ".rrd";
			$variable_line = array();
			
			if(file_exists($file))
			{
				array_push($opts, "COMMENT: Device\: " . $row["IP"] . " " . $row["PORT"] . " " . $row["COMMUNITY"] . "\\n");
				$variable_line = explode('|', $row['Interface_List']);	
				$ifs = count($variable_line);
				$plus_array = array_fill(0, ($ifs - 1), '+');
				$cdef_in = array();
				$cdef_out = array();
				
				foreach($variable_line as $key)
				{	
					$colour1 = colour_append();
					$colour2 = colour_append();
					array_push($opts, 
								"DEF:bytesIn_" . $key . '_' . $row['id'] . "=" . $file . ":bytesIn" . $key . ":AVERAGE",
								"LINE1:bytesIn_" . $key . '_' . $row['id'] . "#" . $colour1 . ":Bytes In " . $key . "\\t",
								"GPRINT:bytesIn_" . $key . '_' . $row['id'] . ":MAX: %6.2lf %sBps\\t",
								"GPRINT:bytesIn_" . $key . '_' . $row['id'] . ":AVERAGE: %6.2lf %sBps\\t",
								"GPRINT:bytesIn_" . $key . '_' . $row['id'] . ":LAST: %6.2lf %sBps\\n",
								"DEF:bytesOut_" . $key . '_' . $row['id'] . "=" . $file . ":bytesOut" . $key . ":AVERAGE",
								"LINE1:bytesOut_" . $key . '_' . $row['id'] . "#" . $colour2 . ":Bytes Out " . $key . "\\t",
								"GPRINT:bytesOut_" . $key . '_' . $row['id'] . ":MAX: %6.2lf %sBps\\t",
								"GPRINT:bytesOut_" . $key . '_' . $row['id'] . ":AVERAGE: %6.2lf %sBps\\t",
								"GPRINT:bytesOut_" . $key . '_' . $row['id'] . ":LAST: %6.2lf %sBps\\n"
							  );
							  
					array_push($cdef_in, "bytesIn_" . $key . '_' . $row['id']);
					array_push($cdef_out, "bytesOut_" . $key . '_' . $row['id']);
				}
				
				$colour1 = colour_append();
				$colour2 = colour_append();
				
				array_push($opts,
							"COMMENT: \\s",
							"CDEF:bytesIn" . $row['id'] . "=" . implode(',', $cdef_in) . ',' . implode(',', $plus_array),
							"CDEF:bytesOut" . $row['id'] . "=" . implode(',', $cdef_out) . ',' . implode(',', $plus_array),
							"LINE1:bytesIn" . $row['id'] . "#" . $colour1 . ":Bytes In Aggregate\\t",
							"GPRINT:bytesIn" . $row['id'] . ":MAX: %6.2lf %sBps\\t",
							"GPRINT:bytesIn" . $row['id'] . ":AVERAGE: %6.2lf %sBps\\t",
							"GPRINT:bytesIn" . $row['id'] . ":LAST: %6.2lf %sBps\\n",
							"LINE1:bytesOut" . $row['id'] . "#" . $colour2 . ":Bytes Out Aggregate\\t",
							"GPRINT:bytesIn" . $row['id'] . ":MAX: %6.2lf %sBps\\t",
							"GPRINT:bytesIn" . $row['id'] . ":AVERAGE: %6.2lf %sBps\\t",
							"GPRINT:bytesIn" . $row['id'] . ":LAST: %6.2lf %sBps\\n",
							"COMMENT: \\n", "COMMENT: \\n");
				
			}
		}
		
		$img_location = "./RRD files/devices_" . $_GET['duration'] . "-d.png";
		$ret = rrd_graph($img_location, $opts);

		if ($ret === FALSE)
		{
			echo "<b>Graph error: </b>".rrd_error()."\n";
		}
		else
		{
			echo "	<td>
						<img style = 'margin: 0;' src = '" . $img_location . "' title = 'Comparision of Server Metrics'>
					 </td>
				   </tr>";
		}
	}
}


function colour_append()
{
	$colour = dechex(rand(0, 0xFFFFFF));
	$count = strlen($colour);

	if($count < 6)
	{
		$colour = implode('', array(implode('', array_fill(0, (6 - $count), '0')), $colour));
	}
	return $colour;
}

?>

							</table>
						</div>						
					</div>
				</div>
				
				
								
			</div>
			
			
			
		</div>
	</body>
</html>
