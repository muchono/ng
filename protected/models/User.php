<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $orders_num
 * @property string $websites_num
 * @property string $subscribe
 * @property string $active
 * @property string $password
 * @property string $resource
 * @property boolean $registration_confirmed
 * @property boolean $fb
 */
class User extends CActiveRecord
{
    public $password_confirm = '';
    
    protected $oldAttributes;
    
    public function afterFind(){
        $this->oldAttributes = $this->attributes;
        $this->password_confirm = $this->password;
        return parent::afterFind();
    }
    
    public function addFB($info)
    {
        $this->email = $info['email'];
        $this->name = $info['name'];                
        $this->password = $this->password_confirm = 'p31FBNL';//default for FB user
        $this->fb = 1;
        $this->active = 0;
        $this->subscribe = 1;
        $this->registration_confirmed = 0;
        $this->save();
    }
    
	/**
     * Get string hash for registration confirmation code
     * @return string
     */
    public function getRegistrationConfirmationCode()
    {
        return urlencode(crypt($this->id, 'saltf234f_ghLdfg'));
    }
    
    /**
     * Confirm user registration
     * @return void
     */
    public function confirmRegistration()
    {
        $model->registration_confirmed=1;
        $model->active=1;
        $model->update(array('registration_confirmed', 'active'));
    }

    protected function beforeSave()
    {
        if (!empty($this->password) && $this->oldAttributes['password'] != $this->password) {
            $this->password = UserIdentityCustomer::getPWDHash($this->password);
        } else unset($this->password);
        unset($this->password_confirm);
        
        return parent::beforeSave();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_confirmed, fb', 'boolean'),
			array('email, name,password,password_confirm', 'length', 'max'=>255),
			array('resource', 'length', 'max'=>50),
			array('orders_num, websites_num', 'length', 'max'=>11),
			array('subscribe, active', 'length', 'max'=>1),
			array('email', 'email'),
			array('email', 'unique', 'message'=>'This user already exists in the system.'),
			array('name', 'required', 'message'=>'Please enter a {attribute}.'),
			array('email', 'required', 'message'=>'Please enter an {attribute}.'),
			array('password, password_confirm', 'required', 'on'=>'insert', 'message'=>'Please enter a {attribute}.'),
            array('password_confirm', 'compare', 'compareAttribute'=>'password','on'=>'insert,settings,update'),
            array('password,password_confirm', 'safe','on'=>'settings'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, name, orders_num, websites_num, subscribe, active', 'safe', 'on'=>'search'),
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
            'billing'=>array(self::HAS_ONE, 'UserBilling', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email Address',
			'name' => 'Username',
			'orders_num' => 'Orders Number',
			'websites_num' => 'Websites Number',
			'subscribe' => 'Subscribe',
			'active' => 'Active',
			'password' => 'Password',
			'password_confirm' => 'Confirm Password',            
		);
	}
    
    /**
     * Find By E-mail
     * @param string $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->find('email=:email', array('email'=>trim($email)));
    }
    
    public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'active=1',
            ),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('orders_num',$this->orders_num,true);
		$criteria->compare('websites_num',$this->websites_num,true);
		$criteria->compare('subscribe',$this->subscribe,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>30,
            ),            
		));
	}
}