$(document).ready(function(){
	$('img').click(function() {
	   var id = $(this).attr('id');
	   window.location.href = "projectdetail.php?id="+id;
   	   return false;
	});
	$("#addUpdate").hide();
        $("#updatebtn").click(function(e) {
            $("#addUpdate").show();
            $("#updatebtn").hide();

    });
	$('.comment').keydown(function (e){
        if (e.keyCode == 13) {
            var projectid = $(this).attr('projectid');
            var comment = $(this).val();
            var posting = $.post('comment.php', { projectid: projectid, comment: comment });
	        	posting.done(function( data ){
	        		$('#comments').load('commentsdisplay.php?projectid='+projectid);
	        	});
        }
	});
});


function validateForm() {
	refreshErrors();
    var title = document.forms["createproject"]["title"].value;
    var minfund = document.forms["createproject"]["minfund"].value;
    var maxfund = document.forms["createproject"]["maxfund"].value;
    var category = document.forms["createproject"]["selectedcategory"].value;
    var enddate = document.forms["createproject"]["enddate"].value;
    var releasedate = document.forms["createproject"]["releasedate"].value;
    

    flag = true;
    if (title == "") {
        document.getElementById('title').innerHTML="This field is required";
    	flag = false;
    }
    if (minfund == "") {
        document.getElementById('minfund').innerHTML="This field is required";
    	flag = false;
    }
    if (maxfund == "") {
        document.getElementById('maxfund').innerHTML="This field is required";
    	flag = false;
    }
    if (category == "" || category == "Select Category") {
        document.getElementById('category').innerHTML="This field is required";
    	flag = false;
    }
    if (enddate == "") {
        document.getElementById('enddate').innerHTML="This field is required";
    	flag = false;
    }
    if (releasedate == "") {
        document.getElementById('releasedate').innerHTML="This field is required";
    	flag = false;
    }
    alert(flag)
    return flag;
}

function refreshErrors() {
	document.getElementById('title').innerHTML="";
    document.getElementById('minfund').innerHTML="";
    document.getElementById('maxfund').innerHTML="";
    document.getElementById('category').innerHTML="";
    document.getElementById('enddate').innerHTML="";
    document.getElementById('releasedate').innerHTML="";	
}