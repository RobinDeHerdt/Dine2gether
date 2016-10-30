d2gApp.controller("createBookingController", function () {
	var vm = this;
	var dishes_arr = [];

	vm.numberOfPages = 4;
	vm.currentPage = 1;

	// dish_img zou eigenlijk dish_images moeten worden en een array zijn. 
	vm.addDish = function (dish_name, dish_descr, dish_img) {
		dishes_arr.push({name: dish_name, description: dish_descr, img: dish_img});
	}
});