
    <div id="commentsection">		
		<?php
		$sql_comment_dis = "SELECT * FROM projectcomments where projectid=".$projectid;
		$res = $conn->query($sql_comment_dis);
		while ($comment_array=mysqli_fetch_assoc($res))
		{
			echo "<div class='col-sm-1'>";
			echo "<div class='thumbnail'>";
			echo "<img class='img-responsive user-photo' src='https://ssl.gstatic.com/accounts/ui/avatar_2x.png'>";
			echo "</div>";
			echo "</div>";

			echo "<div class='col-sm-5'>";
			echo "<div class='panel panel-default'>";
			echo "<div class='panel-heading'>";
			echo "<strong>".$comment_array["email"]."</strong> <span class='text-muted'>commented on ".$comment_array["postdate"]."</span>";
			echo "</div>";
			echo "<div class='panel-body'>";
			echo $comment_array["comment"];
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}

		?>
	</div>
<script>
$(document).ready(function(){
	$('.comment').keydown(function (e){
        if (e.keyCode == 13) {
            var projectid = $(this).attr('projectid');
            var comment = $(this).val();
            var posting = $.post('comment.php', { projectid: projectid, comment: comment });
	        	posting.done(function( data ){
	        		$('#comments').load('createcomment.php?projectid='+projectid);
	        	});
        }
	});
});	
</script>