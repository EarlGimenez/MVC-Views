<?php

namespace Controllers;
use \Firebase\JWT\JWT;
use Responses\Response;
use Requests\RequestInterface;
use Models\DataRepositoryInterface;


abstract class ApiController {
    protected $repository;
    protected $request;

    public function __construct(DataRepositoryInterface $repository, RequestInterface $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    abstract public function getAll(): Response;
    abstract public function getById($id): Response;
    abstract public function create(): Response;
    abstract public function update($id): Response;
    abstract public function delete($id): Response;
}
