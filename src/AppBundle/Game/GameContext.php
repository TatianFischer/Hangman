<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 14/01/2018
 * Time: 18:15
 */

namespace AppBundle\Game;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameContext implements GameContextInterface
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Resets the current game context
     *
     * @return void
     */
    public function reset()
    {
        $this->session->set('hangman', array());
    }

    /**
     * Creates a new Game instance.
     *
     * @param string $word The word to be guessed
     * @return Game
     */
    public function newGame($word)
    {
        return new Game($word);
    }

    /**
     * Loads an existing game.
     *
     * @return Game
     */
    public function loadGame()
    {
        $data = $this->session->get('hangman');

        if(!$data){
            return false;
        }

        return new Game(
            $data['word'],
            $data['attempts'],
            $data['tried_letters'],
            $data['found_letters']
        );
    }

    /**
     * Saves the provided game.
     *
     * @param Game $game The game to save
     * @return void
     */
    public function save(Game $game)
    {
        $this->session->set('hangman', $game->getContext());
    }
}