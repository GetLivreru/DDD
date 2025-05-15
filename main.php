<?php

require_once 'Product.php';
require_once 'ProductDTO.php';
require_once 'ProductRepository.php';
require_once 'ProductService.php';
require_once 'ProductImportUseCase.php';

$url = "https://www.mechta.kz/api/v2/filter/catalog?properties&section=smartfony";
$json = file_get_contents($url);

if ($json === false) {
    die("Не удалось получить данные");
}

$data = json_decode($json, true);

if ($data === null) {
    die("Ошибка декодирования JSON");
}

$productsData = [];
foreach ($data['data']['properties'] as $property) {
    if ($property['property_name'] === 'Модель') {
        foreach ($property['items'] as $item) {
            $productsData[] = [
                'name' => $item['value'],
                'code' => $item['code'],
                // can we add another table like size,desc, etc/.
            ];
        }
    }
}

$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=parsing', 'postgres', '12345678');
$repository = new ProductRepository($pdo);
$service = new ProductService($repository);
$useCase = new ProductImportUseCase($service);


$useCase->execute($productsData);

echo "Импорт завершён!\n";