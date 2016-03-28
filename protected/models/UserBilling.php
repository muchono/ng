<?php

/**
 * This is the model class for table "user_billing".
 *
 * The followings are the available columns in table 'user_billing':
 * @property string $id
 * @property string $user_id
 * @property string $full_name
 * @property string $company_name
 * @property string $country
 * @property string $address
 * @property string $zip
 * @property string $city
 * @property integer $payment
 * @property integer $agreed
 */
class UserBilling extends CActiveRecord
{
    public function scenarios()

    {
        
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserBilling the static model class
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
		return 'user_billing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, country, payment, address, zip, city, agreed', 'required'),
            array('full_name', 'checkName'),
            array('agreed', 'compare', 'compareValue' => 1, 'message' => 'Please read Terms of Use'),
			array('agreed', 'numerical', 'integerOnly'=>true),
			array('user_id, country', 'length', 'max'=>11),
			array('full_name, company_name, address, zip, city', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, full_name, company_name, country, address, zip, city, payment, agreed', 'safe', 'on'=>'search'),
		);
	}

    public function checkName()
    {
        if (!trim($this->full_name) && !trim($this->company_name))
            $this->addError('full_name','Please enter Full Name or Company Name.');
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'countryInfo'=>array(self::BELONGS_TO, 'Countries', 'country'),
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
			'full_name' => 'Full Name',
			'company_name' => 'Company Name',
			'country' => 'Country',
			'address' => 'Address',
			'zip' => 'Zip',
			'city' => 'City',
			'payment' => 'Payment',
			'agreed' => 'Agreed',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('payment',$this->payment);
		$criteria->compare('agreed',$this->agreed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}