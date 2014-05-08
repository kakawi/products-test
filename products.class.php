<?php
if (isset($_GET['sum'])) {
$sum = $_GET['sum'];
$products = new Products('data.xml');

$products->setSum($sum);
$products->findGoods();
echo $products->getResult();
}

class Products
{
    private $data;
    private $xmlObject;
    private $sum;
    private $result;

    /**
     * Загружает файл и вызывает функцию которая парсит данные
     * @param $file
     */
    function __construct($file)
    {
        $xmlData = simplexml_load_file($file);
        $this->xmlObject = $xmlData->children();
        $this->parseProducts();
    }

    /**
     * Функция, которая парсит и сортирует данные по цене
     */
    private function parseProducts()
    {
        $i = 0;
        foreach ($this->xmlObject as $row) {
            $price[]  = (int)$row->price;
            $data[$i]['price'] = (int)$row->price;
            $data[$i]['description'] = $row->description;
            $data[$i]['title'] = $row->title;
            $i++;
        }

        array_multisort($price, SORT_ASC, $data);
        $this->data = $data;
    }

    /**
     * Устанавливает значение суммы, которую ввел пользователь
     * @param $sum
     * @return bool
     */
    public function setSum($sum)
    {
        if ((int)$sum) {
            $this->sum = (int)$sum;
        } else {
            $this->setMessage('Введите число', true);
            return false;
        }
    }

    /**
     * Находит все товары, которые могут подойти пользователю
     */
    public function findGoods()
    {
        $j = count($this->data) - 1;

        if ($j <= 1) {
            $this->setMessage('Введите больше товаров', true);
        }

        foreach ($this->data as $i => $row) {
            if ($i >= $j) break;
            $minPrice = $row['price'];

            do {
                $maxPrice = $this->data[$j]['price'];
                if ($minPrice + $maxPrice > $this->sum) {
                    $j--;
                } elseif ($minPrice + $maxPrice == $this->sum) {
                    $this->result[] = $row['title'] . ' && ' . $this->data[$j]['title'];
                    break;
                } else{
                    $this->setMessage('Слишком большое число');
                    break 2;
                }

            } while ($j > $i);
        }

        if (!$this->result) {
            $this->setMessage('Не удалось подобрать товар(слишком маленькое)');
        }
    }

    /**
     * Возвращает результат в json
     * @return string
     */
    public function getResult()
    {
        return json_encode($this->result);
    }

    /**
     * Устанавливает сообщение в качестве ответа
     * @param $msg
     */
    private function setMessage($msg)
    {
        $this->result[] = $msg;
    }
}