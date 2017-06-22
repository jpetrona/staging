<?php
 include '../config.php';
//include 'wp-config.php';
?>
<?php
$id = $_GET["id"];
//$userid = $_GET["userid"];
/*if(!isset($_GET["id"])){
	exit;
}*/
$conv = 0;
$costing = 0;
$commission = 0.00;
/*$query1 = "SELECT * FROM `chartdata_sponsor` where offer = 'KupiVip - RU -HID 49735'";
$result = mysql_query($query1);
$cnv = mysql_fetch_assoc($result);
$conv = $cnv['conversions'];
$costing = $cnv['cost'];*/
$query_new = "select * from ".RETIRELY_DB.".offers where downloadurl = '$id' or androiddownloadurl = '$id' or websiteurl='$id' AND advisorid = '$userid'";
	$result1 =mysql_query($query_new) or die(mysql_error());
	while($row1 = mysql_fetch_array($result1))
	{
		//$url = $row['tapjoy_appurl'];
		$commission = $row1['commission'];
	}
$from = $_GET["from"];
$to =  $_GET["to"];

if($id == "http://mesav.com/clk.cfm?dp=33&dc=2025&s1=&s2=&s3="){
	$jid = "http://tapjoy.go2cloud.org/aff_c?offer_id=4212&aff_id=1&aff_sub=TAPJOY_GENERIC";
	/*
	$query="SELECT sum( sessions ) AS sessions, date, sum( newusers ) AS newusers, sum( dailyactiveusers ) AS dailyactiveusers, sum( offerwallconversions ) AS offerwallconversions, sum( offerwallclicks ) AS offerwallclicks, sum( spend ) AS spend,sum( paidInstalls ) AS paidInstalls,sum( paidclicks ) AS paidclicks, name
	FROM ".RETIRELY_DB.".reporting_cart
	WHERE `url` = '".$id."' and DATE_FORMAT(date,'%Y-%m-%d') between '$from' AND '$to' GROUP BY DATE_FORMAT( date, '%Y-%m-%d' ) , name";
	*/
	$query="SELECT sum( sessions ) AS sessions, date, sum( newusers ) AS newusers, sum( dailyactiveusers ) AS dailyactiveusers, sum( offerwallconversions ) AS offerwallconversions, sum( offerwallclicks ) AS offerwallclicks, sum( spend ) AS spend,sum( paidInstalls ) AS paidInstalls,sum( paidclicks ) AS paidclicks, name, rewardbid
	FROM
	(
	SELECT 0 AS sessions, date, 0 AS newusers, 0 AS dailyactiveusers, 0 AS offerwallconversions, 0 AS offerwallclicks, sum( conversions * rewardbid) AS spend, sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks, '' as name, rewardbid
	FROM ".RETIRELY_DB.".hasofferstats
	WHERE `offerurl` = '".$id."' and DATE_FORMAT(date,'%Y-%m-%d') between '$from' AND '$to' GROUP BY DATE_FORMAT( date, '%Y-%m-%d' )
	) as result 
	GROUP BY DATE_FORMAT( date, '%Y-%m-%d' ), rewardbid";

	}
	else if($id == "http://whotrades.com/landing/43267472841/v1"){
	$jid = "http://tapjoy.go2cloud.org/aff_c?offer_id=4156&aff_id=1&aff_sub=TAPJOY_GENERIC";
	$query="SELECT sum( sessions ) AS sessions, date, sum( newusers ) AS newusers, sum( dailyactiveusers ) AS dailyactiveusers, sum( offerwallconversions ) AS offerwallconversions, sum( offerwallclicks ) AS offerwallclicks, sum( spend ) AS spend,sum( paidInstalls ) AS paidInstalls,sum( paidclicks ) AS paidclicks, name, rewardbid
	FROM
	(
	SELECT 0 AS sessions, date, 0 AS newusers, 0 AS dailyactiveusers, 0 AS offerwallconversions, 0 AS offerwallclicks, sum( conversions * rewardbid) AS spend, sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks, '' as name, rewardbid
	FROM ".RETIRELY_DB.".hasofferstats
	WHERE `offerurl` = '".$id."' and DATE_FORMAT(date,'%Y-%m-%d') between '$from' AND '$to' GROUP BY DATE_FORMAT( date, '%Y-%m-%d' )
	) as result 
	GROUP BY DATE_FORMAT( date, '%Y-%m-%d' ), rewardbid";
	}
	else{
		$query="SELECT sum( sessions ) AS sessions, date, sum( newusers ) AS newusers, sum( dailyactiveusers ) AS dailyactiveusers, sum( offerwallconversions ) AS offerwallconversions, sum( offerwallclicks ) AS offerwallclicks, sum( spend ) AS spend,sum( paidInstalls ) AS paidInstalls,sum( paidclicks ) AS paidclicks, name
FROM ".RETIRELY_DB.".reporting_cart
WHERE `url` = '".$id."' and DATE_FORMAT(date,'%Y-%m-%d') between '$from' AND '$to' GROUP BY DATE_FORMAT( date, '%Y-%m-%d' ) , name";
		
		}

$q=mysql_query($query) or die(mysql_error());
//echo $query;die;
$data;

if(mysql_num_rows($q) > 0)
{	
	while($row = mysql_fetch_assoc($q))
			  {
				$data[] = array ("date"=>$row["date"],"sessions"=>$row['sessions'],"newusers"=>$row["newusers"],"dailyactiveusers"=>$row['dailyactiveusers'],"offerwallconversions"=>$row["offerwallconversions"],"offerwallclicks"=>$row['offerwallclicks'],"spend"=> abs($row["spend"]),"name"=>$row["name"],"paidInstalls"=> abs($row["paidInstalls"]),"paidclicks"=>$row["paidclicks"]);
					//var_dump($data);
			  } 
}else{
	$data;	
		$query_new = "select * from ".RETIRELY_DB.".offers where downloadurl = '$id' or androiddownloadurl = '$id' or websiteurl='$id' and DATE_FORMAT(date,'%Y-%m-%d') between '$from' AND '$to' GROUP BY DATE_FORMAT( date, '%Y-%m-%d' ) , title";

			$res_new = mysql_query($query_new) or die(mysql_error());
                if(mysql_num_rows($res_new) > 0)
                {	
					while($row_new = mysql_fetch_assoc($res_new))
					{
						$offerid = $row_new['offerid'];
						$qoffer = "SELECT offerid FROM ".RETIRELY_DB_OFFERWALL.".offers where extofferid ='$offerid'";
						$resoffer = mysql_query($qoffer) or die(mysql_error());
						if(mysql_num_rows($resoffer) > 0)
						{
							$result_row = mysql_fetch_assoc($resoffer);
							$extofferid = $result_row['offerid'];						
							$q1 = "SELECT count(*) as count, sum(rewardedbid) as spends FROM ".RETIRELY_DB_OFFERWALL.".usertracking where offerid = '$extofferid'";
							$res1 = mysql_query($q1) or die(mysql_error());
							if(mysql_num_rows($res1) > 0)
							{	
								while($row1 = mysql_fetch_assoc($res1))
								{
									$spends = $row1['spends'];
									$count = $row1['count'];
									if($count != 0){
									$spends = number_format($spends,2);
									$spends = $spends * 100;
									$sessions = "1";
									$newusers = "1";
									$dailyactiveusers="1";
									$offerwallconversions = "1";
									$offerwallclicks = $count;
									$spend = $spends;
									$name = $row_new['title'];
									$date = '2014-03-25 17:45:06';
									}else{
									$spends = 0;
									$sessions = "0";
									$newusers = "0";
									$dailyactiveusers="0";
									$offerwallconversions = "0";
									$offerwallclicks = 0;
									$spend = $spends;
									$name = $row_new['title'];
									$date = '2014-03-25 17:45:06';
									}
									
									$data[] = array ("date"=>$date,"sessions"=>$sessions,"newusers"=>$newusers,"dailyactiveusers"=>$dailyactiveusers,"offerwallconversions"=>$offerwallconversions,"offerwallclicks"=>$offerwallclicks,"spend"=> $spend,"name"=>$name,"paidInstalls"=> $count,"paidclicks"=>$offerwallclicks);
									/*echo '<pre>';
									print_r($data);*/
								}
								
							}
							else{
									/*$rewardedbid_old = 0.00;
									$rewardedbid_old = number_format($rewardedbid_old,2);*/
									$spends = 0;
									$count=1;
									//$spends = number_format($spends,2);
									//$spends =  $spends * $rewardedbid_old;
									/*$rewardedbid = 0.00;
									$rewardedbid = number_format($rewardedbid,2);*/
									$sessions = "1";
									$newusers = "1";
									$dailyactiveusers="1";
									$offerwallconversions = "1";
									$offerwallclicks = 1;
									$spend = $spends;
									$name = $row_new['title'];
									$date = '2014-03-25 17:45:06';
									$data[] = array ("date"=>$date,"sessions"=>$sessions,"newusers"=>$newusers,"dailyactiveusers"=>$dailyactiveusers,"offerwallconversions"=>$offerwallconversions,"offerwallclicks"=>$offerwallclicks,"spend"=> $spend,"name"=>$name,"paidInstalls"=> $count,"paidclicks"=>$offerwallclicks);
								
								}
						}
					}
				}
			}
								
	$sessions = "0";
	$newusers = "0";
	$dailyactiveusers="0";
	$offerwallconversions = "0";
	$offerwallclicks = "0";
	$spend = "0";
	$name = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/mcataxes/css/jquery.jqChart.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/mcataxes/css/jquery.jqRangeSlider.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/mcataxes/themes/smoothness/jquery-ui-1.8.21.css" />
    <script src="<?php bloginfo('template_directory'); ?>/mcataxes/js/jquery-1.5.1.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/mcataxes/js/jquery.jqChart.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/mcataxes/js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
    <!--[if IE]><script lang="javascript" type="text/javascript" src="../js/excanvas.js"></script><![endif]-->
    <script lang="javascript" type="text/javascript">
        $(document).ready(function () {
			var commission = $('#commission').val();
			var datamax = new Array();
			var data = new Array();
			var datauser = new Array(); 
			var dataDAUS = new Array();
			var dataARPDAU = new Array();
			var dataofferwallconversions = new Array();
			var dataofferwallclicks = new Array(); 
			var dataspend = new Array();
			var datapaidInstalls = new Array();
			var name = $("#offer_name").val();
			Array.prototype.max = function() {
			var max = this[0];
			var len = this.length;
			for (var i = 1; i < len; i++) if (this[i] > max) max = this[i];
			return max;
			}
			var session =0;
			var newusers =0;
			var paidInstalls=0;
			var spend=0;
			var offerwallclicks=0;
			<?php foreach($data as $val){ ?>
				<?php //$date = $val['date']; $date = date("F j, Y");
				/*$commission_new = ($commission / 100) * $val['spend'];
				$spend_new = $val['spend'] +$commission_new;*/?>
				var cmsn = parseFloat(<?php echo $commission?>);
				var s = <?php echo $val['sessions'] ?>;
				session = parseInt(session)+parseInt(s);
				var u = <?php echo $val['newusers'] ?>;
				newusers = parseInt(newusers)+parseInt(u);
				var c = <?php echo $val['offerwallconversions'] ?>;
				var offerwallconversions = parseInt(c)+parseInt(c);
				var sp = <?php echo $val['spend'] ?>;
				spend = parseFloat(spend)+parseFloat(sp);
				
				var cc = <?php echo $val['paidclicks'] ?>;
				var offerwallclicks = parseInt(offerwallclicks)+parseInt(cc);
				var pi = <?php echo $val['paidInstalls'] ?>;
				var paidInstalls = parseInt(paidInstalls)+parseInt(pi);
				datamax.push(<?php echo $val['sessions']; ?>);
				datamax.push(<?php echo $val['newusers']; ?>);
				datamax.push(<?php echo $val['dailyactiveusers']; ?>);
				data.push(['<?php echo $val['date']; ?>',<?php echo $val['sessions']; ?>]);
				datauser.push(['<?php echo $val['date']; ?>',<?php echo $val['newusers']; ?>]);
				dataDAUS.push(['<?php echo $val['date']; ?>',<?php echo $val['dailyactiveusers']; ?>]);
				dataARPDAU.push(['<?php echo $val['date']; ?>',0.00]);
				dataofferwallconversions.push(['<?php echo $val['date']; ?>',<?php echo $val['paidInstalls'];?>]);
				dataofferwallclicks.push(['<?php echo $val['date']; ?>',<?php echo $val['paidclicks']; ?>]);
				dataspend.push(['<?php echo $val['date']; ?>',<?php echo $val['spend']?>]);
				datapaidInstalls.push(['<?php echo $val['date']; ?>',<?php echo $val['paidInstalls']?>]);
				//alert(dataofferwallclicks[0]+ " " +dataofferwallclicks[1]);
			<?php } ?>
			//['Date','<?php //echo $val['date']; ?>'],
				//cmsn = parseFloat(cmsn).toFixed(2);
				
				var cnv = <?php echo $conv;?>;
				var costing = <?php echo $costing;?>;
				var cost = parseFloat(costing).toFixed(3);
				
				var paidinstalls1 = cnv +paidInstalls;
				commission_new = (cmsn / 100) * spend;
			var spend1 = spend + commission_new + costing;
			spend1 = spend1/100;
			spend1 = parseFloat(spend1).toFixed(3);
			//spend1 = -1012.30;
			var maxval=datamax.max();
			var interval = parseInt(maxval/100);
			var gridLinesInterval=10;
			var unitInterval=5;
			 
			if(datamax.length>20){
				if(maxval){
					maxval=maxval*.5;
				}
			}
			if(datamax.length<10){
				 gridLinesInterval = 1;
				 unitInterval=1;
			}else{
				gridLinesInterval = datamax.length*0.5;
			    unitInterval=5;
			}
			
            $('#jqChart').jqChart({
                title: { text: "Sessions: "+session+"  New Users: "+newusers },
				legend: { location: 'top' },
				tooltips: {
							  type: 'shared'
						  },
				axes: [
                         {
                             location: 'bottom',
							 labels: { visible: true },
							 interval: unitInterval
                         },{
                             name: 'Unit',
                             location: 'left',
							 minimum: 0
                         },
                         {
                             name: 'Amount',
                             location: 'right',
							 minimum: 0,
							 //maximum: 100,
							// interval: 10,
                             strokeStyle: '#FCB441',
							 labels: { 
									stringFormat: '$ %s ' 
							},
							 majorGridLines: { strokeStyle: '#FCB441' },
                             majorTickMarks: { strokeStyle: '#FCB441' }
                            
                         }
                      ],
                series: [
                            {
                                type: 'line',
								title: 'Sessions',
                                axisY: 'Unit',
								data: data //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            },
                            {
                                type: 'line',
								title: 'New User',
                                axisY: 'Unit',
                                data: datauser//[['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            },
							
							{
                                type: 'line',
								title: 'DAUS',
								axisY: 'Unit',
								data: dataDAUS //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            },
							{
                                type: 'line',
								title: 'ARPDAU',
								axisY: 'Amount',
								data: dataARPDAU //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            }
                        ]
            });
			
			$('#jqChart2').jqChart({
                title: { text: "Total Paid Conversions: "+paidinstalls1+"  Total Clicks: "+offerwallclicks+"  Total Spend: $"+spend},
				legend: { location: 'top' },
				tooltips: {
							  type: 'shared'
						  },
				axes: [
                         {
                             location: 'bottom',
							 labels: { visible: true },
							 interval: unitInterval
                         },{
                             name: 'Conversions',
                             location: 'left',
							 minimum: 0
                         },
                         {
                             name: 'spend',
                             location: 'right',
							 minimum: 0,
                             strokeStyle: '#FCB441',
							 labels: { 
									stringFormat: '$ %s ' 
							},
							 majorGridLines: { strokeStyle: '#FCB441' },
                             majorTickMarks: { strokeStyle: '#FCB441' }
                            
                         }
                      ],
                series: [
                            {
                                type: 'line',
								title: 'Conversions',
                                axisY: 'Conversions',
								data: dataofferwallconversions //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            },
                            {
                                type: 'line',
								title: 'Clicks',
                                axisY: 'Conversions',
                                data: dataofferwallclicks//[['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            },
							
							{
                                type: 'line',
								title: 'spend',
								axisY: 'spend',
								data: dataspend //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            }
                        ]
            });
			$('#jqChart3').jqChart({
                title: { text: "Paid Installs: "+paidInstalls+"  + Ranks: " },
				legend: { location: 'top' },
				tooltips: {
							  type: 'shared'
						  },
				axes: [
                         {
                             location: 'bottom',
							 labels: { visible: true },
							 interval: unitInterval
                         },
						 {
                             name: 'Paid',
                             location: 'left',
							 minimum: 0
                         }
                      ],
                series: [
                            {
                                type: 'line',
								title: 'Paid Installs',
                                axisY: 'Paid',
								data: datapaidInstalls //[['a', 40], ['b', 60], ['c', 62], ['d', 52], ['e', 70], ['f', 75]]
                            }
                        ]
            });
			
			  $('#jqChart').bind('tooltipFormat', function (e, data) {
			
				  if ($.isArray(data) == false) {
			
					  var tooltip = '<b>' + data.x + '</b></br>';
			
					  tooltip += '<span style="color:' + data.series.fillStyle + '">' +
								  data.series.title + '</span>: $$' + data.y + '</br>';
			
					  return tooltip;
				  }
			
				  var tooltip = '<b>' + data[0].x + '</b></br>';
			
				  for (var i = 0; i < data.length; i++) {
			
					var context = data[i];
					
					if(context.series.title == "ARPDAU"){ 
					
					tooltip += '<span style="color:' + context.series.fillStyle + '">' +
								context.series.title + '</span>: $' + context.y + '</br>';

						} else{
							
					tooltip += '<span style="color:' + context.series.fillStyle + '">' +
								context.series.title + '</span>: ' + context.y + '</br>';
					}
					
				  }
			
				  return tooltip;
			  });  
        });
    </script>
</head>
<body>
    <div>
        <div id="jqChart" style="width: 100%; height: 300px;">
        </div><br><br>
		<div id="jqChart2" style="width: 100%; height: 300px;">
        </div><br><br>
		<div id="jqChart3" style="width: 100%; height: 300px;">
        </div>
    </div>
</body>
</html>
