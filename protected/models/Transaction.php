<?php

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property integer $id
 * @property integer $user_id
 * @property string $payment
 * @property double $price
 * @property integer $success
 * @property string $response_details
 * @property string $time
 */
class Transaction extends CActiveRecord
{
    public function appendResponse($r)
    {
        $this->response_details = $this->response_details . ' REQ-JSON:  ' . json_encode($r);
    }
    
    /**
     * before save
     */
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->profile->id;
            $this->time = date('Y-m-d H:i:s');
        }

        return parent::beforeSave();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transactions the static model class
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, time', 'required'),
			array('success', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id', 'length', 'max'=>11),
			array('payment', 'length', 'max'=>40),
			array('response_details', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'payment' => 'Payment',
			'price' => 'Price',
			'success' => 'Success',
			'response_details' => 'Details',
			'time' => 'Time',
		);
	}
}