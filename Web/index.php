<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dine2gether</title>

    <!-- CDN styles -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">

    <!-- Application styles -->
    <link rel="stylesheet" type="text/css" href="dist/css/app.css">
	<link rel="stylesheet" href="dist/css/assets/sweetalert2.min.css">
</head>
<body ng-app="d2gApp">
	<d2g-header></d2g-header>
	<d2g-login></d2g-login>
	<d2g-register></d2g-register>
	<div ui-view></div>

    <!-- CDN scripts -->
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.js"></script>
    <script src="https://cdn.jsdelivr.net/satellizer/0.15.5/satellizer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.2.13/ng-file-upload.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqb4o2PhbYGnWwwkdXJLmIjC-al6f7eEw&libraries=places"></script>

    <!-- Application scripts -->
    <script src="dist/js/sweetalert2.min.js"></script>
    <script src="dist/js/angular-cookies.min.js"></script>
    <script src="dist/js/scripts.js"></script>
</body>
</html>