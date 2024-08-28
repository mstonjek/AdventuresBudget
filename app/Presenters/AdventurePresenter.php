<?php

namespace App\Presenters;

use App\Forms\AdventureExcelFormFactory;
use App\Forms\AdventureFormFactory;
use App\Model\Entity\Adventure;
use Nette\Application\UI\Presenter;
use App\Repository\AdventureRepository;
use Nette\Forms\Form;

class AdventurePresenter extends Presenter
{
    private array $adventures = [];
    private Adventure $adventure;

    public function __construct(
        private readonly AdventureRepository $adventureRepository,
        private readonly AdventureFormFactory $adventureFormFactory,
        private readonly AdventureExcelFormFactory $adventureExcelFormFactory,
    ){
    }

    public function actionEdit(string $adventureId)
    {
        $adventure = $this->adventureRepository->find($adventureId);
        if (!$adventure instanceof Adventure) {
            $this->flashMessage('Tato akce neexistuje!', 'alert-danger');
            $this->redirect('Dashboard:default');
        }
        $this->adventure = $adventure;
        $this->template->adventure = $this->adventure;

    }

    public function renderDefault()
    {
       $this->adventures = $this->adventureRepository->getAll();
       $this->template->adventures = $this->adventures;


    }

    protected function createComponentAdventureAddForm(): Form
    {
        return $this->adventureFormFactory->create(
            function ($adventure): void {
                $this->flashMessage('Akce byla úspěšně vytvořena', 'alert-success');
                $this->redirect('Dashboard:default');
            }
        );
    }

    protected function createComponentAdventureEditForm(): Form
    {
        return $this->adventureFormFactory->create(
            function ($adventure): void {
                $this->flashMessage("Akce byla úspěšně vytvořena", 'alert-success');
                $this->redirect('Dashboard:default');
            }, $this->adventure
        );
    }

    protected function createComponentAdventureExcelForm(): Form
    {
        return $this->adventureExcelFormFactory->create(
            function ($adventure): void {
                $this->flashMessage("Akce byla úspěšně vytvořena", 'alert-success');
                $this->redirect('Dashboard:default');
            }
        );
    }


}