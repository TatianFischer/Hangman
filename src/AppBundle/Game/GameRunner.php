<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 13:59
 */

namespace AppBundle\Game;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HangmanGame
{
    private $session;
    private $idx;
    const DEFAULT_SESS_IDX = 'letters';

    public function __construct(SessionInterface $session, $sess_idx = self::DEFAULT_SESS_IDX)
    {
        $this->session = $session;
        $this->idx  = $sess_idx;
    }

    public function getLetters() : array
    {
        $letters = $this->session->get('letters', []);

        return $letters;
    }

    public function addSingleLetter(string $l)
    {
        $letters = $this->read();
        $letters[] = $l;
        $this->write($letters);
    }

    public function addLettersFromWord(string $word)
    {
        $letters = $this->read();
        $letters = array_merge($letters, str_split($word));
        $this->write($letters);
    }

    public function resetLetters() : void
    {
        $this->write([]);
    }

    private function read()
    {
        return $this->session->get($this->idx, []);
    }

    private function write(array $letters) : void
    {
        $this->session->set($this->idx, $letters);
    }
}