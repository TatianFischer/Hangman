<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 14/01/2018
 * Time: 18:43
 */

namespace AppBundle\Game;


interface WordListInterface
{
    /**
     * Returns a random word of a given length from the list.
     *
     * @param  integer $length The word length
     * @return string
     */
    public function getRandomWord($length);

    /**
     * Adds a new word to the list.
     *
     * @param  string $word The word to add to the list
     * @return void
     */
    public function addWord($word);
}