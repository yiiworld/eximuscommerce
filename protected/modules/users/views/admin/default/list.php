<?php
    // Display list of users

    $this->pageHeader = Yii::t('UsersModule.core', 'Список пользователей');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('UsersModule.core', 'Пользователи'),
    );
      
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('new'),
        'elements'=>array(
            'new'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>Yii::t('UsersModule.core', 'Создать пользователя'),
                'options'=>array(
                    'icons'=>array('primary'=>'ui-icon-person')
                )
            ),
        ),
    ));

    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$model->search(),
        'id'=>'usersListGrid',
        'filter'=>$model,
        'columns'=>array(
            'id' ,
            array(
                'name'=>'username',
                'value'=>'CHtml::link($data->username,array("update","id"=>$data->id))',
                'type'=>'raw',
            ),
            'email',
            array(
                'name'=>'created_at',
            ),
            array(
                'name'=>'last_login',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));

