<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $time
 * @property string $status
 * @property string $user_id
 * @property string $time_interval
 * @property double $total
 * @property string $payment_method
 * @property string $payment_status
 * @property int $transaction_id
 * @property int $notif_frequency
 */
class Order extends CActiveRecord
{
    const START_STATUS = 1;
    const PROCESS_STATUS = 2;
    const FINISH_STATUS = 3;
    const CANCELLED_STATUS = 4; 
    
    const NOTIF_FREQ_ORDER = 1;
    const NOTIF_FREQ_TASK = 2;
    
    public $products_details = '';
    /**
     * Order statuses values
     */
    public static $statuses = array(
        1 => 'Pending',
        2 => 'In Process',
        3 => 'Delivered',
        4 => 'Cancelled',
    );
    
    public static $statuses_styles = array(
        1 => 'pending',
        2 => 'in-process',
        3 => 'delivered',
        4 => 'cancelled',
    );    
    

    
    public $user_email = '';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getIntervalDate($date_from, $interval)
    {
        //if first task
        if (!$date_from) {
            $date_from = time();
            $interval = 1;
        }
        
        $potential_date = $date_from + $interval * 24 * 3600/* 24 * 3600 seconds in day*/;
        
        return in_array(date('D', $potential_date), array('Sat','Sun')) ? $this->getIntervalDate($potential_date, 1) : $potential_date;
    }    
    
    public function createByCart($params)
    {
        if (!empty($params['items'])){
            $this->id = $params['id'];
            $this->time_interval = $params['items'][0]->time_interval;
            $this->total = $params['total'];
            $this->user_id = $params['items'][0]->user_id;
            $this->payment_method = $params['payment_method'];
            $this->payment_status = $params['payment_status'];
            $this->transaction_id = $params['transaction_id'];
            
            if (!$this->save()) {
                print_r($this->getErrors());
                exit;
            }
            
            $task_date = 0;

            foreach($params['items'] as $citem) {
                $o2p = new OrderToProduct;
                
                $o2p->order_id = $this->id;
                $o2p->product_id = $citem->product->id;
                $o2p->anchor = $citem->anchor;
                $o2p->comment = $citem->comment;
                $o2p->url = $citem->url;
                $o2p->price = $citem->product->price;

                $task_date = $this->getIntervalDate($task_date, $this->time_interval);
                $o2p->task_date = date('Y-m-d', $task_date);
                $o2p->date_start = date('Y-m-d');
                $o2p->save();
                
                $citem->delete();
            }
            
            $user = User::model()->findByPk($this->user_id);
            $user->orders_num += 1;
            $user->websites_num += $params['count'];
            $user->update();            
            
        }
    }
    
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->time = date('Y-m-d H:i:s');
            $this->status = self::START_STATUS;
        }
        return parent::beforeValidate();
    }
    
    public function timeInt()
    {
        return strtotime($this->time);
    }
    
    static public function genID()
    {
        //potential error, if several orders in one second
        $last_id = Yii::app()->db->createCommand()
                             ->select('MAX(id)')
                             ->from(Order::model()->tableSchema->name)->queryScalar();
        return ($last_id ? $last_id : 15142/*any value for first order id*/) + rand(1,20);
    }
    
    public function getProductsList()
    {
        $arr = array();
        foreach ($this->orderedProductsDetails as $d) {
            $p = Product::model()->findByPk($d->product_id);
            
            if (empty($p)){
                print 'ID 404 '. $d->product_id;
                continue;
            } else {
            $t = array(
                'title' => $p->title,
                'status_name' => self::$statuses[$d->status],
                'status' => $d->status,
                'url' => $d->url,
                'product_id' => $p->id,
            );
            $arr[] = $t;}
        }
        return $arr;
    }
    
    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }
    
    public function getStatusStyle()
    {
        return self::$statuses_styles[$this->status];
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total,notif_frequency', 'numerical'),
			array('id, user_id', 'length', 'max'=>11),
			array('status, payment_status', 'length', 'max'=>2),
			array('time_interval', 'length', 'max'=>5),
			array('time, payment_method,', 'safe'),
            array('id, user_id, status', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, status, user_id, total, user_email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'orderedProductsDetails'=>array(self::HAS_MANY, 'OrderToProduct', 'order_id', 'order'=>'task_date'),
            'products'=>array(self::MANY_MANY, 'Product', 'order_to_product(order_id, product_id)'),
            'products_count'=>array(self::STAT, 'OrderToProduct', 'order_id'),
		);
	}

    public function getReportData($user_id)
    {
        $report_data = array();
        $criteria = new CDbCriteria;
        $criteria->select = '*, DATE_FORMAT(time,"%m-%d-%Y") time';
        $criteria->condition = 'user_id=:uid';
        $criteria->params = array(':uid' => $user_id);
        $criteria->order = 'id DESC';
        
        $orders = $this->findAll($criteria);
        foreach ($orders as $o) {
            $report_data[$o->id]['order'] = $o;
            $report_data[$o->id]['ordered_products'] = $o->orderedProductsDetails;
           
            foreach (self::$statuses as $k=>$v) $report_data[$o->id]['statuses'][$k]=0;
            foreach($report_data[$o->id]['ordered_products'] as $op){
                $report_data[$o->id]['statuses'][$op->status]++;
            }
        }

        return $report_data;
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time' => 'Time',
			'status' => 'Status',
			'user_id' => 'User',
			'time_interval' => 'Time Interval',
			'total' => 'Total Price',
			'payment_method' => 'Payment Method',
			'payment_status' => 'Payment Status',
            'products_details' => '',
		);
	}
    public function updateCorrespondingStatus(OrderToProduct $otp) {
        $statuses = array();
        $new_status = $this->status;
        
        foreach ($this->orderedProductsDetails as $p) {
            $statuses[$p->status] = isset($statuses[$p->status]) ? $statuses[$p->status] + 1 : 1;
        }
        
        //if all cancelled
        if (isset($statuses[self::CANCELLED_STATUS]) 
                && count($this->products) == $statuses[self::CANCELLED_STATUS]) {
            $new_status = self::CANCELLED_STATUS;
        } 
        //if all finished
        elseif (isset($statuses[self::FINISH_STATUS]) 
                && (count($this->products) - (isset($statuses[self::CANCELLED_STATUS]) ? $statuses[self::CANCELLED_STATUS] : 0)) == $statuses[self::FINISH_STATUS]) {
            $new_status = self::FINISH_STATUS;
        }
        //if any in process
        elseif(isset($statuses[self::PROCESS_STATUS]) && $statuses[self::PROCESS_STATUS] 
                || isset($statuses[self::FINISH_STATUS]) && $statuses[self::FINISH_STATUS]) {
            $new_status = self::PROCESS_STATUS;
        }
        
        
        //send customer notification
        if ($new_status != $this->status && $new_status == self::FINISH_STATUS){
            $html = Yii::app()->getController()->renderPartial('//order/_order_email_html', array('order'=>$this), true);
            $text = Yii::app()->getController()->renderPartial('//order/_order_email_text', array('order'=>$this), true);

            Yii::app()->mail->send($html, $text, 'Your order (Invoice #: '.$this->id.')  is completely done', Yii::app()->params['emailNotif']['from_email'], $this->user->email);
        }elseif($otp->status == self::FINISH_STATUS && $this->notif_frequency == self::NOTIF_FREQ_TASK){
            $html = Yii::app()->getController()->renderPartial('//order/_task_email_html', array('order'=>$this), true);
            $text = Yii::app()->getController()->renderPartial('//order/_task_email_text', array('order'=>$this), true);

            Yii::app()->mail->send($html, $text, 'New publication is ready and published', Yii::app()->params['emailNotif']['from_email'], $this->user->email);
        }
        
        // save new status
        if ($new_status != $this->status){
            $this->status = $new_status;
            $this->save();
        }
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $sort=new CSort;
        
		$criteria->compare('id',$this->id,true);
		$criteria->compare('time',$this->time,true);
        
        if (isset($this->status) && $this->status == 0) unset($this->status);
        else $criteria->compare('status',$this->status,true);
                
        if (!empty($this->user_email)) {
            $criteria->with = array(
                'user' => array(
                    'condition' => "email LIKE :ue",
                    'params' => array(':ue' => '%'.$this->user_email.'%'),
                )
            );
            $criteria->together = true;
        }
		
        $criteria->compare('total',$this->total);

        $sort->defaultOrder= array(
            'id'=>CSort::SORT_DESC,
        );        
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,
		));
	}
}