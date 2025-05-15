<?php

class ProductService
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOrUpdate(ProductDTO $dto): Product
    {
        $product = $this->repository->findByCode($dto->code);
        if ($product) {
            $product->name = $dto->name;
        } else {
            $product = new Product(null, $dto->name, $dto->code);
        }
        return $this->repository->save($product);
    }
} 