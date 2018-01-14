<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 14/01/2018
 * Time: 18:44
 */

namespace AppBundle\Game;


use AppBundle\Game\Loader\LoaderInterface;

class WordList implements WordListInterface, DictionaryLoaderInterface
{
    private $words;
    private $loaders;

    public function __construct()
    {
        $this->words    = array();
        $this->loaders  = array();
    }

    /**
     * Returns a random word of a given length from the list.
     *
     * @param  integer $length The word length
     * @return string
     */
    public function getRandomWord($length)
    {
        if(!isset($this->words[$length])){
            throw new \InvalidArgumentException(sprintf('There is no word of length %u.', $length));
        }

        $key = array_rand($this->words[$length]);

        return $this->words[$length][$key];
    }

    /**
     * Adds a new word to the list.
     *
     * @param  string $word The word to add to the list
     * @return void
     */
    public function addWord($word)
    {
        $length = strlen($word);

        if(!isset($this->words[$length])){
            $this->words[$length] = array();
        }

        if(!in_array($word, $this->words[$length])){
            $this->words[$length][] = $word;
        }
    }

    /**
     * Registers a new dictionary loader.
     *
     * @param string $type The loader type (ie: xml, csv, txt...)
     * @param LoaderInterface $loader The loader instance
     */
    public function addLoader($type, LoaderInterface $loader)
    {
        $this->loaders[strtolower($type)] = $loader;
    }

    private function findLoader($type)
    {
        $type = strtolower($type);

        if(!isset($this->loaders[$type])){
            throw new \RuntimeException(printf('There is no loader able to load a %s dictionary.', $type));
        }
    }

    /**
     * Loads a list of dictionaries.
     *
     * @param array $dictionaries An array of dictionaries files paths
     */
    public function loadDictionaries(array $dictionaries)
    {
        foreach ($dictionaries as $dictionary){
            $this->loadDictionary($dictionary);
        }
    }

    public function loadDictionary($path){
        $loader = $this->findLoader(pathinfo($path, PATHINFO_EXTENSION));

        $words = $loader->load($path);
        foreach ($words as $word){
            $this->addWord($word);
        }
    }
}