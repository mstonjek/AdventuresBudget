<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use App\Repository\AdventureRepository;

class AdventurePresenter extends Presenter
{
    private $adventures = [];
    public function __construct(
        private readonly AdventureRepository $adventureRepository,
    )
    {

    }

    public function renderDefault()
    {
       $this->adventures = $this->adventureRepository->getAll();
       $this->template->adventures = $this->adventures;


    }



}