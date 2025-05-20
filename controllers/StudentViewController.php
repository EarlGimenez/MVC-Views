<?php

namespace Controllers;

use Exception;
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
        $columns = $this->repository->getColumns();
        $students = $this->repository->getAll();
        $this->view->studentsCreate($columns, $students);
        unset($_SESSION['message'], $_SESSION['message_type']);
    }

    public function store() {
        if ($_POST === null) {
            $_SESSION['message'] = 'No data received.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students/create');
            exit();
        }

        $data = $_POST;
        $columns = $this->repository->getColumns();
        $missing = [];
        foreach ($columns as $col) {
            if (!isset($data[$col]) || trim($data[$col]) === '') {
                $missing[] = ucfirst($col);
            }
        }
        if (!empty($missing)) {
            $_SESSION['message'] = 'Missing required fields: ' . implode(', ', $missing);
            $_SESSION['message_type'] = 'error';
            header('Location: /students/create');
            exit();
        }

        $newId = $data['id'] ?? null;
        if ($newId === null || !is_numeric($newId)) {
            $_SESSION['message'] = 'Student ID is required and must be a number.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students/create');
            exit();
        }

        if ($this->repository->getById($newId)) {
            $_SESSION['message'] = 'Student with ID ' . $newId . ' already exists.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students/create');
            exit();
        }

        try {
            $this->repository->create($data);
            $_SESSION['message'] = 'Student created successfully.';
            $_SESSION['message_type'] = 'success';
            header('Location: /students');
            exit();
        } catch (Exception $e) {
            $_SESSION['message'] = 'Failed to create student: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
            header('Location: /students/create');
            exit();
        }
    }
    
    public function show($id) {
        $student = $this->repository->getById($id);
        $this->view->studentsShow($student);
    }

    public function edit($id) {
        $student = $this->repository->getById($id);
        $this->view->studentsEdit($student);
    }


    public function update($id) {
        $data = $_POST;

        if ($data === null) {
            $_SESSION['message'] = 'No data received.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students/' . $id . '/edit');
            exit();
        }

        $newId = $data['id'] ?? null;

        if ($newId !== null && $newId !== $id && $this->repository->getById($newId)) {
            $_SESSION['message'] = 'Student with ID ' . $newId . ' already exists.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students/' . $id . '/edit');
            exit();
        }

        $student = $this->repository->getById($id);
        if (!$student) {
            $_SESSION['message'] = 'Error: Student not found.';
            $_SESSION['message_type'] = 'error';
            header('Location: /students');
            exit();
        }

        try {
            $this->repository->update($id, $data);
            $_SESSION['message'] = 'Student updated successfully.';
            $_SESSION['message_type'] = 'success';
            $redirectId = $newId !== null && $newId !== $id ? $newId : $id;
            header('Location: /students/' . $redirectId);
            exit();
        } catch (\Exception $e) {
            $_SESSION['message'] = 'Error updating student: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
            header('Location: /students/' . $id . '/edit');
            exit();
        }
    }

    public function delete($id) {
        try {
            $this->repository->delete($id);
            $_SESSION['message'] = 'Student deleted successfully.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Failed to delete student: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }

        header('Location: /students');
        exit;
    }

}
