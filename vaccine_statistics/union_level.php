<?php
  $page_title = 'Union Statistics';
  require_once('../load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(3);
//pull out all user form database
 $all_users = find_all_user();
?>
<?php include_once('../header.php'); ?>
<?php
$con = mysqli_connect("localhost","root","","central_db");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1>Union Level Statistics</h1>
      <hr>
      	<?php
      	$epi_year;
		$epi_year = $_SESSION['epi_year'];

        $upazila_id = isset($_GET["id"]) ? $_GET["id"] : false;
        if ($upazila_id === false) 
        {
          exit("Something went wrong. Please try again.");
        }

      	$sqlSelect = "SELECT DISTINCT 
        union_council.union_name, union_council.union_id, 
        COUNT(child_registration_details.bcg_receive_date), 
        COUNT(child_registration_details.penta1_receive_date), 
        COUNT(child_registration_details.penta2_receive_date), 
        COUNT(child_registration_details.penta3_receive_date), 
        COUNT(child_registration_details.bopv1_receive_date),
        COUNT(child_registration_details.bopv2_receive_date),
        COUNT(child_registration_details.bopv3_receive_date), 
        COUNT(child_registration_details.pcv1_receive_date), 
        COUNT(child_registration_details.pcv2_receive_date), 
        COUNT(child_registration_details.pcv3_receive_date),
        COUNT(child_registration_details.ipv1_receive_date), 
        COUNT(child_registration_details.ipv2_receive_date),  
        COUNT(child_registration_details.mr1_receive_date), 
        COUNT(child_registration_details.mr2_receive_date)
        FROM division 
        JOIN district ON division.division_id = district.division_id 
        JOIN upazila ON district.district_id = upazila.district_id 
        JOIN union_council ON upazila.upazila_id = union_council.upazila_id 
        JOIN child_registration_details ON union_council.union_id = child_registration_details.union_id 
        WHERE child_registration_details.epi_year = $epi_year 
        AND upazila.upazila_id = $upazila_id 
        GROUP BY union_council.union_name";
        $result = mysqli_query($con, $sqlSelect);
            
        if (mysqli_num_rows($result) > 0) 
        {
        ?>
        <div class="table-responsive">
        <div class="table table-sm">
        <table id='DivisionTable' class="table table-bordered table-striped">
        <thead>
          <tr>
                <th class="text-left">UNION</th>
                <th class="text-right">BCG</th>
                <th class="text-right">PENTA-1</th>
                <th class="text-right">PENTA-2</th>
                <th class="text-right">PENTA-3</th>
                <th class="text-right">BOPV-1</th>
                <th class="text-right">BOPV-2</th>
                <th class="text-right">BOPV-3</th>
                <th class="text-right">PCV-1</th>
                <th class="text-right">PCV-2</th>
                <th class="text-right">PCV-3</th>
                <th class="text-right">IPV-1</th>
                <th class="text-right">IPV-2</th>
                <th class="text-right">MR-1</th>
                <th class="text-right">MR-2</th>
                <th class="text-right">DETAILS</th>
            </tr>
        </thead>
      <?php
            while ($row = mysqli_fetch_array($result)) 
            {
          ?>    
                <tbody>
                <tr>
                    <td class="text-left"><?php  echo $row['union_name']; ?></td>
                    <td class="text-right"><?php  echo $row[2]; ?></td>
                    <td class="text-right"><?php  echo $row[3]; ?></td>
                    <td class="text-right"><?php  echo $row[4]; ?></td>
                    <td class="text-right"><?php  echo $row[5]; ?></td>
                    <td class="text-right"><?php  echo $row[6]; ?></td>
                    <td class="text-right"><?php  echo $row[7]; ?></td>
                    <td class="text-right"><?php  echo $row[8]; ?></td>
                    <td class="text-right"><?php  echo $row[9]; ?></td>
                    <td class="text-right"><?php  echo $row[10]; ?></td>
                    <td class="text-right"><?php  echo $row[11]; ?></td>
                    <td class="text-right"><?php  echo $row[12]; ?></td>
                    <td class="text-right"><?php  echo $row[13]; ?></td>
                    <td class="text-right"><?php  echo $row[14]; ?></td>
                    <td class="text-right"><?php  echo $row[15]; ?></td>
                    <?php
                    echo "<td class='text-right'>".'<a href=../vaccine_statistics/ward_level.php?id='.$row['union_id'].'>VIEW</a>'. "</td>";
                    ?>
                </tr>
            <?php
            }
            ?>
                </tbody>
      </table>
        <?php 
      } 
      ?>
      </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('../footer.php'); ?>