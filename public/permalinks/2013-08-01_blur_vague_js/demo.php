<!DOCTYPE html>
<head>
  <title>Vague.jsの最小コード</title>
	<meta charset="UTF-8">
</head>
<body>
  <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  <script src="../../assets/js/common/Vague.js"></script>
  <img class="container" src="../../assets/img/press/image/image_163.jpg" widht="640" height="400">
  <script>
    var vague = $(".container").Vague({intensity:30});
    vague.blur();
  </script>
</body>
</html>