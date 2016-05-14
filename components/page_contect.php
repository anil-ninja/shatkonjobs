<?php 
$condition = "";
$status = $_GET['status'];
if (!isset($_GET['status'])) {
   $id = $_SESSION['user_id'];  
   $user = mysqli_query($db_handle, "SELECT * FROM user WHERE team_head = '$id' AND employee_type = 'cem' ; ") ;
?>
<table id="example1" class="display" cellspacing="0" >
  <thead>
   <tr>
      <th >Employee Name</th>
      <th >Mobile</th>
      <th >Email ID</th>
      <th >Reg. Date</th>
      <th >Picked Requests</th>
      <th >Meeting Requests</th>
      <th >Demo Requests</th>
      <th >Done Requests</th>
   </tr>
  </thead>
  <tbody>
  <?php 
   while ($userRow = mysqli_fetch_array($user)){ 
   $user_id = $userRow['id'];
   echo "<tr>
            <td>".strtoupper($userRow['first_name'])." ".strtoupper($userRow['last_name'])."</td>
            <td>".$userRow['phone']."</td>
            <td>".$userRow['email']."</td>
            <td>".$userRow['reg_date']."</td>
            <td onclick='viewrequests(\"picked\", \"cem\",".$user_id.");'>".countRequest('picked', 'cem', $user_id,  $db_handle)."</td>
            <td onclick='viewrequests(\"meeting\", \"cem\",".$user_id.");'>".countRequest('meeting', 'cem', $user_id,  $db_handle)."</td>
            <td onclick='viewrequests(\"demo\", \"cem\",".$user_id.");'>".countRequest('demo', 'cem', $user_id,  $db_handle)."</td>
            <td onclick='viewrequests(\"done\", \"cem\",".$user_id.");'>".countRequest('done', 'cem', $user_id,  $db_handle)."</td>
         </tr>
         <tr><span id='userDetails_".$user_id."' style='width:100%;'> </span></tr>" ;
   }
?>
  </tbody> 
</table>
<?php }
else {
   if ($status == "open") $condition = " cem_id = 0 AND me_id = 0 ";
   elseif ($status == "all") $condition = "1" ;
   elseif ($status == "meeting") $condition = "status = 'meeting'" ;
   elseif ($status == "me_open") $condition = " status = 'me_open'" ;
   elseif ($status == "cem_open") $condition = " cem_id = 0 AND me_id != 0 AND (match_id != 0 OR match2_id != 0)" ;
   elseif ($status == "salary_issue") $condition = "status = 'salary_issue'" ;
   elseif ($status == "demo") $condition = "status = 'demo'";
   elseif ($status == "done") $condition = "status = 'done'";
   elseif ($status == "delete") $condition = "status = 'delete'";
   elseif ($status == "not_interested") $condition = "status = 'not_interested'" ;
   elseif ($status == "decay") $condition = "status = 'decay'";
   elseif ($status == "just_to_know") $condition = "status = 'just_to_know'" ;
   elseif ($status == "followback") $condition = "status = 'followback'" ;
   elseif ($status == "feedback") $condition = "status = 'feedback'" ;
   elseif ($status == "24") $condition = " work_time = 24 " ;
   else $condition = "status = ".$status ;
   $srs = mysqli_query($db_handle, "SELECT * FROM service_request WHERE ".$condition." ORDER BY 'date' DESC; ") ;
   while ($srsrow = mysqli_fetch_array($srs)){ 
      $id = $srsrow['id'];
      $skill = mysqli_query($db_handle, "SELECT a.name, a.id FROM skill_name AS a JOIN skills AS b WHERE b.user_id = '$id'
                                       AND b.status = 'open' AND b.type = 'client' AND a.id = b.skill_id ;");
?>
<div class="list-group countRequest">
   <p style="font-size:16px;padding-left: 2em;">
      <a  class="list-group-item" style="background-color:<?= headerColor($srsrow['priority']); ?>;border-color:<?= headerColor($srsrow['priority']); ?>;">
        Client Name  <span style="padding-left: 5em"><?= $srsrow['name'] ?></span>
        <span style="padding-left: 3em">ID : <?= $srsrow['id'] ?></span>
        <span style="padding-left: 3em">Creation Date : <?= $srsrow['created_time'] ?></span></a>
      <a  class="list-group-item "> Mobile  <span style="padding-left: 6em"><?= $srsrow['mobile'] ?></span>
         <span style="padding-left: 4em">Working Time : <?= $srsrow['work_time'] ?></span></a>
      <a  class="list-group-item">Address <span style="padding-left: 7em"><?= $srsrow['address'] ?></span></a>
      <a  class="list-group-item">Timings <span style="padding-left: 6em"><?= $srsrow['timings'] ?></span>
         <span style="padding-left: 5em">Salary Criteria : <?php echo $srsrow['min_salary']."-".$srsrow['max_salary']." K "; ?></span></a>
      <a  class="list-group-item"> Requirements<span style="padding-left: 5em"><?= $srsrow['requirements'] ?></span>
         <span style="padding-left: 3em">Gender : <?= $srsrow['gender'] ?></a>
      <a  class="list-group-item">Remarks <span style="padding-left: 7em"><?= $srsrow['remarks'] ?></span></a>
      <a  class="list-group-item">Worker Area <span style="padding-left: 5em"><?= $srsrow['worker_area'] ?></span></a> 
      <a  class="list-group-item "> Skills  <span style="padding-left: 7em">
         <?php 
            while($skillrow = mysqli_fetch_array($skill)){ 
               echo $skillrow['name'].", ";
            }
         ?>
         </span>
      </a>       
      <?php 
         if($status == "demo" OR $status == "meeting" OR $status == "done" OR $status == "feedback") {                         
            $id =  $srsrow['id'];
            $meeting = mysqli_query($db_handle, "SELECT * FROM meetings WHERE match_id = '$id' ORDER BY meeting_time DESC LIMIT 0 , 1; ") ;
            $meetingRow = mysqli_fetch_array($meeting); 
      ?>
      <a  class="list-group-item">Meeting Time <span style="padding-left: 5em"><?= $meetingRow['meeting_time'] ?></span></a>
      <a  class="list-group-item "> Remarks  <span style="padding-left: 7em"><?= $meetingRow['remarks'] ?></span></a>
      <a  class="list-group-item">
         <button class="btn btn-primary" style="margin-left: 70%" onclick="workerDetails(<?= $srsrow['id'] ?>, 3);" >Worker Details</button>
      </a>
      <?php } ?>
      <a  class="list-group-item" >
         <button class="btn btn-primary" style="margin-left: 40%" onclick="Update(<?= $srsrow['id'] ?>);">Update request</button>
         <button class="btn btn-primary"  onclick="viewNotes(<?= $srsrow['id'] ?>, 1);" >View Notes</button>
         <button class="btn btn-primary"  onclick="changeStatus(<?= $srsrow['id'] ?>, <?= $srsrow['status'] ?>, 3);" >Change Status</button>
      </a>
      <a  class="list-group-item" >
        <span id="workerform_<?= $srsrow['id'] ?>"></span>
      </a>
   </p>
</div>
<?php }
} ?>
