<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 14/01/2018
 * Time: 18:46
 */

namespace AppBundle\Game;

use AppBundle\Game\Loader\LoaderInterface;

interface DictionaryLoaderInterface
{
    /**
     * Registers a new dictionary loader.
     *
     * @param string          $type   The loader type (ie: xml, csv, txt...)
     * @param LoaderInterface $loader The loader instance
     */
    public function addLoader($type, LoaderInterface $loader);

    /**
     * Loads a list of dictionaries.
     *
     * @param array $dictionaries An array of dictionaries files paths
     */
    public function loadDictionaries(array $dictionaries);
}