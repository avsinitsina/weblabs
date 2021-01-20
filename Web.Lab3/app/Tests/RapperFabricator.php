<?php
use App\Models\RapperModel;
use CodeIgniter\Test\Fabricator;
//$fabricator = new Fabricator(RapperModel::class);
class RapperFabricator extends App\Models\RapperModel
{
    public function fake(Generator &$faker)
    {
        return [
            'name'  => Faker\Provider\en_US\Person::firstName()." ".Faker\Provider\en_US\Person::lastName(),
            'label'  => Faker\Provider\en_US\Company::company()." ".Faker\Provider\en_US\Company::companySuffix(),
            'genre' => Faker\Provider\Base::randomElement(array ('freestyle', 'hardcore', 'nerdcore', 'gangsta')),
            'cool_moves_count' => Faker\Provider\Base::randomDigit(),
            'swearing_frequency' => Faker\Provider\Base::randomFloat(2,0,1),
            'dead_baddy'  => Faker\Provider\Base::randomElement(array (0,1)),
            'from' => Faker\Provider\DateTime::date('Y-m-d', $max = 'now'),
            'country' => Faker\Provider\en_US\Address::country()
        ];
    }
}