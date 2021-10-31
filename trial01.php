<?php
	interface Sorter {
		public function sort($products);
	}

	class Catalog {
		public $products;
		public function __construct($products) {
			$this->products = $products;
		}

		public function getProducts($sorter) {
			var_dump($sorter->sort($this->products));
		}
	}

	class ProductPriceSorter implements Sorter {
		public function sort($products) {
			$keys = array_column($products, 'price');
			array_multisort($keys, SORT_ASC, $products);

			return $products;
		}
	}

	class ProductSalesPerViewSorter implements Sorter {
		public function sort($products) {
			foreach($products as $key => $product) {
				$products[$key]['ratio'] = $product['views_count'] / $product['sales_count'];
			}
			$keys = array_column($products, 'ratio');
			array_multisort($keys, SORT_ASC, $products);

			return $products;
		}
	}

	$products = [
	   [
	      'id' => 1,
	      'name' => 'Alabaster Table',
	      'price' => 12.99,
	      'created' => '2019-01-04',
	      'sales_count' => 32,
	      'views_count' => 730,
	   ],
	   [
	      'id' => 2,
	      'name' => 'Zebra Table',
	      'price' => 44.49,
	      'created' => '2012-01-04',
	      'sales_count' => 301,
	      'views_count' => 3279,
	   ],
	    [
	      'id' => 3,
	      'name' => 'Coffee Table',
	      'price' => 10.00,
	      'created' => '2014-05-28',
	      'sales_count' => 1048,
	      'views_count' => 20123,
	   ]
	];

	$productPriceSorter = new ProductPriceSorter();
	$productSalesPerViewSorter = new ProductSalesPerViewSorter();

	$catalog = new Catalog($products);
	$productsSortedByPrice = $catalog->getProducts($productPriceSorter);
	$productsSortedBySalesPerView = $catalog->getProducts($productSalesPerViewSorter);