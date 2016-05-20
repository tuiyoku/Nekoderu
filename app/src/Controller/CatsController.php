<?php

namespace App\Controller;

class CatsController extends AppController
{
    public function index()
    {
        $this->Crud->on('beforePaginate', function($e) {
            $e->subject->query = $this->Cats->find(
                'search',
                $this->Cats->filterParams($this->request->query)
            );
        });
        return $this->Crud->execute();
    }
}