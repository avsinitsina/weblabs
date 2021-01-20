<?php

namespace Database\Factories;

use App\Models\Rapper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RapperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rapper::class;
    protected $generationPath = "data.json";
    protected $generationData;

    public function __construct()
    {
        parent::__construct();
        $this->generationData = json_decode(Storage::get($this->generationPath), $assoc = true);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $deads = ['Not killed in a fight', 'Killed in a fight'];
        $names = $this->generationData['names'];
        $lastNames = $this->generationData['lastNames'];
        $labelNouns = $this->generationData['labelNouns'];
        $labelAdjectives = $this->generationData['labelAdjectives'];
        $genres = $this->generationData['genres'];
        $countries = $this->generationData['countries'];

        $nameIndex = array_rand($names);
        $name = $names[$nameIndex];

        $lastNameIndex = array_rand($lastNames);
        $lastName = $lastNames[$lastNameIndex];

        $labelNounIndex = array_rand($labelNouns);
        $labelNoun = $labelNouns[$labelNounIndex];

        $labelAdjIndex = array_rand($labelAdjectives);
        $labelAdjective = $labelAdjectives[$labelAdjIndex];

        $genreIndex = array_rand($genres);
        $genre = $genres[$genreIndex];

        $countryIndex = array_rand($countries);
        $country = $countries[$countryIndex];

        $swearingFreq = mt_rand() / mt_getrandmax();
        $coolMovesCount = rand(0, 10);
        $deadBaddy = array_rand($deads);

        $date = new \DateTime('1 January 2000');
        $dayShift = rand(-2000, 2000);
        $date->modify("+$dayShift days");
        $from = $date->format('Y-m-d');

        return [
            'name' => $name . " " . $lastName,
            'from' => $from,
            'cool_moves_count' => $coolMovesCount,
            'swearing_frequency' => $swearingFreq,
            'dead_baddy' => $deads[$deadBaddy],
            'country' => $country,
            'label' => $labelAdjective . " " . $labelNoun,
            'genre' => $genre
        ];
    }
}
