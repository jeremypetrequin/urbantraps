<?php

class maths {
    /**
     * Returns a random Number between the specified values.
     * 
     * @param min The lowest value
     * @param max The highest value
     * /!\ attention à la limite int : $min et $max ne doivent avoir que 2 chiffres maxi avant la virgule
     */
    public function randomNumber($min, $max) {
            $random = 0;
            $floatFactor = 10000000;
            $max = $max* $floatFactor;
            $min = $min* $floatFactor;

            $random = rand($min, $max);
            $random = $random/$floatFactor;

            return($random);
    }
}

?>
