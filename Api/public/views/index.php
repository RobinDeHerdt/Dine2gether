<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dine2gether</title>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/helpers.css">
</head>
<body ng-app="d2gApp">
	<d2g-header></d2g-header>
	<div ui-view></div>
<!-- JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.js"></script>
<!-- angular -->
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/routes.js"></script>
	<!-- controllers -->
	<script type="text/javascript" src="js/controllers/homeController.js"></script>
	<!-- directives -->
	<script type="text/javascript" src="directives/header/header.js"></script>

<!-- Google maps -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqb4o2PhbYGnWwwkdXJLmIjC-al6f7eEw&libraries=places"></script>
</body>
</html>