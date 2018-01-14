<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 08/01/2018
 * Time: 16:57
 */

namespace AppBundle\Controller;

use AppBundle\Game\GameRunner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package AppBundle\Controller
 * @Route("/game")
 */
class GameController extends Controller
{
    private $game;

    /**
     * GameController constructor.
     * @param GameRunner $game
     */
    public function __construct(GameRunner $game)
    {
        $this->game = $game;
    }

    /**
     * This action displays the main board to play the game.
     *
     * @Route("/show")
     * @Method("GET")
     */
    public function showAction()
    {
        $game = $this->game->loadGame();

        return $this->render('game/show.html.twig', ['game' => $game]);
    }

    /**
     * This action displays the congratulations page
     *
     * @Route("/win")
     * @Method("GET")
     */
    public function winAction()
    {
        try{
            $game = $this->game->resetGameOnSuccess();
        }catch (\Exception $e){
            return $this->redirectToRoute('app_game_show');
        }

        return $this->render('game/win.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/fail")
     * @Method("GET")
     */
    public function failAction()
    {
        try{
            $game = $this->game->resetGameOnFailure();
        }catch (\Exception $e){
            return $this->redirectToRoute('app_game_show');
        }

        return $this->render('game/fail.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->game->resetGame();

        return $this->redirectToRoute('app_game_show');
    }

    /**
     * This action tries one single letter at a time.
     *
     * @Route("/play/{letter}", name="app_game_play_letter", requirements={"letter"="[a-z]"})
     * @Method("GET")
     *
     * @var $letter
     * @return RedirectResponse
     */
    public function playLetterAction($letter)
    {
        $game = $this->game->playLetter($letter);

        if(!$game->isOver()){
            return $this->redirectToRoute("app_game_show");
        }

        return $this->redirectToRoute($game->isWon() ? 'app_game_win' : 'app_game_fail');
    }

    /**
     * This action tries one single word at a time.
     *
     * @Route(
     *   path="/play",
     *   name="app_game_play_word",
     *   condition="request.request.get('word') matches '/^[a-z]+$/i'"
     * )
     * @Method("POST")
     * @param Request $request
     * @return RedirectResponse
     */
    public function playWorkAction(Request $request)
    {
        $game = $this->game->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'app_game_win' : 'app_game_fail');
    }
}