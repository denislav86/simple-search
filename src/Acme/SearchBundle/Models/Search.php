<?php

namespace Acme\SearchBundle\Models;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class Search
{

    public function searchText($searchString, $targetLocation = '' , $shortOutput = false)
    {

        if ($targetLocation && is_dir($targetLocation)) {

            $directory = realpath($targetLocation);

        } else {

            $directory = getcwd();

        }

        $directory = new RecursiveDirectoryIterator($directory);

        $iterator = new RecursiveIteratorIterator($directory);

        //get all files with .txt extension
        $files = new RegexIterator($iterator, '/^.+\.txt$/i', RecursiveRegexIterator::GET_MATCH);

        ob_start();

        foreach($files as $name => $object){


            if (!is_readable($name) || !is_executable($name)) {
                continue;
            }

            exec('grep '. escapeshellarg($searchString)  .' '. escapeshellarg($name) . ' -n', $results);


            if (!empty($results)) {

                foreach ($results as $result) {

                    $matches = explode(':',$result);

                    if ($shortOutput) {

                        echo "File => " . $name . "\n";

                    } else {

                        echo "------\n";
                        echo "Searched for - \"" . $searchString . "\"\n";
                        echo "File => " . $name . "\n";
                        echo "Number of matches: " . count($results) . "\n";
                        echo "Line " . $matches[0] . " - " . $matches[1] . "\n";

                    }


                }

            }
        }


        $output = ob_get_clean();

        if (empty($output)) {

            $output = 'There are no results - this search omits files and folders if they do not have the required permissions';

        }

        return $output;

    }

}