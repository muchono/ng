<?php

/**
 * This is the model class for table "cart".
 *
 * The followings are the available columns in table 'cart':
 * @property string $id
 * @property string $user_id
 * @property string $product_id
 * @property string $index
 * @property string $time
 * @property string $anchor
 * @property integer $time_interval
 * @property integer $comment
 * @property integer $url
 */
class Cart extends CActiveRecord
{
   	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function changePos($to)
    {
        $to = (int) $to;
        if ($this->index != $to){
            if ($to > $this->index) {
                Yii::app()->db->createCommand()
                    ->update($this->tableName(), array(
                        'index'=>new CDbExpression('`index` - 1'),
                    ), 'user_id='.Yii::app()->user->profile->id.' AND `index` > ' . $this->index .' AND `index` <= ' . $to);
            } else {
                Yii::app()->db->createCommand()
                    ->update($this->tableName(), array(
                        'index'=>new CDbExpression('`index` + 1'),
                    ), 'user_id='.Yii::app()->user->profile->id.' AND `index` >= ' . $to .' AND `index` < ' . $this->index);
            }
            $this->index = $to;
            $this->update();
        }
    }
    
    public static function getByUser($user_id)
    {
        $total = 0;
        
        $criteria=new CDbCriteria;
        $criteria->condition='user_id=:uid';
        $criteria->params=array('uid'=>$user_id);
        $criteria->order='`index`';
        
        $items = Cart::model()->findAll($criteria);
        foreach($items as $i){
            $total += $i->product->price;
        }
        return array(
            'count' => count($items),
            'total' => $total,
            'items' => $items,
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cart';
	}
    
    public function requiredAnchor()
    {
        if(empty($this->anchor) && $this->product->isAnchorAvailable())
            $this->addError('anchor','Anchor cannot be blank.');
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time_interval', 'numerical'),
			array('user_id, product_id', 'required'),
			array('time ,url, anchor, comment', 'safe'),
			array('user_id, product_id', 'length', 'max'=>11),
			array('comment', 'length', 'max'=>1000),
			array('index', 'length', 'max'=>3),
			array('product_id', 'notInCart'),
			array('anchor', 'length', 'max'=>255),
			array('url', 'length', 'max'=>255),
			array('comment', 'length', 'max'=>1000),
            array('url', 'required', 'on'=>'SubmitDetails'),
            array('anchor', 'requiredAnchor', 'on'=>'SubmitDetails'),
            array('url', 'url', 'on'=>'SubmitDetails'),            
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'product_id' => 'Product',
			'index' => 'Index',
			'time' => 'Time',
			'comment' => 'Comment',
		);
	}

    protected function beforeSave()
    {
        if ($this->isNewRecord){
            $this->time = new CDbExpression('NOW()');
            $this->index = $this->count('user_id=:uid', array('uid'=>Yii::app()->user->profile->id));
        }
        return parent::beforeSave();
    }
    
	/**
	 * Check if the product is in cart already.
     * This is the validator as declared in rules().
	 */    
    public function notInCart()
    {
        if ($this->isNewRecord){
            $item = $this->find('user_id=:uid AND product_id=:pid', array('uid'=>$this->user_id, 'pid'=>$this->product_id));
            if (!empty($item)) {
                $this->addError('product_id', 'The product is in cart already');
            }
        }
    }
}