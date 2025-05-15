<?php

namespace Controllers;

use Models\StudentRepository;
use Controllers\ViewController;

class StudentViewController {
    private $repository;
    private $view;

    public function __construct(StudentRepository $repository, ViewController $view) {
        $this->repository = $repository;
        $this->view = $view;
    }

    public function index($page = 1) {
        $perPage = 5;
        $all = $this->repository->getAll();
        $total = count($all);
        $totalPages = ceil($total / $perPage);
        $students = array_slice($all, ($page - 1) * $perPage, $perPage);
      $this->view->studentsIndex($students, $page, $totalPages, $perPage, $total);
    }

    public function create() {
        $this->view->studentsCreate();
    }

    public function store()
    {
        $data = $_POST;
        $this->repository->create($data);
        header('Location: /students');
        exit;
    }


    public function show($id) {
        $student = $this->repository->getById($id);
        $this->view->studentsShow($student);
    }

    public function edit($id) {
        $student = $this->repository->getById($id);
        $this->view->studentsEdit($student);
    }

    public function update($id)
    {
        // $_POST contains ['username' => '...']
        $this->repository->update($id, $_POST);
        header('Location: /students');
        exit;
    }


    public function delete($id) {
        $this->repository->delete($id);
        header('Location: /students');
        exit;
    }



}
