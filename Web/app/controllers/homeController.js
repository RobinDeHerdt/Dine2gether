d2gApp.controller("homeController", function ($location) {
    var vm = this;

    if ($location.url() !== "/home") {
        var fullQueryString = $location.url().split("?")[1];

        if (fullQueryString.split("=")[0] === "status") {
            switch (fullQueryString.split("=")[1]) {
                case "activated":
                    swal({
                        title: "Account activation",
                        text: "Your account was successfully activated.",
                        type: "success"
                    });
                    break;

                case "already-activated":
                    swal({
                        title: "Account activation",
                        text: "Your account was already activated.",
                        type: "info"
                    });
                    break;

                default:
                    swal({
                        title: "Account activation",
                        text: "Something went wrong when activating your account.",
                        type: "error"
                    });
                    break;
            }
        }
    }

    function autoComplete() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
        });
    }

    vm.checkIfInputLocation = function () {
        if ($("#autocomplete").val().trim() !== "") {
            $location.path('/overview/' + $("#autocomplete").val());
        }
    };

    autoComplete();
});