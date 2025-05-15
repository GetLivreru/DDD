<?php

class ProductImportUseCase
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(array $productsData)
    {
        foreach ($productsData as $data) {
            $dto = new ProductDTO($data['id'] ?? null, $data['name'], $data['code']);
            $this->service->createOrUpdate($dto);
        }
    }
} 