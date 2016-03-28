<?php

/**
 * This is the model class for table "product_category".
 *
 * The followings are the available columns in table 'product_category':
 * @property string $id
 * @property string $title
 * @property string $view_num
 * @property string $sale_num
 * @property string $product_num
 * @property string $product_general_num
 * @property string $coefficient
 */
class ProductCategory extends CActiveRecord
{
    //general category id
    const GENERAL_CATEGORY_ID = 1;
    
    static public function addView($id)
    {
        Yii::app()->db->createCommand('UPDATE product_category SET view_num = view_num + 1 WHERE id = '. (int) $id)->query();
    }
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Update number of products for the list of categories
     * @param array list of categories
     */
    public static function updateProductNumbers()
    {
        $model_general = self::model()->findByPk(self::GENERAL_CATEGORY_ID);
        foreach (self::model()->findAll() as $c) {
            $c->product_num = $c->productCount;
            $c->product_general_num = ($c->id == self::GENERAL_CATEGORY_ID) ? $c->product_num : $c->product_num + $model_general->productCount;
            $c->update();
        }
    }

    /**
     * delete
     */
    public function delete()
    {
        ProductToCategory::model()->deleteAllByAttributes(array('category_id' => $this->id));
        parent::delete();
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
			array('view_num, sale_num, product_num, product_general_num', 'length', 'max'=>11),
			array('title', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, view_num, sale_num, product_num, product_general_num, coefficient', 'safe', 'on'=>'search'),
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
            'productCount'=>array(self::STAT, 'ProductToCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'view_num' => 'Views Number',
			'sale_num' => 'Sales Number',
			'product_num' => 'Sites Number',
			'product_general_num' => 'Sites General Number',
            'coefficient'=>'Coefficient',
		);
	}

    public function scopes()
    {
        return array(
            'sort_asc'=>array(
                'order'=>'sort_order, title',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('view_num',$this->view_num,true);
		$criteria->compare('sale_num',$this->sale_num,true);
		$criteria->compare('product_num',$this->product_num,true);
		$criteria->compare('product_general_num',$this->product_general_num,true);
		$criteria->compare('coefficient',$this->coefficient,true);
        
        $criteria->compare('product_general_num',$this->product_general_num,true);
        $criteria->scopes = 'sort_asc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>30,
            ),

		));
	}
}