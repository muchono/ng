<?php

/**
 * This is the model class for table "order_to_product".
 *
 * The followings are the available columns in table 'order_to_product':
 * @property string $order_id
 * @property string $product_id
 * @property string $anchor
 * @property string $comment
 * @property string $status
 * @property string $writerName
 * @property double $price
 * @property string $url
 * @property string $url_res last assign date
 */
class OrderToProduct extends CActiveRecord
{
    const START_STATUS = 1;
       
    protected $oldAttributes;

    
    public function afterFind()
    {
        $this->oldAttributes = $this->attributes;
        return parent::afterFind();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderToProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_to_product';
	}

    /**
     * check writer 
     */
    public function requiredWriter($attribute,$params)
    {
        if($this->status == Order::PROCESS_STATUS
                && empty($this->$attribute)) {
          $this->addError($attribute, 'Please enter the Writer Name');
        }
    }
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, status', 'numerical'),
			array('order_id, product_id', 'length', 'max'=>11),
			array('anchor', 'length', 'max'=>255),
			array('comment', 'length', 'max'=>1000),
            array('writerName', 'requiredWriter', 'on' => 'SaveTask'),
            array('url, order_id, product_id', 'required'),
            array('url_res', 'required', 'on' => 'deliveredStatus'),
            array('url,url_res', 'url'),
            array('writerName', 'safe'),
            array('status', 'in', 'range' => array_keys(Order::$statuses)),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_id, product_id, anchor, comment, status, price', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id'),
            'writer'=>array(self::BELONGS_TO, 'Writer', 'writer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'product_id' => 'Product',
			'anchor' => 'Anchor',
			'comment' => 'Comment',
			'status' => 'Status',
			'writerName' => 'Writer Name',
			'price' => 'Price',
			'task_date' => 'Task Date',
			'url_res' => 'Post Url',
		);
	}
    
    public function afterSave() 
    {
        parent::afterSave();
        if ($this->isNewRecord) {
            //add products statistics
            $product = Product::model()->findByPk($this->product_id);
            $product->orders += 1;
            $product->save();

            //add categories statistics
            foreach($product->categories as $c){
                $c->sale_num += 1;
                
                $c->coefficient = $c->view_num ? round($c->sale_num / $c->view_num, 2) : 0;
                $c->save();
            }
        } else {
            if(isset($this->oldAttributes['status']) && $this->status != $this->oldAttributes['status']){
                Order::model()->findByPk($this->order_id)->updateCorrespondingStatus($this);
            }
        }
    }
    
    public function beforeSave() 
    {
        //convert writer name to writer ID
        if (!empty($this->writerName)) {
            $this->writerName = trim($this->writerName);
            $writer = Writer::model()->find(array(
                'condition'=>'name LIKE :name',
                'params'=>array(':name'=>$this->writerName),
                )
            );
            if (empty($writer)) {
                $writer = new Writer();
                $writer->name = $this->writerName;
                $writer->save();
            }
            $this->writer_id = $writer->id;
        }
        unset($this->writerName);
        
        if ($this->isNewRecord) {

        } else {
            //update date_start value
            if(isset($this->oldAttributes['status']) 
                    && $this->status != $this->oldAttributes['status'] 
                    && $this->status == Order::PROCESS_STATUS){
                $this->date_start = date('Y-m-d');
                $this->writer->assign_date = $this->date_start;
                $this->writer->save();
            }
        }
        
        return parent::beforeSave();
    }
    
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = self::START_STATUS;
        }
        return parent::beforeValidate();
    }
    
    public function getForDate($date = '')
    {
        $date = empty($date) ? date('Y-m-d') : $date;
        
        $criteria=new CDbCriteria;
        $criteria->compare('task_date', $date,true);
        $criteria->compare('status', Order::START_STATUS,true);
		
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function getWriterName()
    {
        return $this->writer_id ? $this->writer->name : '';
    }
    
    public function setWriterName($param)
    {
        return $this->writerName=$param;
    }
    

    public static function dateReFormate($date)
    {
        list($d,$m,$y) = explode('/', $date);
        return $y.'-'.$m.'-'.$d;
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

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('anchor',$this->anchor,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}