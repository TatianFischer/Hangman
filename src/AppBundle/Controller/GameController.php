<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tatiana
 * Date: 08/01/2018
 * Time: 16:57
 */

namespace AppBundle\Controller;

use AppBundle\Model\HangmanGame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package AppBundle\Controller
 * @Route("/game")
 */
class GameController extends Controller
{
    private $model;

    public function __construct(HangmanGame $model)
    {
        $this->model = $model;
    }

    /**
     * @Route("/show")
     */
    public function showAction(Request $request)
    {
        $letters = $this->model->getLetters();

        return $this->render('game/show.html.twig', ['letters' => $letters]);
    }

    /**
     * @Route("/reset")
     */
    public function resetAction(Request $request)
    {
        $model = $this->get(HangmanGame::class);
        $model->resetLetters();

        return $this->redirectToRoute('app_game_show');
    }

    /**
     * @Route("/play-the-{letter}-letter", requirements={"letter"="[a-z]"})
     */
    public function playletterAction(Request $request)
    {
        $model = $this->get(HangmanGame::class);
        $model->addSingleLetter($request->attributes->get('letter'));

        return $this->redirectToRoute('app_game_show');
    }

    /**
     * @Route("/play-a-word", methods="POST", condition="request.request.get('word') matches '/^[a-z]+$/'")
     */
    public function playwordAction(Request $request)
    {
        $model = $this->get(HangmanGame::class);
        $model->addLettersFromWord($request->request->get('word'));

        return $this->redirectToRoute('app_game_show');
    }
}