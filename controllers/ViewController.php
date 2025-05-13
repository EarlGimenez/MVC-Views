<?php

namespace Controllers;

class ViewController {
    private $request;
    public function homepage() {
        include __DIR__ . "/../views/homepage.php";
        exit;
    }
    public function services() {
        include __DIR__ . "/../views/services.php";      
        exit;
    }
    public function about() {
        include __DIR__ . "/../views/about-us.php";
        exit;
    }
    public function error() {
        include __DIR__ . "/../views/error.php";
        exit;
    }
    public function dashboard() {
        include __DIR__ . "/../views/dashboard.php";
        exit;
    }
    public function studentsIndex($students, $page, $totalPages, $perPage, $total) {
        include __DIR__ . '/../views/students/index.php';
        exit;
    }

    public function studentsCreate() {
        include __DIR__ . '/../views/students/create.php';
        exit;
    }

    public function studentsShow($student) {
        include __DIR__ . '/../views/students/show.php';
        exit;
    }

    public function studentsEdit($student) {
        include __DIR__ . '/../views/students/edit.php';
        exit;
    }

    function redirect(string $path) {
        header("Location: $path");
        exit;
    }
    
}