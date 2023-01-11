<?php
class Product
{
    protected $id;
    protected $title;
    protected $cost;

    public function __construct($id,$title,$cost){
        $this->id=$id;
        $this->title=$title;
        $this->cost=$cost;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function CostProduct()
    {
        echo $this->title." = ".$this->cost." руб.";
    }
}
class Phone extends Product{
    protected $ram;
    protected $memory;
    protected $color;
    protected $brand;
    protected $battery;

    public function __construct($id,$title,$cost,$ram,$memory,$color,$brand,$battery){
        $this->id=$id;
        $this->title=$title;
        $this->cost=$cost;
        $this->ram=$ram;
        $this->memory=$memory;
        $this->color=$color;
        $this->brand=$brand;
        $this->battery=$battery;
    }

    /**
     * @return mixed
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param mixed $ram
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * @param mixed $battery
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;
    }

    public function GetSettings()
    {
        echo $this->title.": Оперативаня память " .$this->ram."гб., Встроенная память ".$this->memory."гб., Цвет ".$this->color.", Бренд ".$this->brand.", Объём батареи ".$this->battery."mAh";
    }
}
$product=new Product("1","Iphone 7","40000");
$product->CostProduct();
$phone=new Phone("1","Xiaomi 11T","35999","8","256","серый","Xiaomi","5000" );
echo PHP_EOL;
$phone->CostProduct();
echo PHP_EOL;
$phone->GetSettings();
