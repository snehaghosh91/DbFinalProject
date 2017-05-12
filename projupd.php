<?php
function fetchUpdates($conn, $projectid) {
    $sql = "SELECT * FROM projectupdates where projectid='".$projectid."' order by updatedate desc";
  $result = $conn->query($sql);
  $invcount = 0;
  while ($upd_array=mysqli_fetch_assoc($result))
  {
    
    if($invcount % 2 == 0){
      echo "<li>";
    } else{
      echo "<li class='timeline-inverted'>";
    }
    $invcount += 1;
    ?>
      <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
      <div class="timeline-panel">
        <div class="timeline-heading">
          <h4 class="timeline-title"><?php echo $upd_array["title"]; ?></h4>
          <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i><?php echo " ".$upd_array["updatedate"]; ?></small></p>
        </div>
        <div class="timeline-body">
        <h5>
        <?php echo $upd_array["longdescription"]; ?>
        </h5>
        <?php fetchUpdateMedia($conn, $projectid, $upd_array["updatedate"]); ?>
          
        </div>
      </div>
    </li>
    <?php
  }
}
function fetchUpdateMedia($conn, $projectid, $updatedate) {
  $sql = "SELECT * FROM projectmedia natural join media where projectid='".$projectid."'  and updatedate='".$updatedate."'";
  $result = $conn->query($sql);
  while ($med_array=mysqli_fetch_assoc($result))
  {
      if (strpos($med_array["name"], 'mp3') !== false):
      ?>
      <audio controls>
        <source src="imageView.php?image_name=<?php echo $med_array["name"]; ?>" type="audio/mpeg">
      </audio>
      <?php
        else:
        ?>
      <img class="projupdimg" id="<?php echo $med_array["projectid"]; ?>" src="imageView.php?image_name=<?php echo $med_array["name"]; ?>" height="300" width="300" />
      <?php
      endif;
      ?>
      <br>
      <br>
      <?php
  }
}
?>
<div class="container">
  <div class="page-header">
    <h1 id="timeline">Timeline</h1>
  </div>
  <ul class="timeline">
  <?php fetchUpdates($conn, $project_array["projectid"]); ?>
  </ul>
</div>