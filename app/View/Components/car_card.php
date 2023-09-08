<?php

namespace App\View\Components;

use Illuminate\View\Component;

class car_card extends Component {
	public $urlForCard, $carId, $carPhotoUrl, $carTitle, $carPrice, $carYear, $carMileage, $isFavoriteIconChecked, $isCompareIconChecked;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($urlForCard, $carId, $carPhotoUrl, $carTitle, $carPrice, $carYear, $carMileage, $isFavoriteIconChecked, $isCompareIconChecked) {
		$this->$urlForCard = $urlForCard;
		$this->$carId = $carId;
		$this->$carPhotoUrl = $carPhotoUrl;
		$this->$carTitle = $carTitle;
		$this->$carPrice = $carPrice;
		$this->$carYear = $carYear;
		$this->$carMileage = $carMileage;
		$this->$isFavoriteIconChecked = $isFavoriteIconChecked;
		$this->$isCompareIconChecked = $isCompareIconChecked;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render() {
		return view('components.car_card');
	}
}
