<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script
			  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
			  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
			  crossorigin="anonymous">
      </script>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    .slidingDiv {
  height:300px;
  background-color: #99CCFF;
  border-bottom:5px solid #3399FF;
}
.show_hide {
  display:none;
}
    </style>
    <script type="text/javascript">
    $(document).ready(function () {

  $(".slidingDiv").hide();
  $(".show_hide").show();

  $('.show_hide').click(function () {
      $(".slidingDiv").toggle("slide", {direction:'right'});
  });

});
    </script>
  </head>
  <body>
    <div class="slidingDiv">Fill this space with really interesting content. <a href="#" class="show_hide">hide</a>
</div>
<a href="#" class="show_hide">Show/hide</a>
  </body>
</html>
