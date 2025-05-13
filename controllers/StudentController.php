<?php

namespace Controllers;

use Responses\Response;
use Requests\RequestInterface;
use Models\DataRepositoryInterface;

class StudentController extends ApiController
{
    public function __construct(DataRepositoryInterface $studentRepository, RequestInterface $request)
    {
        parent::__construct($studentRepository, $request);
    }

    public function getAll(): Response
    {
        $students = $this->repository->getAll();
        return new Response(200, json_encode($students));
    }

    public function getById($id): Response
    {
        $student = $this->repository->getById($id);
        if (empty($student)) {
            return new Response(404, json_encode(['error' => 'Student not found']));
        }
        return new Response(200, json_encode($student));
    }

    public function create(): Response
    {
        $data = $this->request->getBody();
        $this->repository->create($data);
        return new Response(201, json_encode(['message' => 'Student created']));
    }

    public function update($id): Response
    {
        $data = $this->request->getBody();
        $this->repository->update($id, $data);
        return new Response(200, json_encode(['message' => 'Student updated']));
    }

    public function delete($id): Response
    {
        $this->repository->delete($id);
        return new Response(204, '');
    }
}
