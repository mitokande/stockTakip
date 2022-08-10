<?php
class Table{
    protected $userStockId;
    protected $userOrderId;

    public function __construct($userOrderId,$userStockId)
    {
        $this->userOrderId;
        $this->userStockId;
    }

    /**
     * @return mixed
     */
    public function getUserStockId()
    {
        return $this->userStockId;
    }

    /**
     * @param mixed $userStockId
     */
    public function setUserStockId($userStockId)
    {
        $this->userStockId = $userStockId;
    }

    /**
     * @return mixed
     */
    public function getUserOrderId()
    {
        return $this->userOrderId;
    }

    /**
     * @param mixed $userOrderId
     */
    public function setUserOrderId($userOrderId)
    {
        $this->userOrderId = $userOrderId;
    }
}