<?php
Yii::import('application.extensions.Curl.Curl');

class Bitcoin extends CPayment
{
    const CONFIRMATION_AMOUNT = 6;
    protected $_dbTables = array('payment' => 'bitcoin_payment', 'address' => 'bitcoin_address');
    protected $_action_url = 'https://api.blockchain.info/v2/receive?xpub=%s&callback=$s&key=%s';
    protected $_exchangeURL = 'https://blockchain.info/ticker';
    protected $_currency = 'BTC';
    protected $_symbol = '฿';    

    public function init()
    {
        $this->_action_url = '';
            
        //$this->_params['clientId'],
        //$this->_params['clientSecret']
        //test
    }
    
    public function addLog($string)
    {
        $fh = fopen($this->_logFileName, 'a+');
        fwrite($fh, date('d-m-Y H:i') . ' : ' . $string . "\n");
        fclose($fh);
    }
    
    protected function confirm($params)
    {
        $user_id = Yii::app()->user->profile->id;
        $payments = $this->getPayments($user_id);
        $cart_info = Cart::getByUser($user_id);
        $to_pay = $this->exchange($cart_info['total']);

        $this->addLog('Transaction confirmation start User: '.$user_id.' (' . $to_pay . "<=" .$payments['total_not_used'] .')');

        $r = $to_pay <= $payments['total_not_used'] ? 1 : 0;
        //mark payments used
        if ($r) {
            $address = $this->getAddress($user_id);
            Yii::app()->db->createCommand('UPDATE '.$this->_dbTables['payment'].' SET used=1 WHERE `address`="'.$address.'"')
                      ->execute();

            $this->addLog('Confirmed User: '.$user_id.' ('.$address.')');
        } else {
            $this->addLog('Transaction fail');
        }

        return $r;
    }
    
    /**
     * Exchange money
     * @param float $summ
     * @return float
     */
    public function exchange($summ)
    {
        return round($summ/$this->_exchangeRate, 3);
    }
    
    public function exitByError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
        Yii::app()->end();
    }
    
    
    /**
     * Get address for user
     * @param integer $user_id User ID
     * @return string Address
     */
    public function getAddress($user_id)
    {
        $address = Yii::app()->db->createCommand()
                             ->select('address')
                             ->from($this->_dbTables['address'])
                             ->where('user_id=:user_id', array(':user_id' => $user_id))
                             ->queryScalar();
        if (empty($address)) {
            $address = $this->generateAddressFor($user_id);
        }
        return $address;
    }
    
    /**
     * Generate address for user
     * @param integer $user_id
     * @return string Address
     */
    public function generateAddressFor($user_id)
    {
        $address = 'a'.time();
        Yii::app()->db->createCommand()
                      ->insert($this->_dbTables['address'], array('address'=>$address, 'user_id'=>$user_id));
        return $address;
    }
    
    /**
     * Get payments
     * @param integer $user_id User ID
     * @return array 
     */
    public function getPayments($user_id)
    {
        $address = $this->getAddress($user_id);
        $info = Yii::app()->db->createCommand('SELECT (SELECT FORMAT(SUM(total), 5) FROM '.$this->_dbTables['payment'].' WHERE address="'.$address.'") total,
                                       (SELECT FORMAT(SUM(total), 5) FROM '.$this->_dbTables['payment'].' WHERE address="'.$address.'" AND used = 0 AND confirmation_amount >= ' . self::CONFIRMATION_AMOUNT . ') total_not_used')
                              ->queryRow(true);
        
        $info['payments'] = Yii::app()->db->createCommand()
                ->select('*')
                ->from($this->_dbTables['payment'])
                ->where('address=:address', array(':address'=>$address))
                ->queryAll(true);
        
        return $info;
    }

    public function includeHTML($data = array())
    {
        $path = Yii::getPathOfAlias('application.extensions.Bitcoin.views.modal');
        include_once($path .'.php');
    }
    
    /**
     * Define exchange rate
     * @return mixed
     */
    protected function _defineRate()
    {
        $curl = new Curl();

        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $rates = json_decode($curl->setOption(CURLOPT_SSL_VERIFYPEER, false)
             ->setOption(CURLOPT_USERAGENT, $agent)
             ->get($this->_exchangeURL), 1);

        return $rates["USD"]['last'];
    }    
 
}