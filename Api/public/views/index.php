<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dine2gether</title>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/helpers.css">
	<link rel="stylesheet" href="css/assets/sweetalert2.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Pacifico" rel="stylesheet">
</head>
<body ng-app="d2gApp">
	<d2g-header></d2g-header>
	<d2g-login></d2g-login>
	<d2g-register></d2g-register>
	<div ui-view></div>
<!-- JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.js"></script>
<script type="text/javascript" src="js/assets/satellizer.js"></script>
<script type="text/javascript" src="js/assets/sweetalert2.min.js"></script>
<script type="text/javascript" src="js/assets/ng-file-upload.js"></script>
<script type="text/javascript" src="js/assets/angular-cookies.min.js"></script>
<!-- angular -->
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/routes.js"></script>
	<!-- services -->
	<script type="text/javascript" src="js/services/bookingService.js"></script>
	<script type="text/javascript" src="js/services/loginService.js"></script>
	<script type="text/javascript" src="js/services/interestService.js"></script>
	<script type="text/javascript" src="js/services/kitchenstyleService.js"></script>
	<!-- controllers -->
	<script type="text/javascript" src="js/controllers/homeController.js"></script>
	<script type="text/javascript" src="js/controllers/overviewController.js"></script>
	<script type="text/javascript" src="js/controllers/bookingDetailsController.js"></script>
	<script type="text/javascript" src="js/controllers/createBookingController.js"></script>
	<script type="text/javascript" src="js/controllers/profileController.js"></script>
	<script type="text/javascript" src="js/controllers/activationController.js"></script>
	<script type="text/javascript" src="js/controllers/requestBookingController.js"></script>
	<!-- directives -->
	<script type="text/javascript" src="directives/header/header.js"></script>
	<script type="text/javascript" src="directives/login-modal/login-modal.js"></script>
	<script type="text/javascript" src="directives/register-modal/register-modal.js"></script>

<!-- Google maps -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqb4o2PhbYGnWwwkdXJLmIjC-al6f7eEw&libraries=places"></script>
</body>
</html>