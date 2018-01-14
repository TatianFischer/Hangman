<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 09/01/2018
 * Time: 13:59
 */

namespace AppBundle\Game;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameRunner
{
    /**
     * The Game context.
     *
     * @var GameContextInterface
     */
    private $context;

    /**
     * The list of words.
     *
     * @var WordListInterface
     */
    private $wordList;

    /**
     * GameRunner constructor.
     * @param GameContextInterface $context
     * @param WordListInterface $wordList
     */
    public function __construct(GameContextInterface $context, WordListInterface $wordList)
    {
        $this->context  = $context;
        $this->wordList = $wordList;
    }

    /**
    * Loads the current game or creates a new one.
    *
    * @param int $length The word length to guess
    *
    * @return Game
    */
    public function loadGame($length = 8)
    {
        if($game = $this->context->loadGame()){
            return $game;
        }

        if(!$this->wordList){
            throw new \RuntimeException('A WordListInterface instance must be set.');
        }

        $word = $this->wordList->getRandomWord($length);
        $game = $this->context->newGame($word);
        $this->context->save($game);

        return $game;
    }

    /**
     * @param $letter
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playLetter($letter)
    {
        if(!$game = $this->context->loadGame()){
            throw $this->createNotFoundException('No game context set.');
        }

        $game->tryLetter($letter);
        $this->context->save($game);

        return $game;
    }

    /**
     * @param $word
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playWord($word)
    {
        if(!$game = $this->context->loadGame()){
            throw $this->createNotFoundException('No game context set');
        }

        $game->tryWord($word);
        $this->context->save($game);

        return $game;
    }

    /**
     * @param \Closure|null $onStatusCallback
     * @return Game
     * @throws NotFoundHttpException
     */
    public function resetGame(\Closure $onStatusCallback = null)
    {
        if(!$game = $this->context->loadGame()){
            throw $this->createNotFoundException('No game context set.');
        }

        // Custom logic on failure or on success
        // thanks to an anonymous function
        if ($onStatusCallback) {
            call_user_func_array($onStatusCallback, [ $game ]);
        }

        $this->context->reset();

        return $game;
    }

    /**
     * @return Game
     * @throws NotFoundHttpException
     */
    public function resetGameOnSuccess()
    {
        $onWonGame = function (Game $game) {
            if (!$game->isOver()) {
                throw $this->createNotFoundException('Current game is not yet over.');
            }

            if (!$game->isWon()) {
                throw $this->createNotFoundException('Current game must be won.');
            }
        };

        return $this->resetGame($onWonGame);
    }

    /**
     * @return Game
     * @throws NotFoundHttpException
     */
    public function resetGameOnFailure()
    {
        $onLostGame = function (Game $game) {
            if (!$game->isOver()) {
                throw $this->createNotFoundException('Current game is not yet over.');
            }

            if (!$game->isHanged()) {
                throw $this->createNotFoundException('Current game must be lost.');
            }
        };

        return $this->resetGame($onLostGame);
    }

    private function createNotFoundException($message)
    {
        return new NotFoundHttpException($message);
    }
}