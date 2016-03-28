<?php

/**
 * This is the model class for table "writer".
 *
 * The followings are the available columns in table 'writer':
 * @property string $id
 * @property string $name
 * @property string $payment_id
 * @property string $assign_date
 */
class Writer extends CActiveRecord
{
    const BOARD_TASK_INTERVAL_MONTH = 1;

    public function findAllNames()
    {
        return Yii::app()->db->createCommand()
                          ->select('name')
                          ->from($this->tableName())
                          ->order('name')
                          ->queryColumn();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Writer the static model class
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
		return 'writer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, payment_id, assign_date', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, payment_id', 'safe', 'on'=>'search'),
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
            'tasks'=>array(self::HAS_MANY, 'OrderToProduct', 'writer_id',
                           'condition'=>$this->getTaskCondition()
                    ),
            //'Count' => array(self::STAT, 'Artist', 'some_id'),

            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'payment_id' => 'Payment',
		);
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('payment_id',$this->payment_id,true);
        
        $criteria->mergeWith(array(
            'join'=>'INNER JOIN order_to_product tasks ON tasks.writer_id = t.id',
            'condition'=>$this->getTaskCondition(),
        ));
       
        $criteria->order = 't.assign_date DESC';
        $criteria->group = 't.id';
		return new CActiveDataProvider($this, array(
            'pagination'=>false,
			'criteria'=>$criteria,
		));
	}
    
    protected function getTaskCondition()
    {
        return 'tasks.task_date > DATE_SUB(NOW(), INTERVAL '.self::BOARD_TASK_INTERVAL_MONTH.' MONTH) OR tasks.status = ' . Order::PROCESS_STATUS;
    }
}