<?php

/**
 * This is the model class for table "StoreDeliveryMethods".
 *
 * The followings are the available columns in table 'StoreDeliveryMethods':
 * @property integer $id
 * @property string $name
 * @property boolean $active
 * @property string $description
 * @property integer $position
 */
class StoreDeliveryMethod extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreDeliveryMethod the static model class
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
		return 'StoreDeliveryMethod';
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'active'=>array('order'=>$alias.'.active=1'),
			'orderByPosition'=>array('order'=>$alias.'.position ASC'),
			'orderByPositionDesc'=>array('order'=>$alias.'.position DESC'),
			'orderByName'=>array('order'=>$alias.'.name ASC'),
			'orderByNameDesc'=>array('order'=>$alias.'.name DESC'),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('active', 'boolean'),
			array('name', 'length', 'max'=>255),
			array('description', 'type', 'type'=>'string'),

			array('id, name, description, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Before save event
	 */
	public function beforeSave()
	{
		if(empty($this->position) === true)
		{
			$max = StoreDeliveryMethod::model()->orderByPositionDesc()->find();
			if($max)
				$this->position = $max->position + 1;
		}
		return parent::beforeSave();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name'        => Yii::t('StoreModule.core', 'Название'),
			'active'      => Yii::t('StoreModule.core', 'Активен'),
			'description' => Yii::t('StoreModule.core', 'Описание'),
			'position'    => Yii::t('StoreModule.core', 'Позиция'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('active',$this->active);

		$sort=new CSort;
		$sort->defaultOrder = $this->getTableAlias().'.position ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}