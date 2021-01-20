<?php namespace App\Database\Seeds;
use App\Models\RapperModel;
use CodeIgniter\Test\Fabricator;
use Faker\Factory;
use DateTime;
/**
 * Class StudentsSeeder
 * @package App\Database\Seeds
 */
class RappersSeeder extends \CodeIgniter\Database\Seeder
{
//    private static $names = ["Lil", "Little", "Big", "Small", "Skinny", "Fat", "Sick", "Psycho", "Slick", "Don", 'A$AP', "French", "Dutch",
//        "Young", "Old", "Fresh", "Dead", "Dee", "Dr.", "Nasty", "Jay", "Keith", "Kid", "Kool", "Mac", "Mr.", "Ol'", "Prince", "Ray", "Rico",
//        "Rob", "Yung", "Willie"];
//    private static $lastNames = ["MC", "Junior", "C" ,"Z", "J", "E", "X", "T", "O", "L", "D", "Montana", "Dog", "Arizona", "East", "West". "North", "South", "Peep",
//        "Thug", "Baby", "Ferg", "Rocky", "Pump", "Xan", "Frog", "Tape", "Son", "Bastard", "Kim", "Mob", "Nast", "Boy"];
//    private static $labelNouns = ["Records", "Music", "Company" ,"Creation", "Entertainment", "Media", "Family", "Nation"];
//    private static $labelAdjectives = ["Epic", "Black", "New" ,"Universal", "Creative", "Big"];
//    private static $genres = ["freestyle", "gangsta", "hardcore" ,"nerdcore"];
//    private static $countries = ["USA", "UK", "Japan", "South Korea", "Canada", "Australia"];

    /**
     *
     */
    public function run()
    {
        //создать модель и оьратиться к её методу генерат
//        $nameIndex = array_rand(self::$names);
//        $name = self::$names[$nameIndex];
//
//        $lastNameIndex = array_rand(self::$lastNames);
//        $lastName = self::$lastNames[$lastNameIndex];
//
//        $labelNounIndex = array_rand(self::$labelNouns);
//        $labelNoun = self::$labelNouns[$labelNounIndex];
//
//        $labelAdjIndex = array_rand(self::$labelAdjectives);
//        $labelAdjective = self::$labelAdjectives[$labelAdjIndex];
//
//        $genreIndex = array_rand(self::$genres);
//        $genre = self::$genres[$genreIndex];
//
//        $countryIndex = array_rand(self::$countries);
//        $country = self::$countries[$countryIndex];
//
//        $swearingFreq = mt_rand() / mt_getrandmax();
//        $coolMovesCount = rand(0,10);
//        $deadBaddy = rand(0,1);
//
//        $date = new DateTime('1 January 2000');
//        $dayShift = rand(-150,500);
//        $date->modify("+$dayShift days");
//        $from= $date->format('Y-m-d');
//
//
//        $data = [
//            'name' => $name." ".$lastName,
//            'from'    => $from,
//            'cool_moves_count' => $coolMovesCount,
//            'swearing_frequency' => $swearingFreq,
//            'dead_baddy' => $deadBaddy,
//            'country' => $country,
//            'label' => $labelAdjective." ".$labelNoun,
//            'genre' => $genre
//        ];
        $faker = Factory::create();

//        $fabricator = new Fabricator(RapperModel::class, $formatters);
        for ($i = 1; $i <= 100000; $i++)
        {
            $data = [
                'name'  => $faker->name,
                'label'  => $faker->company,
                'genre' => $faker->randomElement(array ('freestyle', 'hardcore', 'nerdcore', 'gangsta')),
                'cool_moves_count' => $faker->randomDigit,
                'swearing_frequency' => $faker->randomFloat(2,0,1),
                'dead_baddy'  => $faker->randomElement(array (0,1)),
                'from' => $faker->date('Y-m-d', $max = 'now'),
                'country' => $faker->country,
            ];
            $this->db->table('db_rappers')->insert($data);
        }
    }
}
