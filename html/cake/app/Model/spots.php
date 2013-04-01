App::uses('AppModel', 'Model');

class Spots extends AppModel {
	public $name;
	public $address;
	public $zip;
	public $phone;
	public $website;
	public $twitter;
	public $category;
	public $likes;
	public $multipleLocations;
}