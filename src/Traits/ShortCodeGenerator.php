<?php

namespace Lokalkoder\Support\Traits;

trait ShortCodeGenerator
{
    /**
     * Guest which to use either code supply or shortcode generated.
     *
     * @param string $description
     * @param string|null $code
     * @return string
     */
    public function decideReferenceCode(string $description, ?string $code):string
    {
        $ref = $this->generateShortCode($description);

        if ($code === null) {
            return $ref;
        }

        $originalCode = $this->cleanString($code);

        return (strlen($originalCode) < 5 && !empty($originalCode)) ? $originalCode : $ref;
    }

    /**
     * Generate shortcode for reference.
     * @param string $desc
     * @param int $maxChar
     * @return string
     */
    public function generateShortCode(string $desc, int $maxChar = 5): string
    {
        $string = $this->cleanString($desc);

        $array = str_split($string);

        $max = count($array);

        if ($max > $maxChar) {
            $med = floor($max/2);

            $mid = floor($med/2);

            $code = trim(strtoupper($array[0].$array[$mid].$array[$med].$array[$med+$mid].$array[$max-1]));
        } else {
            $code = trim(strtoupper($string));
        }

        return $code;
    }

    /**
     * Clean the string to only consider letter.
     *
     * @param string $string
     * @return string
     */
    protected function cleanString(string $string): string
    {
        return strtoupper(preg_replace("/[^A-Za-z]/", '', $string));
    }
}
